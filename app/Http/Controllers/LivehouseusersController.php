<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

use Illuminate\Http\Request;
use App\Models\Livehouseusers;
use App\Models\Prefecture;
use App\Models\banduser;
use App\Models\Genre;
use App\Models\Livehouselike;
use App\Models\Contact;
use App\Mail\ContactSendmail;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;



class LivehouseusersController extends BaseController {

    public function livehousesignup() {
        $prefectures = Prefecture::all();
        //dd($genres);
        //dd($prefectures);
        return view('livehousesignupform', compact('prefectures'));
    }

    /**
     * 新規登録
     * 
     * @return view
     */
    public function exelivehouseuser(Request $request) {
        
        if ($request->has('send')) {

            // バリデーションで何もエラーが出なかったら登録
            $request->validate([
                'livehousename' => 'required|string|required|max:255',
                'email' => 'required|string|email|max:255|unique:bandusers|unique:livehouseusers',
                'password' => 'required|string|confirmed:password|regex:/^(?=.*[0-9])(?=.*[a-z])(?=.*[A-Z])[0-9a-zA-Z\-]{8,24}$/',
                'postcode' => 'required|string|max:255|regex:/^[0-9]{3}-[0-9]{4}$/',
                'city' =>  'required|string|max:255',
                'block' =>  'required|string|max:255',
            ]);

            // パスワードのハッシュ化
            $hash_pass = md5($request->input('password'));

            // 画像のアップロード
            $image = $request->file('image');
            if ($request->hasFile('image')){
                $path = \Storage::put('/public', $image);
                $path = explode('/', $path);
            } else {
                //$path = null;
                $path = array("null","no_image.jpeg");
            }

            $inputs = [
                'name' => $request->input('livehousename'),
                'email' => $request->input('email'),
                'password' => $hash_pass,
                'postcode' => $request->input('postcode'),
                'prefecture_id' => $request->input('prefecture'),
                'city' => $request->input('city'),
                'block' => $request->input('block'),
                'building' => $request->input('building'),
                'biography' => $request->input('biography'),
                'image' => $path[1]
            ];

            //dd($inputs);
            Livehouseusers::create($inputs);
            //}

            return redirect('/index')->with('flash_message', '登録に成功しました。');
            
        } elseif  ($request->has('back')) {
            return redirect('/index');
        }

    return view('livehousesignupform');
    }

    // ライブハウスメインページ
    public function livehouseindex(Request $request) {

        // sessionからログインしたユーザーのIDを取り出す
        $userid = session()->get('id');
        $userprefectureid = session()->get('prefecture_id');
        $kerberos_flg = session()->get('kerberos_flg');

        // 不正ログイン対策
        if ($kerberos_flg != 2 ) {
            return redirect('/index');
            exit;
        }

        // 取り出したIDに該当するユーザー情報を取得
        $users = DB::table('livehouseusers')
        ->where('id','=', $userid)
        ->select('id','name')
        ->first();

        $prefecture = $request->input('prefecture');
        $selectprefecture = $prefecture;
        $test = $prefecture;
        $keyword = $request->input('keyword');
        $genre = $request->input('genre');
        $selectgenre = $genre;

        //dd($userprefectureid);

        // ログインしたユーザーの地域のバンドを表示
        $query = DB::table('bandusers')
        ->where('del_flg', '=', 0)
        ->where('prefecture_id', 'LIKE', $userprefectureid)
        ->select('bandusers.id','name','email','password','genre_id','prefecture_id','city','biography','image','genre','prefecture','del_flg')
        ->join('genres', 'bandusers.genre_id', '=', 'genres.id') 
        ->join('prefectures', 'bandusers.prefecture_id', '=', 'prefectures.id') 
        ->paginate(10);

        //dd($query);

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

        return view('livehouseindex', compact('bandusers','users','prefectures','genres','keyword','selectprefecture','selectgenre'));
    }

