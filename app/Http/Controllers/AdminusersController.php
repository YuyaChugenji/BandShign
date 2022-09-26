<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use App\Models\adminusers;
use App\Models\banduser;
use App\Models\Livehouseusers;
use App\Models\Prefecture;
use App\Models\Genre;
use App\Models\Contact;

use App\Mail\ContactSendmail;

class AdminusersController extends BaseController {

    // ライブハウスメインページ
    public function adminlivehouseindex(Request $request) {

        // sessionからログインしたユーザーのIDを取り出す
        $userid = session()->get('id');
        $userprefectureid = session()->get('prefecture_id');
        $kerberos_flg = session()->get('kerberos_flg');

        // 不正ログイン対策
        if ($kerberos_flg != 3) {
            return redirect('/index');
            exit;
        }

        $prefecture = $request->input('prefecture');
        $selectprefecture = $prefecture;
        $test = $prefecture;
        $keyword = $request->input('keyword');
        $genre = $request->input('genre');
        $selectgenre = $genre;

        // ログインしたユーザーの地域のバンドを表示
        $query = DB::table('bandusers')
        ->where('del_flg', '=', 0)
        ->where('prefecture_id', 'LIKE', $userprefectureid)
        ->select('bandusers.id','name','email','password','genre_id','prefecture_id','city','biography','image','genre','prefecture')
        ->join('genres', 'bandusers.genre_id', '=', 'genres.id') 
        ->join('prefectures', 'bandusers.prefecture_id', '=', 'prefectures.id') 
        ->paginate(10);

        // 都道府県もジャンルも全てを選択
        if($prefecture == "全て" && $genre == "全て") {
        $query = DB::table('bandusers')
        ->where('del_flg', '=', 0)
        ->select('bandusers.id','name','email','password','genre_id','prefecture_id','city','biography','image','genre','prefecture','del_flg')
        ->join('genres', 'bandusers.genre_id', '=', 'genres.id') 
        ->join('prefectures', 'bandusers.prefecture_id', '=', 'prefectures.id') 
        ->paginate(10);
        }

        // 都道府県もジャンルも全てを選択しキーワードがある
        if($prefecture == "全て" && $genre == "全て" && !empty($keyword)) {
        $query = DB::table('bandusers')
        ->where('del_flg', '=', 0)
        ->where('biography', 'LIKE', "%{$keyword}%")
        ->select('bandusers.id','name','email','password','genre_id','prefecture_id','city','biography','image','genre','prefecture','del_flg')
        ->join('genres', 'bandusers.genre_id', '=', 'genres.id') 
        ->join('prefectures', 'bandusers.prefecture_id', '=', 'prefectures.id') 
        ->paginate(10);
        }

        // 都道府県がありジャンルは全てを選択しキーワードがある
        if($prefecture != "全て" && $genre == "全て" && !empty($keyword)) {
        $query = DB::table('bandusers')
        ->where('del_flg', '=', 0)
        ->where('prefecture', 'LIKE', $prefecture)
        ->where('biography', 'LIKE', "%{$keyword}%")
        ->select('bandusers.id','name','email','password','genre_id','prefecture_id','city','biography','image','genre','prefecture','del_flg')
        ->join('genres', 'bandusers.genre_id', '=', 'genres.id') 
        ->join('prefectures', 'bandusers.prefecture_id', '=', 'prefectures.id') 
        ->paginate(10);
        }

        // 都道府県がありジャンルは全てを選択しキーワードなし
        if($prefecture != "全て" && $genre == "全て" && empty($keyword)) {
        $query = DB::table('bandusers')
        ->where('del_flg', '=', 0)
        ->where('prefecture', 'LIKE', $prefecture)
        ->select('bandusers.id','name','email','password','genre_id','prefecture_id','city','biography','image','genre','prefecture','del_flg')
        ->join('genres', 'bandusers.genre_id', '=', 'genres.id') 
        ->join('prefectures', 'bandusers.prefecture_id', '=', 'prefectures.id') 
        ->paginate(10);
        }

        // 都道府県が全てジャンルはありを選択しキーワードがある
        if($prefecture == "全て" && $genre != "全て" && !empty($keyword)) {
        $query = DB::table('bandusers')
        ->where('del_flg', '=', 0)
        ->where('genre', 'LIKE', $genre)
        ->where('biography', 'LIKE', "%{$keyword}%")
        ->select('bandusers.id','name','email','password','genre_id','prefecture_id','city','biography','image','genre','prefecture','del_flg')
        ->join('genres', 'bandusers.genre_id', '=', 'genres.id') 
        ->join('prefectures', 'bandusers.prefecture_id', '=', 'prefectures.id') 
        ->paginate(10);
        }

        // 都道府県が全てジャンルはありを選択しキーワードがある
        if($prefecture == "全て" && $genre != "全て" && !empty($keyword)) {
        $query = DB::table('bandusers')
        ->where('del_flg', '=', 0)
        ->where('genre', 'LIKE', $genre)
        ->where('biography', 'LIKE', "%{$keyword}%")
        ->select('bandusers.id','name','email','password','genre_id','prefecture_id','city','biography','image','genre','prefecture','del_flg')
        ->join('genres', 'bandusers.genre_id', '=', 'genres.id') 
        ->join('prefectures', 'bandusers.prefecture_id', '=', 'prefectures.id') 
        ->paginate(10);
        }

        // 都道府県が全てジャンルはありを選択しキーワードがなし
        if($prefecture == "全て" && $genre != "全て" && empty($keyword)) {
        $query = DB::table('bandusers')
        ->where('del_flg', '=', 0)
        ->where('genre', 'LIKE', $genre)
        ->select('bandusers.id','name','email','password','genre_id','prefecture_id','city','biography','image','genre','prefecture','del_flg')
        ->join('genres', 'bandusers.genre_id', '=', 'genres.id') 
        ->join('prefectures', 'bandusers.prefecture_id', '=', 'prefectures.id') 
        ->paginate(10);
        }

        // 都道府県が全てジャンルはありを選択しキーワードがなし
        if(!empty($prefecture) && $prefecture != "全て" && $genre != "全て" && empty($keyword)) {
        $query = DB::table('bandusers')
        ->where('del_flg', '=', 0)
        ->where('genre', 'LIKE', $genre)
        ->where('prefecture', 'LIKE', $prefecture)
        ->select('bandusers.id','name','email','password','genre_id','prefecture_id','city','biography','image','genre','prefecture','del_flg')
        ->join('genres', 'bandusers.genre_id', '=', 'genres.id') 
        ->join('prefectures', 'bandusers.prefecture_id', '=', 'prefectures.id') 
        ->paginate(10);
        }

        // 都道府県が全てジャンルはありを選択しキーワードがなし
        if($prefecture != "全て" && $genre != "全て" && !empty($keyword)) {
        $query = DB::table('bandusers')
        ->where('del_flg', '=', 0)
        ->where('genre', 'LIKE', $genre)
        ->where('prefecture', 'LIKE', $prefecture)
        ->where('biography', 'LIKE', "%{$keyword}%")
        ->select('bandusers.id','name','email','password','genre_id','prefecture_id','city','biography','image','genre','prefecture','del_flg')
        ->join('genres', 'bandusers.genre_id', '=', 'genres.id') 
        ->join('prefectures', 'bandusers.prefecture_id', '=', 'prefectures.id') 
        ->paginate(10);
        }

        $bandusers = $query;
        $prefectures = Prefecture::all();
        $genres = Genre::all();

        return view('adminlivehouseindex', compact('bandusers','prefectures','genres','keyword','selectprefecture','selectgenre'));
    }

