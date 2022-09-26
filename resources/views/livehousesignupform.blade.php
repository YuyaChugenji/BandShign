<?php

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
                        <h2>新規ライブハウスアカウント登録</h2>
                    </div>
                        <form action="./livehousesignupform" method="post" id="form" enctype="multipart/form-data">
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
                            <input id="livehousename" type="text" name="livehousename" placeholder="山田太郎" value="{{ old('livehousename') }}" class ="formareac">
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
                            <label>パスワード</label>
                            <div class='vallidationerror'>
                            @if($errors->has('password'))
                                @foreach($errors->get('password') as $message)
                                    {{ $message }}
                                @endforeach
                            @endif
                            </div>
                            <input id="password" type="text" name="password" placeholder="" value="" class ="formareac">
                        </div>
                        <div class='sihnpassword'>
                            <label>パスワード確認用</label><br>
                            <input id="password_confirmation" type="text" name="password_confirmation" placeholder="" value="" class ="formareac">
                        </div>
                        <div class='signname'>
                            <label>郵便番号(ハイフンあり)</label>
                            <div class='vallidationerror'>
                            @if($errors->has('postcode'))
                                @foreach($errors->get('postcode') as $message)
                                    {{ $message }}
                                @endforeach
                            @endif
                            </div>
                            <input id="postcode" type="text" name="postcode" placeholder="" value="{{ old('postcode') }}" class ="formareaa">
                        </div>
                        <div class='signname'>
                            <label>都道府県</label><br>
                            <select class='formareaa' type="text" name="prefecture" >
                                @foreach($prefectures as $prefecture)
                                <option value="{{ $prefecture->id }}" >{{ $prefecture->prefecture }}</option>
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
                            <input id="city" type="text" name="city" placeholder="" value="{{ old('city') }}" class ="formareaa">
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
                            <input id="block" type="text" name="block" placeholder="" value="{{ old('block') }}" class ="formareaa">
                        </div>
                        <div class='signname'>
                            <label>建物名</label>
                            <input id="building" type="text" name="building" placeholder="" value="{{ old('building') }}" class ="formareaa">
                        </div>
                        <div class='signname'>
                            <label>プロフィール</label><br>
                            <textarea id="biography" type="text" name="biography" placeholder="" value="{{ old('biography') }}" class ="formareae"></textarea>
                        </div>
                        <div class='signname'>
                            <label>写真</label><br>
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