    /**
     * バンドの詳細ページを表示する
     * @param int $id
     * @return view
     */
    public function bandshow($id) {

        // sessionからログインしたユーザーのIDを取り出す
        $userid = session()->get('id');
        $kerberos_flg = session()->get('kerberos_flg');

        // 不正ログイン対策
        if ($kerberos_flg != 2) {
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

        // すでにお気に入り登録済み確認
        $check = DB::table('livehouselikes')
        ->where('user_id', '=', $userid)
        ->where('post_id', '=', $id)
        ->count();

        return view('bandshow', ['banduser' => $banduser,'users' => $users, 'check' => $check]);
    }

    /**
     * バンドお問合せページを表示する
     * @param int $id
     * @return view
     */
    public function bandcontact($id) {

        // sessionからログインしたユーザーのIDを取り出す
        $userid = session()->get('id');
        $kerberos_flg = session()->get('kerberos_flg');

        // 不正ログイン対策
        if ($kerberos_flg != 2) {
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

        return view('bandcontact', ['banduser' => $banduser,'users' => $users]);
    }

    /**
     * 問い合わせを登録と送信
     * 
     * @return view
     */
    public function exebandcontact(Request $request) {

        $id = $request->input('id');
        $sendemail = $request->input('sendemail');
        
        if ($request->has('send')) {
            // バリデーションで何もエラーが出なかったら登録
            $request->validate([
                'name' => 'required|string|required|max:255',
                'email' => 'required|string|email|max:255',
                'messege' => 'required|string',
            ]);



            $inputs = [
                'name' => $request->input('name'),
                'email' => $request->input('email'),
                'messege' => $request->input('messege'),
            ];

            //dd($inputs);
            Contact::create($inputs);
            //}

            \Mail::to($sendemail)->send(new ContactSendmail($inputs));

            return redirect()->route('bandshow', ['id' => $id])->with('flash_message', '送信に成功しました。');
            
        } elseif  ($request->has('back')) {
            return redirect()->route('bandshow', ['id' => $id]);
        }

        return view('bandcontact');
    }    

    /**
     * マイページを表示する
     * @param int $id
     * @return view
     */
    public function livehousemypage($id) {

        // sessionからログインしたユーザーのIDを取り出す
        $userid = session()->get('id');
        $kerberos_flg = session()->get('kerberos_flg');

        // 不正ログイン対策
        if ($kerberos_flg == 2 && $userid == $id) {

            // 取り出したIDに該当するユーザーをIDを取得
            $users = DB::table('livehouseusers')
            ->where('id','=', $userid)
            ->select('id','name')
            ->first();

            // 取り出したIDに該当するユーザー情報を取得
            $livehouseuser = DB::table('livehouseusers')
            ->where('livehouseusers.id',$id)
            ->select('livehouseusers.id','name','email','password','prefecture_id','city','biography','postcode','city','block','building','image','prefecture')
            ->join('prefectures', 'livehouseusers.prefecture_id', '=', 'prefectures.id') 
            ->first();

            return view('livehousemypage', ['livehouseuser' => $livehouseuser,'users' => $users]);

        } else {
            return redirect('/index');
            exit;
        }
 
    }


    /**
     * ライブハウス編集ページを表示する
     * @param int $id
     * @return view
     */
    public function livehouseedit($id) {

        $prefectures = Prefecture::all();

        // sessionからログインしたユーザーのIDを取り出す
        $userid = session()->get('id');
        $kerberos_flg = session()->get('kerberos_flg');

        // 不正ログイン対策
        if ($kerberos_flg == 2 && $userid == $id) {

            // 取り出したIDに該当するユーザーをIDを取得
            $users = DB::table('livehouseusers')
            ->where('id','=', $userid)
            ->select('id','name')
            ->first();

            // 取り出したIDに該当するユーザー情報を取得
            $livehouseuser = DB::table('livehouseusers')
            ->where('livehouseusers.id',$id)
            ->select('livehouseusers.id','name','email','password','prefecture_id','city','biography','postcode','city','block','building','image','prefecture')
            ->join('prefectures', 'livehouseusers.prefecture_id', '=', 'prefectures.id') 
            ->first();



            return view('livehouseedit', ['livehouseuser' => $livehouseuser,'users' => $users,'prefectures' => $prefectures]);
  
        } else {
            return redirect('/index');
            exit;
        }
    }

    /**
     * 編集
     * 
     * @return view
     */
    public function exelivehouseedit(Request $request,$id) {


        // sessionからログインしたユーザーのIDを取り出す
        $userid = session()->get('id');

        // 取り出したIDに該当するユーザー情報を取得
        $users = DB::table('livehouseusers')
        ->where('id','=', $userid)
        ->select('id','name')
        ->first();
        
        if ($request->has('send')) {
            // バリデーションで何もエラーが出なかったら登録
            $request->validate([
                'livehousename' => 'required|string|required|max:255',
                'email' => 'required|string|email|max:255|unique:bandusers|unique:livehouseusers,email,'.$id.',id',
                'newpassword' => 'nullable|string|confirmed:newpassword|regex:/^(?=.*[0-9])(?=.*[a-z])(?=.*[A-Z])[0-9a-zA-Z\-]{8,24}$/',
                'city' =>  'required|string|max:255',
                'block' =>  'required|string|max:255',
            ]);

            // 画像のアップロード
            $newimage = $request->file('newimage');
            $image = $request->input('image');
            if (empty($newimage)){
                $path = array("null",$image);
            } else {
                $path = \Storage::put('/public', $newimage);
                $path = explode('/', $path);
            }

            // 入力した現在のパスワードハッシュ化
            $hash_pass = md5($request->input('password'));
            // 現在のパスワード
            $now_pass = $request->input('password_confirmation');
            // 入力したパスワード
            $new_pass = $request->input('newpassword');
            // 新しいのパスワードハッシュ化
            $new_hash_pass = md5($request->input('newpassword'));

            // 新しいパスワードが空であれば
            if (empty($new_pass)) {

                $inputs = [
                    'name' => $request->input('livehousename'),
                    'email' => $request->input('email'),
                    'postcode' => $request->input('postcode'),
                    'prefecture_id' => $request->input('prefecture'),
                    'city' => $request->input('city'),
                    'block' => $request->input('block'),
                    'building' => $request->input('building'),
                    'biography' => $request->input('biography'),
                    'image' => $path[1]
                ];

            // 入力した現在のパスワードと現在のパスワードが一致していれば
            } elseif ($hash_pass == $now_pass) {

                $inputs = [
                    'name' => $request->input('livehousename'),
                    'email' => $request->input('email'),
                    'password' => $new_hash_pass,
                    'postcode' => $request->input('postcode'),
                    'prefecture_id' => $request->input('prefecture'),
                    'city' => $request->input('city'),
                    'block' => $request->input('block'),
                    'building' => $request->input('building'),
                    'biography' => $request->input('biography'),
                    'image' => $path[1]
                ];

            } else {
                return redirect()->route('livehouseedit', ['id' => $id])->with('flash_errmessage', '現在のパスワードが空白か間違っています。');
            }





            $livehouseusers = livehouseusers::find($id);
            $livehouseusers->fill($inputs);
            $livehouseusers->save();

            return redirect()->route('livehousemypage', ['id' => $id])->with('flash_message', '更新に成功しました。');
            
        } elseif  ($request->has('back')) {
            return redirect()->route('livehousemypage', ['id' => $id,]);

                //return view('livehousemypage', ['livehouseuser' => $livehouseuser,'users' => $users]);
        }

    return view('livehousesignupform');
    }

    /**
     * ログアウト
     * 
     */
    public function logout() {

        session()->flush();

        return redirect('/index');
    }  

    /**
     * お気に入り登録
     * 
     * @return view
     */
    public function exelike(Request $request,$id) {


        // sessionからログインしたユーザーのIDを取り出す
        $userid = session()->get('id');

        // 取り出したIDに該当するユーザーをIDを取得

        $users = DB::table('livehouseusers')
        ->where('id','=', $userid)
        ->select('id','name')
        ->first();

        
        if ($request->has('send')) {

            $inputs = [
            'user_id' => $userid,
            'post_id' => $request->input('likeid'),
            ];   
            
            Livehouselike::create($inputs);

            return redirect()->route('bandlike')->with('flash_message', 'お気に入り登録しました。');
            
        } elseif ($request->has('delete')) {

            $likeid =$request->input('likeid');

            // すでに登録済みのID確認
            $inputs = DB::table('livehouselikes')
            ->where('user_id', '=', $userid)
            ->where('post_id', '=', $likeid)
            ->value('id');

            //dd($inputs);

            $like = Livehouselike::find($inputs);
            // レコードを削除
            $like->delete();

            //Like::delete($inputs);

            return redirect()->route('bandlike')->with('flash_message', 'お気に入り登録解除しました。');

        }

    return view('bandlike');
    }

    /**
     * お気に入り登録完了
     * 
     * @return view
     */
    public function like() {


        // sessionからログインしたユーザーのIDを取り出す
        $userid = session()->get('id');

        // 取り出したIDに該当するユーザーをIDを取得
        $users = DB::table('livehouseusers')
        ->where('id','=', $userid)
        ->select('id','name')
        ->first();
        

    return view('bandlike', ['users' => $users]);
    }

    // お気に入り一覧ページ
    public function likeshow(Request $request) {

        // sessionからログインしたユーザーのIDを取り出す
        $userid = session()->get('id');
        $userprefectureid = session()->get('prefecture_id');
        $kerberos_flg = session()->get('kerberos_flg');

        // 不正ログイン対策
        if ($kerberos_flg != 2 ) {
            return redirect('/index');
            exit;
        }

        // 取り出したIDに該当するユーザー情報を取得
        $users = DB::table('livehouseusers')
        ->where('id','=', $userid)
        ->select('id','name')
        ->first();

        // お気に入り登録されているライブハウスIDを取得
        $like_id = DB::table('livehouselikes')
        ->where('user_id','=', $userid)
        ->get('post_id');

        // ログインしたユーザーの地域のライブハウスを表示
        $query = DB::table('bandusers')
        ->where('del_flg', '=', 0)
        ->where('user_id', '=', $userid)
        ->select('bandusers.id','name','email','password','prefecture_id','city','biography','image','del_flg','user_id','prefecture','genre')
        ->join('livehouselikes', 'post_id', '=', 'bandusers.id') 
        ->join('genres', 'bandusers.genre_id', '=', 'genres.id') 
        ->join('prefectures', 'bandusers.prefecture_id', '=', 'prefectures.id') 
        ->paginate(10);


        //検索フォームに入力された値を取得

        $prefecture = $request->input('prefecture');
        $selectprefecture = $prefecture;
        $test = $prefecture;
        $keyword = $request->input('keyword');
        $genre = $request->input('genre');
        $selectgenre = $genre;


        $bandusers = $query;
        //dd($bandusers);

        $prefectures = Prefecture::all();
        $genres = Genre::all();

        return view('bandlikeshow', compact('bandusers','users','prefectures','genres','keyword','selectprefecture','selectgenre'));
    }

}