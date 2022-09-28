<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

use Illuminate\Http\Request;
use App\Models\banduser;
use App\Models\Livehouseusers;
use App\Models\adminusers;
use App\Models\BandLike;
use App\Models\Genre;
use App\Models\Prefecture;
use App\Models\Contact;
use App\Mail\ContactSendmail;
use App\Mail\Forgerpassmail;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

class BandusersController extends BaseController {

    public function login(Request $request) {

        // セッションを削除
        session()->flush();

        $hash_pass = md5($request->input('password'));
        $email = $request->input('email');

        // bandusersから一致しているものを探す
        $bandcheck = DB::table('bandusers')
        ->where('del_flg', '=', 0)
        ->where('password','=', $hash_pass)
        ->where('email','=', $email )
        ->count();

        // bandusersから一致しているIDを渡す
        $bandid = DB::table('bandusers')
        ->where('password','=', $hash_pass)
        ->where('email','=', $email )
        ->value('id');

        // bandusersから一致しているIDを渡す
        $bandprefectureid = DB::table('bandusers')
        ->where('password','=', $hash_pass)
        ->where('email','=', $email )
        ->value('prefecture_id');

        // livehouseusersから一致しているものを探す
        $livehousecheck = DB::table('livehouseusers')
        ->where('del_flg', '=', 0)
        ->where('password','=', $hash_pass)
        ->where('email','=', $email )
        ->count();

        // livehouseusersから一致しているIDを渡す
        $livehouseid = DB::table('livehouseusers')
        ->where('password','=', $hash_pass)
        ->where('email','=', $email )
        ->select('id')
        ->value('id');

        // livehouseusersから一致しているIDを渡す
        $livehouseprefectureid = DB::table('livehouseusers')
        ->where('password','=', $hash_pass)
        ->where('email','=', $email )
        ->value('prefecture_id');

        // adminusersから一致しているものを探す
        $admincheck = DB::table('adminusers')
        ->where('password','=', $hash_pass)
        ->where('email','=', $email )
        ->count();

        if ($bandcheck == '1') {
            // ログインしたユーザーのIDをセッションに保存
            session()->put('id', $bandid);
            session()->put('prefecture_id', $bandprefectureid);
            session()->put('kerberos_flg', 1);
           
            return redirect()->route('bandindex')->with('flash_message', 'ログインに成功しました。');

        } elseif ($livehousecheck == '1') {
            // ログインしたユーザーのIDをセッションに保存
            session()->put('id', $livehouseid);
            session()->put('prefecture_id', $livehouseprefectureid);
            session()->put('kerberos_flg', 2);

            return redirect()->route('livehouseindex')->with('flash_message', 'ログインに成功しました。');

        } elseif ($admincheck == '1') {
            // ログインしたユーザーのIDをセッションに保存
            session()->put('kerberos_flg', 3);

            return redirect()->route('adminlivehouseindex')->with('flash_message', 'ログインに成功しました。');
        } else {
            return redirect('/index')->with('flash_errmessage', 'ログインに失敗しました。');
        }

        return view('index');
    }

    public function bandsignup() {

        $genres = Genre::all();
        $prefectures = Prefecture::all();

        return view('bandsignupform', compact('genres','prefectures'));
    }

