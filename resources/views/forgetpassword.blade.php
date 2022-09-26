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
</head>

<header>
    <div class="header">
        @include('header')
    </div>
</header>

<body>
    <div class='forget_wrap'>
        <div class='forget_inner'>
            <div class='loginwrap'>
                <div class="forgrtpass_title">
                    <h2>パスワード再発行</h2>
                </div>
                <form action="" method="POST">
                @csrf
                <label>ユーザーを選択してください。</label><br>
                <div class="forget_radio">
                    <div class="radio-inline">
                        <label>
                            <input type="radio" name="user" value="band" > バンド
                        </label>
                    </div>
                    <div class="radio-inline">
                        <label>
                            <input type="radio" name="user" value="livehouse" > ライブハウス
                        </label>
                    </div>
                </div>
                <div class='radio-email'>
                    <label>メールアドレス</label><br>
                    <input class='formareaa' type="email" name="email" required><br>
                </div>
                <div class='password'>
                    <input class='formareab' type="submit" name="send" value="再発行">
                </div>
            </form>
            <div class="forget_back">
                <a href='/index'>戻る</a>
            </div>
            </div>
        </div>
    </div>
</body>
</html>