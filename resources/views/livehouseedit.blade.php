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

        <!-- フラッシュメッセージ用 -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

        <!-- フラッシュメッセージ -->
        <script>
        @if (session('flash_message'))
            $(function () {
                toastr.success('{{ session('flash_message') }}');
            });
        @endif
        @if (session('flash_errmessage'))
            $(function () {
                toastr.error('{{ session('flash_errmessage') }}');
            });
        @endif
		// スクロールするとメニューがついてくる
		$(function () {
			$(window).scroll(function () {
				if ($(this).scrollTop() > 60 ) { //100px以上スクロールした固定
					$('.header_wrapper').addClass('fixed');
				} else {
					$('.header_wrapper').removeClass('fixed');
				}
			});
		});

        $(function () {
            getLatLng([北海道恵庭市島松], (result) => {
                console.log("緯度: ", result.lat);
                console.log("経度: ", result.lng);
            });
        });
		</script>
	</head>

<header>
    <div class="header">

    @include('livehouseheader')
    </div>

</header>

	<body>
        <div class='wrap'>
            <div class='signupform2'>
                <div class='signform'>
                    <div class='edit_title'>
                        <h2>編集画面</h2>
                    </div>
                        <form action="" method="post" id="form" enctype="multipart/form-data">
                        @csrf
                        <div class='signname'>
                            <label>ライブハウス名</label>
                            <div class='vallidationerror'>
                            @if($errors->has('livehousename'))
                                @foreach($errors->get('livehousename') as $message)
                                    {{ $message }}
                                @endforeach
                            @endif
                            </div>
                            <input id="livehousename" type="text" name="livehousename"  value="{{ $livehouseuser->name }}" class ="formareac">
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
                            <input id="email" type="email" name="email" value="{{ $livehouseuser->email }}" class ="formareac">
                        </div>
                        <div class='signname'>
                            <label>郵便番号(ハイフンなし)</label>
                            <div class='vallidationerror'>
                            @if($errors->has('postcode'))
                                @foreach($errors->get('postcode') as $message)
                                    {{ $message }}
                                @endforeach
                            @endif
                            </div>
                            <input id="postcode" type="text" name="postcode" value="{{ $livehouseuser->postcode }}" class ="formareaa">
                        </div>  
                        <div class='signname'>
                            <label>都道府県</label><br>
                            <select class='formareaa' type="text" name="prefecture" >
                                @foreach ($prefectures as $prefecture)
                                    @if($prefecture->id === $livehouseuser->prefecture_id)
                                        <option value="{{ $prefecture->id }}" selected>{{ $prefecture->prefecture }}</option>
                                    @else
                                        <option value="{{ $prefecture->id }}">{{ $prefecture->prefecture }}</option>
                                    @endif
                                @endforeach
                            </select>
                        </div>
                        <div class='signname'>
                            <label>市区町村</label>
                            <div class='vallidationerror'>
                             @if($errors->has('city'))
                                @foreach($errors->get('city') as $message)
                                    {{ $message }}
                                @endforeach
                            @endif
                            </div>
                            <input id="city" type="text" name="city" value="{{ $livehouseuser->city }}" class ="formareaa">
                        </div>
                        <div class='signname'>
                            <label>番地</label>
                            <div class='vallidationerror'>
                             @if($errors->has('city'))
                                @foreach($errors->get('city') as $message)
                                    {{ $message }}
                                @endforeach
                            @endif
                            </div>
                            <input id="block" type="text" name="block" value="{{ $livehouseuser->block }}" class ="formareaa">
                        </div>
                        <div class='signname'>
                            <label>建物名</label>
                            <input id="building" type="text" name="building" value="{{ $livehouseuser->building }}" class ="formareaa">
                        </div>
                        <div class='signname'>
                            <label>プロフィール</label><br>
                            <textarea id="biography" type="text" name="biography" class ="formareae">{{ $livehouseuser->biography }}</textarea>
                        </div>
                        <div class='signname'>
                            <label>写真</label><br>
                            <input id="newimage" type="file" name="newimage" >
                            <input id="image" type="hidden"  name="image" value="{{ $livehouseuser->image }}" >
                        </div>
                        <div class='sihnpassword'>
                            <label>現在のパスワード※大文字小文字数字記号8文字以上</label>
                            <input id="password" type="password" name="password" placeholder="" value="" class ="formareac">
                            <input id="password_confirmation" type="hidden" name="password_confirmation" placeholder="" value="{{ $livehouseuser->password }}" class ="formareac">
                        </div>
                        <div class='sihnpassword'>
                            <label>新しいパスワード※大文字小文字数字記号8文字以上</label>
                            <div class='vallidationerror'>
                            @if($errors->has('newpassword'))
                                @foreach($errors->get('newpassword') as $message)
                                    <div>{{ $message }}</div>
                                @endforeach
                            @endif
                            </div>
                            <input id="newpassword" type="password" name="newpassword" placeholder="" value="" class ="formareac">
                        </div>
                        <div class='sihnpassword'>
                            <label>確認用新しいパスワード※大文字小文字数字記号8文字以上</label>
                            <input id="newpassword_confirmation" type="password" name="newpassword_confirmation" placeholder="" value="" class ="formareac">
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