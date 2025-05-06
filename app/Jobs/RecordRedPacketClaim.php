<?php

namespace App\Jobs;

use App\Models\RedPacketClaim;

class RecordRedPacketClaim implements \Illuminate\Contracts\Queue\ShouldQueue
{
    use \Illuminate\Bus\Queueable, \Illuminate\Queue\SerializesModels;

    public function __construct(
        public int $packetId,
        public int $userId,
        public int $amount
    ) {}

    public function handle()
    {
        // 儲存至資料庫（避免同步 IO 遲滯）
        RedPacketClaim::create([
            'red_packet_id' => $this->packetId,
            'user_id' => $this->userId,
            'amount' => $this->amount
        ]);
    }
}
