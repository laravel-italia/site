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
    @include('front.layout.menu')
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
                    <p style="text-align: center; color: #FFFFFF;"><b>Laravel-Italia.it</b> :: Made by <a href="http://hellofrancesco.com" target="_blank">Francesco Malatesta</a></p>
                </div>
            </div>
        </div>
    </div>

    <div id="to_top"><i class="fa fa-angle-up"></i></div>
</footer>

<script src="{{ url('js/jquery.min.js') }}"></script>
<script src="{{ url('js/bootstrap.min.js') }}"></script>
<script src="{{ url('js/app.js') }}"></script>
</html>