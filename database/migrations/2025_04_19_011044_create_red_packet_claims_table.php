<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('red_packets', function (Blueprint $table) {
            $table->id(); // 自動編號主鍵
            $table->integer('total_amount'); // 總金額
            $table->integer('total_count');  // 拆成幾個紅包
            $table->timestamps(); // created_at 和 updated_at
        });
        
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('red_packet_claims');
    }
};
