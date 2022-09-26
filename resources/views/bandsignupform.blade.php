<?php

$err = [];

if (isset($_POST["login"]) && $_POST["login"]){

    if ($_POST["password"] !== $_POST["password_conf"] ) {
        $err[] =  '確認用パスワードとことなっています。';
    }

    if (!empty($err)) {
        foreach ($err as $msg) {
            echo $msg,'<br>';
            echo "<a href=\"index.php\">トップに戻る</a>\n";
            exit();
        }
    }
}

?>

<!DOCTYPE html>
<html>
	<head>
		<meta charset="UTF-8" />
		<title>BandSign</title>
		<!--  css を読み込ませる -->
    <link rel="stylesheet" type="text/css" href="{{('/css/base.css')}}">
    <link rel="stylesheet" type="text/css" href="{{('/css/style.css')}}">
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
		<script src="https://code.jquery.com/jquery-3.5.1.min.js" integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>

		<script>

		</script>
	</head>

	<header>
        <div class="header">
		    @include('header')
        </div>
	</header>

	<body>
        <div class='wrap'>
            <div class='signupform'>
                <div class='signform'>
                    <div class='signtext'>
                        <h2>新規バンドアカウント登録</h2>
                    </div>
                        <form action="./bandsignupform" method="post" id="form" enctype="multipart/form-data">
                        @csrf
                        <div class='signname'>
                            <label>バンド名</label>
                            <div class='vallidationerror'>
                            @if($errors->has('bandname'))
                                @foreach($errors->get('bandname') as $message)
                                    {{ $message }}
                                @endforeach
                            @endif
                            </div>
                            <input id="bandname" type="text" name="bandname" placeholder="山田太郎" value="{{ old('bandname') }}" class ="formareac">
                        </div>
                        <div class='sihnemail'>
                            <label>メールアドレス</label>
                            <div class='vallidationerror'>
                            @if($errors->has('email'))
                                @foreach($errors->get('email') as $message)
                                    {{ $message }}
                                @endforeach
                            @endif
                            </div>
                            <input id="email" type="email" name="email" placeholder="test@test.co.jp" value="{{ old('email') }}" class ="formareac">
                        </div>
                        <div class='sihnpassword'>
                            <label>パスワード※大文字小文字数字記号8文字以上</label>
                            <div class='vallidationerror'>
                            @if($errors->has('password'))
                                @foreach($errors->get('password') as $message)
                                    {{ $message }}
                                @endforeach
                            @endif
                            </div>
                            <input id="password" type="password" name="password" placeholder="" value="" class ="formareac">
                        </div>
                        <div class='sihnpassword'>
                            <label>パスワード確認用</label><br>
                            <input id="password_confirmation" type="password" name="password_confirmation" placeholder="" value="" class ="formareac">
                        </div>
                        <div class='signname'>
                            <label>ジャンル</label><br>
                            <select class='formareaa' type="text" name="genre" >
                                @foreach($genres as $genre)
                                <option value="{{ $genre->id }}" >{{ $genre->genre }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class='signname'>
                            <label>活動地域</label><br>
                            <select class='formareaa' type="text" name="prefecture" >
                                @foreach($prefectures as $prefecture)
                                <option value="{{ $prefecture->id }}" >{{ $prefecture->prefecture }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class='signname'>
                            <label>市区町村</label><br>
                            <input id="city" type="text" name="city" placeholder="" value="{{ old('city') }}" class ="formareaa">
                        </div>
                        <div class='signname'>
                            <label>プロフィール</label><br>
                            <textarea id="biography" type="text" name="biography" placeholder="" value="{{ old('biography') }}" class ="formareae"></textarea>
                        </div>
                        <div class='signname'>
                            <label>アーティスト写真</label><br>
                            <input id="image" type="file" name="image" >
                        </div>
                        <div class='btnform'>
                            <div class='loginBtn'>
                                <input class='formaread' type="submit" name="back" value="戻る">
                            </div>
                            <div class='loginBtn'>
                                <input class='formaread' type="submit" name="send" value="登録" onclick="return confirm('間違いありませんか？')">
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>

	</body>
</html>