<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class banduser extends Model
{
    // テーブル名
    protected $table = 'bandusers';
    

    // 可変項目
    protected $fillable =
    [
        'name',
        'email',
        'password',
        'genre_id',
        'prefecture_id',
        'city',
        'biography',
        'image',
        'del_flg',
    ];

    public function livehouseusers()
{
    return $this->belongsToMany(livehouseusers::class);
}

}