    /**
     * 新規登録
     * 
     * @return view
     */
    public function exebanduser(Request $request) {

        if ($request->has('send')) {
            // バリデーションで何もエラーが出なかったら登録
            $request->validate([
                'bandname' => 'required|string|required|max:255',
                'email' => 'required|string|email|max:255|unique:bandusers|unique:livehouseusers',
                'password' => 'required|string|confirmed:password|regex:/^(?=.*[0-9])(?=.*[a-z])(?=.*[A-Z])[0-9a-zA-Z\-]{8,24}$/',
                'city' => 'nullable|string',
                'biography' => 'nullable|string',
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
                'name' => $request->input('bandname'),
                'email' => $request->input('email'),
                'password' => $hash_pass,
                'genre_id' => $request->input('genre'),
                'prefecture_id' => $request->input('prefecture'),
                'city' => $request->input('city'),
                'biography' => $request->input('biography'),
                'image' => $path[1]
            ];

            banduser::create($inputs);

            return redirect('/index')->with('flash_message', '登録に成功しました。');
            
        } elseif  ($request->has('back')) {
            return redirect('/index');
        }

    return view('bandsignupform');
    }

    // バンドメインページ
    public function bandindex(Request $request) {

        // sessionからログインしたユーザーのIDを取り出す
        $userid = session()->get('id');
        $userprefectureid = session()->get('prefecture_id');
        $kerberos_flg = session()->get('kerberos_flg');

        // 不正ログイン対策
        if ($kerberos_flg != 1) {
            return redirect('/index');
        exit;
        }

        // 取り出したIDに該当するユーザー情報を取得
        $users = DB::table('bandusers')
        ->where('id','=', $userid)
        ->select('id','name')
        ->first();

        //検索フォームに入力された値を取得

        $prefecture = $request->input('prefecture');
        $selectprefecture = $prefecture;
        $keyword = $request->input('keyword');

        // ログインしたユーザーの地域のライブハウスを表示
        $query = DB::table('livehouseusers')
        ->where('del_flg', '=', 0)
        ->where('prefecture_id', 'LIKE', $userprefectureid)
        ->select('livehouseusers.id','name','email','password','prefecture_id','city','biography','image','prefecture','del_flg')
        ->join('prefectures', 'livehouseusers.prefecture_id', '=', 'prefectures.id') 
        ->paginate(10);

        // 全てまたは選択した地域を表示
        if($prefecture == "全て") {
        $query = DB::table('livehouseusers')
        ->where('del_flg', '=', 0)
        ->select('livehouseusers.id','name','email','password','prefecture_id','city','biography','image','prefecture','del_flg')
        ->join('prefectures', 'livehouseusers.prefecture_id', '=', 'prefectures.id') 
        ->paginate(10);
        } 
        
        // 全てかつキーワードがある
        if($prefecture == "全て" && !empty($keyword)) {
        $query = DB::table('livehouseusers')
        ->where('del_flg', '=', 0)
        ->where('biography', 'LIKE', "%{$keyword}%")
        ->select('livehouseusers.id','name','email','password','prefecture_id','city','biography','image','prefecture','del_flg')
        ->join('prefectures', 'livehouseusers.prefecture_id', '=', 'prefectures.id') 
        ->paginate(10);
        }

        // 全て以外の地域やキーワード
        if(!empty($prefecture) && $prefecture != '全て') {
        $query = DB::table('livehouseusers')
        ->where('del_flg', '=', 0)
        ->where('prefecture', 'LIKE', $prefecture)
        ->where('biography', 'LIKE', "%{$keyword}%")
        ->select('livehouseusers.id','name','email','password','prefecture_id','city','biography','image','prefecture','del_flg')
        ->join('prefectures', 'livehouseusers.prefecture_id', '=', 'prefectures.id') 
        ->paginate(10);
        } elseif(!empty($keyword)) {
        $query = DB::table('livehouseusers')
        ->where('del_flg', '=', 0)
        ->where('biography', 'LIKE', "%{$keyword}%")
        ->select('livehouseusers.id','name','email','password','prefecture_id','city','biography','image','prefecture','del_flg')
        ->join('prefectures', 'livehouseusers.prefecture_id', '=', 'prefectures.id') 
        ->paginate(10);
        }

        $livehouseusers = $query;
        $prefectures = Prefecture::all();

        return view('bandindex', compact('livehouseusers','users','prefectures','keyword','selectprefecture'));
    }

    /**
     * ライブハウスの詳細ページを表示する
     * @param int $id
     * @return view
     */
    public function livehouseshow($id) {

        // sessionからログインしたユーザーのIDを取り出す
        $userid = session()->get('id');
        $kerberos_flg = session()->get('kerberos_flg');

        // 不正ログイン対策
        if ($kerberos_flg != 1) {
            return redirect('/index');
        exit;
        }

        // 取り出したIDに該当するユーザーをIDを取得
        $users = DB::table('bandusers')
        ->where('id','=', $userid)
        ->select('id','name')
        ->first();

        // すでにお気に入り登録済み確認
        $check = DB::table('bandlikes')
        ->where('user_id', '=', $userid)
        ->where('post_id', '=', $id)
        ->count();


        $livehouseuser = DB::table('livehouseusers')
        ->where('livehouseusers.id',$id)
        ->select('livehouseusers.id','name','email','password','prefecture_id','city','biography','postcode','city','block','building','image','prefecture')
        ->join('prefectures', 'livehouseusers.prefecture_id', '=', 'prefectures.id') 
        ->first();

        return view('livehouseshow', ['livehouseuser' => $livehouseuser,'users' => $users, 'check' => $check]);
    }

    /**
     * ライブハウスお問合せページを表示する
     * @param int $id
     * @return view
     */
    public function livehousecontact($id) {

        // sessionからログインしたユーザーのIDを取り出す
        $userid = session()->get('id');

        // 取り出したIDに該当するユーザーをIDを取得
        $users = DB::table('bandusers')
        ->where('id','=', $userid)
        ->select('id','name')
        ->first();

        $livehouseuser = DB::table('livehouseusers')
        ->where('livehouseusers.id',$id)
        ->select('livehouseusers.id','name','email','password','prefecture_id','city','biography','image','prefecture')
        ->join('prefectures', 'livehouseusers.prefecture_id', '=', 'prefectures.id') 
        ->first();

        return view('livehousecontact', ['livehouseuser' => $livehouseuser,'users' => $users]);
    }

    /**
     * 問い合わせを登録と送信
     * 
     * @return view
     */
    public function exelivehousecontact(Request $request) {

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

            Contact::create($inputs);

            \Mail::to($sendemail)->send(new ContactSendmail($inputs));

            return redirect()->route('livehouseshow', ['id' => $id])->with('flash_message', '送信に成功しました。');
            
        } elseif  ($request->has('back')) {
            return redirect()->route('livehouseshow', ['id' => $id]);
        }

        return view('livehousecontact');
    }        

