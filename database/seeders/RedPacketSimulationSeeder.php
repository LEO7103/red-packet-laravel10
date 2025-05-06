<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Http;

class RedPacketSimulationSeeder extends Seeder
{
    public function run(): void
    {
        $redPacketId = 1; // 測試用紅包 ID，請先建立一個紅包（amount=1000 count=100）

        for ($userId = 1; $userId <= 100; $userId++) {
            $response = Http::post("http://localhost:8000/api/red-packet/{$redPacketId}/grab", [
                'user_id' => $userId
            ]);

            $data = $response->json();

            echo "👤 User {$userId}：";
            if (isset($data['amount'])) {
                echo "搶到紅包 💰：{$data['amount']} 元\n";
            } elseif (isset($data['message'])) {
                echo "⚠️ {$data['message']}\n";
            } else {
                echo "❌ 發生錯誤\n";
            }
        }

        // 顯示剩餘紅包數量
        $remaining = Http::get("http://localhost:8000/api/red-packet/{$redPacketId}/left")->json();
        echo "\n📦 紅包剩餘：" . ($remaining['left'] ?? '無法取得') . "\n";
    }
}