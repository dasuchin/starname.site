<!DOCTYPE html>
<!--[if lt IE 7 ]><html class="ie ie6" lang="en"> <![endif]-->
<!--[if IE 7 ]><html class="ie ie7" lang="en"> <![endif]-->
<!--[if IE 8 ]><html class="ie ie8" lang="en"> <![endif]-->
<!--[if (gte IE 9)|!(IE)]><!--><html lang="en"> <!--<![endif]-->
<head>
    <base href="{{ env('APP_URL') }}">
    <meta charset="utf-8">
    <title>Celestial Codex - Claim a star in the night sky</title>
    <meta name="description" content="">
    <meta name="author" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <link rel="stylesheet" href="{{ asset('css/base.css') }}">
    <link rel="stylesheet" href="{{ asset('css/skeleton.css') }}">
    <link rel="stylesheet" href="{{ asset('css/layout.css') }}">
    <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/datepicker.css') }}">
    <style type="text/css">
        body {
            padding-top: 45px;
        }
        .sidebar-nav {
            padding: 9px 0;
        }
    </style>
    @yield('css')
    <!--[if lt IE 9]>
    <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->
    <link href='https://fonts.googleapis.com/css?family=BenchNine' rel='stylesheet' type='text/css'>
    <link rel="shortcut icon" href="/favicon.ico" type="image/x-icon">
    <link rel="apple-touch-icon" href="{{ asset('images/apple-touch-icon.png') }}">
    <link rel="apple-touch-icon" sizes="72x72" href="{{ asset('images/apple-touch-icon-72x72.png') }}">
    <link rel="apple-touch-icon" sizes="114x114" href="{{ asset('images/apple-touch-icon-114x114.png') }}">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js"></script>
    <script src="{{ asset('js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('js/bootstrap-datepicker.js') }}"></script>
    <script src="{{ asset('js/jquery.nicescroll.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/jquery.fullscreenBackground.js') }}"></script>
    <script type="text/javascript">
        $(document).ready(function() {
            $('#content').css({'height':(($('body').height())-220)+'px'});
            $('#content-inner').css({'height':(($('body').height())-220-30)+'px'});

            $(window).resize(function(){
                $('#content').css({'height':(($('body').height())-220)+'px'});
                $('#content-inner').css({'height':(($('body').height())-220-30)+'px'});
            });

            $("#content-inner").niceScroll();
        });
    </script>

    <script src="{{ asset('js/countdown.js') }}"></script>
    <script src="{{ asset('js/script.js') }}"></script>

    <script type="text/javascript">
        var _gaq = _gaq || [];
        _gaq.push(['_setAccount', 'UA-84045-13']);
        _gaq.push(['_trackPageview']);

        (function() {
            var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
            ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
            var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
        })();
    </script>
    @yield('js')
</head>

<body>
<div id="topheader" style="z-index:6; position:absolute;">
    <div class="container">
        <div class="header">
            <div class="row sixteen.columns">
                <h1><img src="{{ asset('images/logo2.png') }}" /></h1>
            </div>
        </div>
        @yield('content')
    </div>
</div>

<div id="background-image">
    <img src="{{ asset('images/background.jpg') }}" alt="" width="800" height="600" />
</div>

<script type="text/javascript" src="{{ asset('js/all.js') }}"></script>
<script>
    jQuery("#background-image").fullscreenBackground();
    $("body").css("overflow", "hidden");
</script>

<div class="analytics" style="display:none"></div>
</body>
</html>