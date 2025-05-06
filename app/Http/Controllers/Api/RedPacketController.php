<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\RedPacket;
use Illuminate\Support\Facades\Redis;
use App\Jobs\RecordRedPacketClaim;
use App\Models\User;
use Illuminate\Http\JsonResponse;

class RedPacketController extends Controller
{
    public function create(Request $request): JsonResponse
    {
        $amount = (int) $request->input('amount');
        $count = (int) $request->input('count');

        if ($amount <= 0 || $count <= 0) {
            return response()->json(['error' => '金額與數量必須大於 0'], 422);
        }

        $packet = RedPacket::create([
            'total_amount' => $amount,
            'total_count' => $count
        ]);

        $amounts = $this->split($amount, $count);
        if (empty($amounts)) {
            return response()->json(['error' => '紅包拆分失敗'], 500);
        }

        $key = "red_packet:{$packet->id}";
        foreach ($amounts as $a) {
            Redis::lpush($key, $a);
        }

        return response()->json(['id' => $packet->id]);
    }

    private function split(int $total, int $count): array
    {
        $result = [];
        $remain = $total;
        for ($i = 0; $i < $count - 1; $i++) {
            $max = intval(($remain / ($count - $i)) * 2);
            $r = mt_rand(1, max(1, $max));
            $result[] = $r;
            $remain -= $r;
        }
        $result[] = $remain;
        shuffle($result);
        return $result;
    }

    public function grab(Request $request, int $id): JsonResponse
    {
        $userId = $request->input('user_id');
        if (!$userId) {
            return response()->json(['message' => '請提供 user_id'], 400);
        }

        $setKey = "red_packet_claimed:$id";
        $listKey = "red_packet:$id";
        $rankKey = "red_packet_rank:$id";

        if (Redis::sismember($setKey, $userId)) {
            return response()->json(['message' => '已領取']);
        }

        $amount = Redis::rpop($listKey);
        if (!$amount) {
            return response()->json(['message' => '紅包搶完了']);
        }

        $amount = (int) $amount;

        Redis::sadd($setKey, $userId);
        Redis::zadd($rankKey, $amount, $userId);

        dispatch(new RecordRedPacketClaim($id, $userId, $amount));

        return response()->json(['amount' => $amount]);
    }

    public function rank(int $id): JsonResponse
    {
        $rankKey = "red_packet_rank:$id";
        $list = Redis::zrevrange($rankKey, 0, 9, ['withscores' => true]);

        $userIds = array_keys($list);
        $users = User::whereIn('id', $userIds)->get()->keyBy('id');

        $res = [];
        foreach ($list as $uid => $amt) {
            $res[] = [
                'user_id' => $uid,
                'name' => $users[$uid]->name ?? '匿名',
                'amount' => $amt
            ];
        }

        return response()->json($res);
    }

    public function left(int $id): JsonResponse
    {
        $key = "red_packet:$id";
        $count = Redis::llen($key);
        return response()->json(['left' => $count]);
    }
}