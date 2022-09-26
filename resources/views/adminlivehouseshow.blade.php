

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

        <script src="https://maps.googleapis.com/maps/api/js?language=ja&region=JP&key=AIzaSyBHo301aAM5kr1EC3SfZe0vY2pcIOuP9Cc&callback=initMap" async defer></script>
	    <script src="https://cdn.geolonia.com/community-geocoder.js"></script>
        <script type="text/javascript" src="//maps.google.com/maps/api/js?sensor=false"></script>

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

        $(function () {
            getLatLng([北海道恵庭市島松], (result) => {
                console.log("緯度: ", result.lat);
                console.log("経度: ", result.lng);
            });
        });

        // Google Mapを表示する関数
        function initMap() {
        const geocoder = new google.maps.Geocoder();
        // ここでaddressのvalueに住所のテキストを指定する
        geocoder.geocode( { address: '{{ $livehouseuser->postcode }}{{ $livehouseuser->prefecture }}{{ $livehouseuser->city }}{{ $livehouseuser->block }}{{ $livehouseuser->building }}'}, function(results, status) {
            if (status === google.maps.GeocoderStatus.OK) {
            const latlng = {
                lat: results[0].geometry.location.lat(),
                lng: results[0].geometry.location.lng()
            }
            const opts = {
                zoom: 15,
                center: new google.maps.LatLng(latlng)
            }
            const map = new google.maps.Map(document.getElementById('map'), opts)
            new google.maps.Marker({
                position: latlng,
                map: map 
            })
            } else {
            console.error('Geocode was not successful for the following reason: ' + status)
            }
        })
            
        }

		</script>
	</head>

	<header>
        <div class="header">
		@include('adminheader')
        </div>

	</header>

	<body>
        <div class='indexwrap'>
            <div class='showwrap'>
                <div class='showmain'>
                    <div class="showbiography1">
                        <div class="bandshowwrap3">
                            <div class="showimage2">
                                <img src="{{ '/storage/' . $livehouseuser->image }}" class='artistimage3'>
                            </div>
                        </div>
                        <div class="showtextform">
                            <th class='showtext'>ライブハウス名:{{ $livehouseuser->name }}</th><br>
                            <th class='showtext'>郵便番号:{{ $livehouseuser->postcode }}</th><br>
                            <th class='showtext'>住所:{{ $livehouseuser->prefecture }}</th><br>
                            <th class='showtext'>{{ $livehouseuser->city }}</th><br>
                            <th class='showtext'>{{ $livehouseuser->block }}</th><br>
                            <th class='showtext'>{{ $livehouseuser->building }}</th><br>
                            <form action="" method="post" id="form" enctype="multipart/form-data">
                                @csrf
                                <td>
                                    <input id="deleteBtn" type="submit" name="send" onclick="return confirm('削除しますか？')" value="削除">
                                    <input type="hidden" name="id" value='{{ $livehouseuser->id }}'>
                                </td>
                            </form>
                        </div>
                    </div>
                    <div class="livehouse-prefecture">
                        <th>住所:〒{{ $livehouseuser->postcode }}{{ $livehouseuser->prefecture }}{{ $livehouseuser->city }}{{ $livehouseuser->block }}{{ $livehouseuser->building }}</th><br>
                    </div>
                    <div id="map" style="height:300px"></div>
                    <div class='livehouse-back'>
                        </p><a href="{{ route('bandindex') }}">ライブハウス一覧へ戻る</a>
                    </div>
                </div>
            </div>
        </div>
	</body>
</html>