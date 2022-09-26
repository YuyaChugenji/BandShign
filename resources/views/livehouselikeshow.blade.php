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
            <div class='search'>
                <div class="likeshow_title">
                    <h2>お気に入り登録一覧</h2>
                </div>
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