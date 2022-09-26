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
            <div class='searchform'>
                <div class='searchwrap'>

                    <div class="">
                        <form action="{{ route('livehouseindex') }}" method="GET">
                            @csrf

                            <div class="form-group">
                                <div class="form">
                                    <label for="">キーワード
                                    <div>
                                        <input type="text" name="keyword" value="{{ $keyword }}">
                                    </div>
                                    </label>
                                </div>

                                <div class="form2">
                                    <label for="">都道府県
                                    <div>
                                        <select name="prefecture" data-toggle="select">
                                            <option value="全て">全て</option>
                                            @foreach($prefectures as $prefecture)
                                                @if ($selectprefecture === $prefecture->prefecture )
                                                    <option value="{{ $selectprefecture }}"selected ="selected">{{ $selectprefecture }}</option>
                                                @else
                                                    <option value="{{ $prefecture->prefecture }}" >{{ $prefecture->prefecture }}</option>
                                                @endif
                                            @endforeach
                                        </select>
                                    </div>
                                    </label>
                                </div>

                                <div class="form2">
                                    <label for="">ジャンル
                                    <div>
                                        <select name="genre" data-toggle="select">
                                            <option value="全て">全て</option>
                                            @foreach($genres as $genre)
                                            @if ($selectgenre === $genre->genre )
                                                <option value="{{ $selectgenre }}"selected ="selected">{{ $selectgenre }}</option>
                                            @else
                                                <option value="{{ $genre->genre }}" >{{ $genre->genre }}</option>
                                            @endif
                                            @endforeach
                                        </select>
                                    </div>
                                    </label>
                                </div>
                            </div>

                            <div class="kensaku-btn">
                                <input type="submit" class="btn" value="検索">
                            </div>
                            
                        </form>
                    </div>
                </div>
            </div>
        </div>    
        <div class='indexwrap'>
            <div class='search'>
                <div class='searchwrap2'>
            @foreach($bandusers as $banduser)
                <div class="bandshow">
                     <div class="bandshowwrap">
                        <div class="showimage">
                            <a href='/bandshow/{{ $banduser->id }}'><img src="{{ '/storage/' . $banduser->image }}" class='artistimage'></a>
                        </div>
                        <a href='/bandshow/{{ $banduser->id }}'>{{ $banduser->name }}</a><br>
                        <th class='name'>{{ $banduser->genre }}</th><br>
                        <th class='name'>{{ $banduser->prefecture }}</th><br>
                        <th class='name'>{{ Str::limit($banduser->biography, 70, '...') }}</th>
                    </div>
                </div>
            @endforeach

                </div>
            <div class="paginate">          
                {{ $bandusers->appends(request()->query())->links('vendor.pagination.semantic-ui') }}
            </div>

            </div>
        </div>


	</body>
</html>