    /**
     * マイページを表示する
     * @param int $id
     * @return view
     */
    public function bandmypage($id) {

        // sessionからログインしたユーザーのIDを取り出す
        $userid = session()->get('id');
        $kerberos_flg = session()->get('kerberos_flg');

        // 不正ログイン対策
        if ($kerberos_flg == 1 && $userid == $id) {

            // 取り出したIDに該当するユーザーをIDを取得
            $users = DB::table('bandusers')
            ->where('id','=', $userid)
            ->select('id','name')
            ->first();

            // 取り出したIDに該当するユーザー情報を取得

            $banduser = DB::table('bandusers')
            ->where('bandusers.id',$id)
            ->select('bandusers.id','name','email','password','genre_id','prefecture_id','city','biography','image','genre','prefecture')
            ->join('genres', 'bandusers.genre_id', '=', 'genres.id') 
            ->join('prefectures', 'bandusers.prefecture_id', '=', 'prefectures.id') 
            ->first();

            return view('bandmypage', ['banduser' => $banduser,'users' => $users]);
 
        } else {
            return redirect('/index');
            exit;
        }
    }

    /**
     * バンド編集ページを表示する
     * @param int $id
     * @return view
     */
    public function bandedit($id) {

        $prefectures = Prefecture::all();
        $genres = Genre::all();

        // sessionからログインしたユーザーのIDを取り出す
        $userid = session()->get('id');
        $kerberos_flg = session()->get('kerberos_flg');

        // 不正ログイン対策
        if ($kerberos_flg == 1 && $userid == $id) {

            // 取り出したIDに該当するユーザーをIDを取得
            $users = DB::table('bandusers')
            ->where('id','=', $userid)
            ->select('id','name')
            ->first();

            // 取り出したIDに該当するユーザー情報を取得
            $banduser = DB::table('bandusers')
            ->where('bandusers.id',$id)
            ->select('bandusers.id','name','email','password','genre_id','prefecture_id','city','biography','image','genre','prefecture')
            ->join('genres', 'bandusers.genre_id', '=', 'genres.id') 
            ->join('prefectures', 'bandusers.prefecture_id', '=', 'prefectures.id') 
            ->first();

            return view('bandedit', ['banduser' => $banduser,'users' => $users,'prefectures' => $prefectures,'genres' => $genres]);
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
    public function exebandedit(Request $request,$id) {

        // sessionからログインしたユーザーのIDを取り出す
        $userid = session()->get('id');

        // 取り出したIDに該当するユーザーをIDを取得
        $users = DB::table('bandusers')
        ->where('id','=', $userid)
        ->select('id','name')
        ->first();
        
        if ($request->has('send')) {
            // バリデーションで何もエラーが出なかったら登録
            $request->validate([
                'bandname' => 'required|string|required|max:255',
                'email' => 'required|string|email|max:255|unique:bandusers,email,'.$id.',id|unique:livehouseusers',
                'newpassword' => 'nullable|string|confirmed:newpassword|regex:/^(?=.*[0-9])(?=.*[a-z])(?=.*[A-Z])[0-9a-zA-Z\-]{8,24}$/',
                'city' => 'nullable|string',
                'biography' => 'nullable|string',
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
                    'name' => $request->input('bandname'),
                    'email' => $request->input('email'),
                    'genre_id' => $request->input('genre'),
                    'prefecture_id' => $request->input('prefecture'),
                    'city' => $request->input('city'),
                    'biography' => $request->input('biography'),
                    'image' => $path[1]
                 ];   

            // 入力した現在のパスワードと現在のパスワードが一致していれば
            } elseif ($hash_pass == $now_pass) {

                $inputs = [
                    'name' => $request->input('bandname'),
                    'email' => $request->input('email'),
                    'genre_id' => $request->input('genre'),
                    'prefecture_id' => $request->input('prefecture'),
                    'password' => $new_hash_pass,
                    'city' => $request->input('city'),
                    'biography' => $request->input('biography'),
                    'image' => $path[1]
                ];

            } else {
                return redirect()->route('bandedit', ['id' => $id])->with('flash_errmessage', '現在のパスワードが空白か間違っています。');
            }
            
            $livehouseusers = banduser::find($id);
            $livehouseusers->fill($inputs);
            $livehouseusers->save();

            return redirect()->route('bandmypage', ['id' => $id])->with('flash_message', '更新に成功しました。');
            
        } elseif  ($request->has('back')) {
            return redirect()->route('bandmypage', ['id' => $id,]);

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
     *パスワード再発行ページを表示する
     * @return view
     */
    public function forgetpassword() {

        return view('forgetpassword');
    }

    /**
     * 再発行
     * 
     * @return view
     */
    public function exeforgetpassword(Request $request) {
        
        if ($request->has('send')) {

            $email = $request->input('email');
            $user = $request->input('user');

            if ($user == 'band'){
                // バンドユーザー用のバリデーション
                $request->validate([
                    'email' => 'required|string|email|max:255|exists:bandusers,email',
                ]);

                // 取り出したIDに該当するユーザーをIDを取得
                $id = DB::table('bandusers')
                ->where('email','=', $email )
                ->value('id');

            } else {
                // ライブハウスユーザー用のバリデーション
                $request->validate([
                    'email' => 'required|string|email|max:255|exists:livehouseusers,email',
                ]);

                // 取り出したIDに該当するユーザーをIDを取得
                $id = DB::table('livehouseusers')
                ->where('email','=', $email )
                ->value('id');
            }

            // バリデーションを通過したらパスワードを生成する
            $pass = Str::random(10);
            $hash_pass = md5($pass);

            // ランダムに生成したパスワードをセット
            $inputs = [
                'password' => $hash_pass
            ];

            if ($user == 'band'){

            $livehouseusers = banduser::find($id);
            $livehouseusers->fill($inputs);
            $livehouseusers->save();

            } else {

            $livehouseusers = Livehouseusers::find($id);
            $livehouseusers->fill($inputs);
            $livehouseusers->save();

            }


            // メール送信

            $inputs = [
                'email' => "test@gmai.com",
                'password' => $pass,
            ];

            \Mail::to($email)->send(new Forgerpassmail($inputs));

            return redirect('/index')->with('flash_message', 'メールを送信いたしました。');
            
        } elseif  ($request->has('back')) {
            return redirect('/index');
        }

    return view('livehousesignupform');
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

        $users = DB::table('bandusers')
        ->where('id','=', $userid)
        ->select('id','name')
        ->first();

        
        if ($request->has('send')) {

            $inputs = [
            'user_id' => $userid,
            'post_id' => $request->input('likeid'),
            ];   
            
            BandLike::create($inputs);

            return redirect()->route('livehouselike')->with('flash_message', 'お気に入り登録しました。');
            
        } elseif ($request->has('delete')) {

            $likeid =$request->input('likeid');

            // すでに登録済みのID確認
            $inputs = DB::table('bandlikes')
            ->where('user_id', '=', $userid)
            ->where('post_id', '=', $likeid)
            ->value('id');

            //dd($inputs);

            $like = BandLike::find($inputs);
            // レコードを削除
            $like->delete();

            return redirect()->route('livehouselike')->with('flash_message', 'お気に入り登録解除しました。');

        }

    return view('livehouselike');
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
        $users = DB::table('bandusers')
        ->where('id','=', $userid)
        ->select('id','name')
        ->first();
        

    return view('livehouselike', ['users' => $users]);
    }


    // お気に入り一覧ページ
    public function likeshow(Request $request) {

        // sessionからログインしたユーザーのIDを取り出す
        $userid = session()->get('id');
        $userprefectureid = session()->get('prefecture_id');
        $kerberos_flg = session()->get('kerberos_flg');

        // 不正ログイン対策
        if ($kerberos_flg != 1) {
            return redirect('/index');
        exit;
        }

        // 取り出したIDに該当するユーザー情報を取得
        $users = DB::table('bandusers')
        ->where('id','=', $userid)
        ->select('id','name')
        ->first();

        // お気に入り登録されているライブハウスIDを取得
        $like_id = DB::table('bandlikes')
        ->where('user_id','=', $userid)
        ->get('post_id');

        // ログインしたユーザーの地域のライブハウスを表示
        $query = DB::table('livehouseusers')
        ->where('del_flg', '=', 0)
        ->where('user_id', '=', $userid)
        ->select('livehouseusers.id','name','email','password','prefecture_id','city','biography','image','del_flg','user_id','prefecture')
        ->join('bandlikes', 'post_id', '=', 'livehouseusers.id') 
        ->join('prefectures', 'livehouseusers.prefecture_id', '=', 'prefectures.id') 
        ->paginate(10);


        //検索フォームに入力された値を取得

        $prefecture = $request->input('prefecture');
        $selectprefecture = $prefecture;
        $keyword = $request->input('keyword');



        $livehouseusers = $query;



        $prefectures = Prefecture::all();

        return view('livehouselikeshow', compact('livehouseusers','users','prefectures','keyword','selectprefecture'));
    }
    

}