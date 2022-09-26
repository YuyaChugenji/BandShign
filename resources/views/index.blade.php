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

        

    </script>
</head>

<header>
    <div class="header">

    @include('header')
    </div>

</header>

<body>
    <div class='wrap'>
        <div class='top'>
            <h2>Band Sign</h2>
            <p>
                サイトの説明
            </p>
        </div>

        <div class='login'>
            <div class='loginwrap'>
            <form action="./index" method="POST">
            @csrf
                <div class='email'>
                    <label>メールアドレス</label><br>
                    <input class='formareaa' type="email" name="email" required><br>
                </div>
                <div class='password'>
                    <label>パスワード</label><br>
                    <input class='formareaa' type="password" name="password" required><br>
                </div>
                <div class='password'>
                    <input class='formareab' type="submit" name="login" value="ログイン">
                </div>
                <div class='password'>
                    </p><a href="{{ route('bandsignup') }}">新規登録バンドアカウント作成</a>
                </div>
                <div class='password'>
                    </p><a href="{{ route('livehousesignup') }}">新規登録ライブハウスアカウント作成</a>
                </div>
                <div class='password'>
                    </p><a href="{{ route('forgetpassword') }}">パスワードをお忘れの方</a>
                </div>
            </form>
            </div>
        </div>
    </div>


</body>
</html>