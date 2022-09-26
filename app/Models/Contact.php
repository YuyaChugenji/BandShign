<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{
    // テーブル名
    protected $table = 'contacts';

    // 可変項目
    protected $fillable =
    [
        'name',
        'kana',
        'email',
        'messege',
    ];

    //public $timestamps = false;
}
