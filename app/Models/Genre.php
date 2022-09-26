<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Genre extends Model
{
    // テーブル名
    protected $table = 'genres';
 
    //
public function banduser()
{
    return $this->hasMany('banduser');
}

}