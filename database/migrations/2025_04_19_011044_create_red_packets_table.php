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
        Schema::create('red_packet_claims', function (Blueprint $table) {
            $table->id(); // 主鍵
            $table->foreignId('red_packet_id')->constrained(); // 關聯紅包 ID
            $table->unsignedBigInteger('user_id'); // 使用者 ID
            $table->integer('amount'); // 搶到的金額
            $table->timestamps();
        });
        
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('red_packets');
    }
};
