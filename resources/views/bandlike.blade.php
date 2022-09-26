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
    </script>
</head>

<header>
    <div class="header">
        @include('livehouseheader')
    </div>
</header>


<body>
    <div class='like-wrap'>
        <div class='like-inner'>
            <div class='like-text'>
                <h2><a href='/bandlikeshow/{{ $users->id }}'>お気に入り一覧へ</a><br></h2>
                <h2><a href='/livehouseindex'>バンド一覧へ</a></h2>
            </div>
        </div>
    </div>
</body>
</html>