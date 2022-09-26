<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\banduser;


class LikeController extends Controller
{
    public function store($id)
    {
        banduser::id()->like($id);
        return 'ok!'; //レスポンス内容
    }

    public function destroy($id)
    {
        banduser::id()->unlilikeke($id);
        return 'ok!'; //レスポンス内容
    }
}