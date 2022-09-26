<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Livehouseusers extends Model
{
    // テーブル名
    protected $table = 'livehouseusers';

    // 可変項目
    protected $fillable =
    [
        'name',
        'email',
        'password',
        'image',
        'postcode',
        'prefecture_id',
        'city',
        'block',
        'building',
        'biography',
        'del_flg',
    ];


    public function bandusers()
{
    return $this->belongsToMany(banduser::class);
}
    
}
