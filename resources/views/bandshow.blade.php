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
        <div class='indexwrap'>
            <div class='showwrap'>
                <div class='showmain'>
                    <div class="showbiography1">
                        <div class="bandshowwrap3">
                            <div class="showimage2">
                                <img src="{{ '/storage/' . $banduser->image }}" class='artistimage3'>
                            </div>
                        </div>
                        <div class="showtextform">
                            <th class='showtext'>バンド名:{{ $banduser->name }}</th><br>
                            <th class='showtext'>ジャンル:{{ $banduser->genre }}</th><br>
                            <th class='showtext'>活動地域:{{ $banduser->prefecture }}</th><br>
                                @if($check)
                                     <form action="" method="post" id="form" enctype="multipart/form-data">
                                    @csrf
                                    <td>
                                        <input type="submit" name="delete" value="お気に入り登録解除">
                                        <input type="hidden" name="likeid" value='{{ $banduser->id }}'>
                                    </td>
                                @else
                                    <form action="" method="post" id="form" enctype="multipart/form-data">
                                    @csrf
                                    <td>
                                        <input type="submit" name="send" value="お気に入り登録">
                                        <input type="hidden" name="likeid" value='{{ $banduser->id }}'>
                                    </td>
                                @endif
                                </form>
                            <th>お問い合わせは<a href='/bandcontact/{{ $banduser->id }}'>こちら</a><br></th><br>
                        </div>
                    </div>
                    <div class="showbiography2">
                        <th class='name'>{!! nl2br (e($banduser->biography)) !!}</th>
                    </div>
                    <div class='newcreate2'>
                        </p><a href="{{ route('livehouseindex') }}">バンド一覧へ戻る</a>
                    </div>
                </div>
            </div>
        </div>
	</body>
</html>