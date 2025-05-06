<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;




use Illuminate\Database\Eloquent\Model;

class RedPacketClaim extends Model
{
    protected $fillable = ['red_packet_id', 'user_id', 'amount'];
}
