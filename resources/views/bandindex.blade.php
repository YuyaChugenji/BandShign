<!DOCTYPE html>
<html>
	<head>
		<meta charset="UTF-8" />
		<title>BandSign</title>
		<!--  css を読み込ませる -->
        <link rel="stylesheet" type="text/css" href="{{('/css/base.css')}}">
        <link rel="stylesheet" type="text/css" href="{{('/css/style.css')}}">
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
		    @include('bandheader')
        </div>
	</header>

	<body>
        <div class='indexwrap'>
            <div class='searchform'>
                <div class='searchwrap'>
                    <div class="">
                        <form action="{{ route('bandindex') }}" method="GET">
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
                                                    <option value="{{ $selectprefecture }} "selected ="selected">{{ $selectprefecture }}</option>
                                                @else
                                                    <option value="{{ $prefecture->prefecture }}" >{{ $prefecture->prefecture }}</option>
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
                    @foreach($livehouseusers as $livehouseuser)
                    <div class="bandshow">
                        <div class="bandshowwrap">
                            <div class="showimage">
                                <a href='/livehouseshow/{{ $livehouseuser->id }}'><img src="{{ '/storage/' . $livehouseuser->image }}" class='artistimage'></a>
                            </div>
                            <a href='/livehouseshow/{{ $livehouseuser->id }}'>{{ $livehouseuser->name }}</a><br>
                            <th class='name'>{{ $livehouseuser->prefecture }}</th><br>
                            <th class='name'>{{ Str::limit($livehouseuser->biography, 70, '...') }}</th>
                        </div>
                    </div>
                    @endforeach
                </div>
            <div class="paginate">
                {{ $livehouseusers->appends(request()->query())->links('vendor.pagination.semantic-ui') }}
            </div>
            </div>
        </div>
	</body>
</html>