    // バンドメインページ
    public function adminbandindex(Request $request) {

        // sessionからログインしたユーザーのIDを取り出す
        $userid = session()->get('id');
        $userprefectureid = session()->get('prefecture_id');
        $kerberos_flg = session()->get('kerberos_flg');

        // 不正ログイン対策
        if ($kerberos_flg != 3) {
            return redirect('/index');
        exit;
        }

        //検索フォームに入力された値を取得

        $prefecture = $request->input('prefecture');
        $selectprefecture = $prefecture;
        $keyword = $request->input('keyword');

        // ログインしたユーザーの地域のライブハウスを表示
        $query = DB::table('livehouseusers')
        ->where('del_flg', '=', 0)
        ->where('prefecture_id', 'LIKE', $userprefectureid)
        ->select('livehouseusers.id','name','email','password','prefecture_id','city','biography','image','prefecture')
        ->join('prefectures', 'livehouseusers.prefecture_id', '=', 'prefectures.id') 
        ->paginate(10);

        // 全てまたは選択した地域を表示
        if($prefecture == "全て") {
        $query = DB::table('livehouseusers')
        ->where('del_flg', '=', 0)
        ->select('livehouseusers.id','name','email','password','prefecture_id','city','biography','image','prefecture')
        ->join('prefectures', 'livehouseusers.prefecture_id', '=', 'prefectures.id') 
        ->paginate(10);
        } 
        
        // 全てかつキーワードがある
        if($prefecture == "全て" && !empty($keyword)) {
        $query = DB::table('livehouseusers')
        ->where('del_flg', '=', 0)
        ->where('biography', 'LIKE', "%{$keyword}%")
        ->select('livehouseusers.id','name','email','password','prefecture_id','city','biography','image','prefecture')
        ->join('prefectures', 'livehouseusers.prefecture_id', '=', 'prefectures.id') 
        ->paginate(10);
        }

        // 全て以外の地域やキーワード
        if(!empty($prefecture) && $prefecture != '全て') {
        $query = DB::table('livehouseusers')
        ->where('del_flg', '=', 0)
        ->where('prefecture', 'LIKE', $prefecture)
        ->where('biography', 'LIKE', "%{$keyword}%")
        ->select('livehouseusers.id','name','email','password','prefecture_id','city','biography','image','prefecture')
        ->join('prefectures', 'livehouseusers.prefecture_id', '=', 'prefectures.id') 
        ->paginate(10);
        } elseif(!empty($keyword)) {
        $query = DB::table('livehouseusers')
        ->where('del_flg', '=', 0)
        ->where('biography', 'LIKE', "%{$keyword}%")
        ->select('livehouseusers.id','name','email','password','prefecture_id','city','biography','image','prefecture')
        ->join('prefectures', 'livehouseusers.prefecture_id', '=', 'prefectures.id') 
        ->paginate(10);
        }

        $livehouseusers = $query;
        $prefectures = Prefecture::all();

        return view('adminbandindex', compact('livehouseusers','prefectures','keyword','selectprefecture'));
    }

