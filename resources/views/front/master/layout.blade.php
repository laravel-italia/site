<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        @yield('head')

        <link rel="shortcut icon" href="{{ url('favicon.png') }}" />

        <link href='https://fonts.googleapis.com/css?family=Source+Sans+Pro:600,400,300' rel='stylesheet' type='text/css' />
        <link href='https://fonts.googleapis.com/css?family=Inconsolata' rel='stylesheet' type='text/css' />

        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.6.1/css/font-awesome.min.css" />

        <link rel="stylesheet" href="{{ url('css/style.css') }}" />
    </head>

    <div class="container">
        @include('front.master.menu')
    </div>
    <div class="separator"></div>

    <main>
        @yield('contents')
    </main>

    <footer>
        <div class="fw_block primarybg">
            <div class="container pb0 pt0">
                <div class="row">
                    <div class="col-md-12">
                        <p>
                            <b>Laravel-Italia.it</b> :: Made by <a href="http://hellofrancesco.com" target="_blank"><i>Francesco Malatesta</i></a> - <a href="{{ url('privacy') }}"><i>Privacy & Cookie Policy</i></a>
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <div id="to_top"><i class="fa fa-angle-up"></i></div>
    </footer>

    <script src="{{ url('js/jquery.min.js') }}"></script>
    <script src="{{ url('js/bootstrap.min.js') }}"></script>
    <script src="{{ url('js/app.js') }}"></script>

    @yield('scripts')

    <script>
        (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
                    (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
                m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
        })(window,document,'script','https://www.google-analytics.com/analytics.js','ga');

        ga('create', 'UA-30751113-2', 'auto');
        ga('send', 'pageview');

    </script>
</html>