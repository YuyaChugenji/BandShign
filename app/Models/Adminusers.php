<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Adminusers extends Model
{
    // テーブル名
    protected $table = 'adminusers';

    // 可変項目
    protected $fillable =
    [
        'name',
        'email',
    ];

    //public $timestamps = false;
}