    /**
     * バンドの詳細ページを表示する
     * @param int $id
     * @return view
     */
    public function adminbandshow($id) {

        // sessionからログインしたユーザーのIDを取り出す
        $userid = session()->get('id');
        $kerberos_flg = session()->get('kerberos_flg');

        // 不正ログイン対策
        if ($kerberos_flg != 3) {
            return redirect('/index');
            exit;
        }

        // 取り出したIDに該当するユーザー情報を取得
        $users = DB::table('livehouseusers')
        ->where('id','=', $userid)
        ->select('id','name')
        ->first();


        $banduser = DB::table('bandusers')
        ->where('bandusers.id',$id)
        ->select('bandusers.id','name','email','password','genre_id','prefecture_id','city','biography','image','genre','prefecture')
        ->join('genres', 'bandusers.genre_id', '=', 'genres.id') 
        ->join('prefectures', 'bandusers.prefecture_id', '=', 'prefectures.id') 
        ->first();

        //dd($banduser);

        //if (is_null($banduser)) {
        //    \Session::flash('err_msg', 'データがありません。');
        //    return redirect()->route('contact')->with(compact('contacts'));
        //}

        return view('adminbandshow', ['banduser' => $banduser,'users' => $users]);
    }

    /**
     * ライブハウスの詳細ページを表示する
     * @param int $id
     * @return view
     */
    public function adminlivehouseshow($id) {

        // sessionからログインしたユーザーのIDを取り出す
        $userid = session()->get('id');
        $kerberos_flg = session()->get('kerberos_flg');

        // 不正ログイン対策
        if ($kerberos_flg != 3) {
            return redirect('/index');
        exit;
        }

        // 取り出したIDに該当するユーザーをIDを取得
        $users = DB::table('bandusers')
        ->where('id','=', $userid)
        ->select('id','name')
        ->first();


        $livehouseuser = DB::table('livehouseusers')
        ->where('livehouseusers.id',$id)
        ->select('livehouseusers.id','name','email','password','prefecture_id','city','biography','postcode','city','block','building','image','prefecture')
        ->join('prefectures', 'livehouseusers.prefecture_id', '=', 'prefectures.id') 
        ->first();

        return view('adminlivehouseshow', ['livehouseuser' => $livehouseuser,'users' => $users]);
    }

    /**
     * ライブハウスユーザーを削除
     * 
     * @return view
     */
    public function exedeleteband(Request $request,$id) {
        
        if ($request->has('send')) {

            $inputs = [
                'del_flg' => 1
            ];

            $livehouseusers = banduser::find($id);
            $livehouseusers->fill($inputs);
            $livehouseusers->save();

            return redirect()->route('adminbandindex')->with('flash_message', '削除に成功しました。');
        }
    }

    /**
     * ライブハウスユーザーを削除
     * 
     * @return view
     */
    public function exedeletelivehouse(Request $request,$id) {
        
        if ($request->has('send')) {

            $inputs = [
                'del_flg' => 1
            ];

            $livehouseusers = Livehouseusers::find($id);
            $livehouseusers->fill($inputs);
            $livehouseusers->save();

            return redirect()->route('adminlivehouseindex')->with('flash_message', '削除に成功しました。');
        }
    }

}