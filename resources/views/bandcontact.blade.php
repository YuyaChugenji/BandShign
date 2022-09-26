<?php

$err = [];



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
		    @include('livehouseheader')
        </div>
	</header>

	<body>
        <div class='wrap'>
            <div class='signupform'>
                <div class='signform'>
                    <div class='signtext'>
                        <h2>{{ $banduser->name }}へお問合せをする</h2>
                    </div>
                        <form action="./bandcontact" method="post" id="form">
                        @csrf
                        <input id="id" type="hidden" name="id" value="{{ $banduser->id }}">
                        <input id="sendemail" type="hidden" name="sendemail" value="{{ $banduser->email }}">
                        <div class='signname'>
                            <label>名前</label>
                            <div class='vallidationerror'>
                            @if($errors->has('name'))
                                @foreach($errors->get('name') as $message)
                                    {{ $message }}
                                @endforeach
                            @endif
                            </div>
                            <input id="name" type="text" name="name" placeholder="山田太郎" value="" class ="formareac">
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
                            <input id="email" type="email" name="email" placeholder="test@test.co.jp" value="" class ="formareac">
                        </div>
                        <div class='signname'>
                            <label>お問合せ内容</label>
                            <div class='vallidationerror'>
                            @if($errors->has('messege'))
                                @foreach($errors->get('messege') as $message)
                                    {{ $message }}
                                @endforeach
                            @endif
                            </div>
                            <textarea id="messege" type="text" name="messege" placeholder="" value="" class ="formareae"></textarea>
                        </div>
                        <div class='btnform'>
                            <div class='loginBtn'>
                                <input class='formaread' type="submit" name="back" value="戻る">
                            </div>
                            <div class='loginBtn'>
                                <input class='formaread' type="submit" name="send" value="送信" onclick="return confirm('間違いありませんか？')">
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>

	</body>
</html>