<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Like extends Model
{
    // テーブル名
    protected $table = 'likes';

    // 可変項目
    protected $fillable =
    [
        'user_id',
        'post_id',
    ];

    public $timestamps = false;

}
