<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="description" content="">
        <meta name="author" content="">

        <title>@yield('title') :: Amministrazione :: Laravel-Italia.it</title>

        <link href="{{ url('assets') }}/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
        <link href="{{ url('assets') }}/metisMenu/dist/metisMenu.min.css" rel="stylesheet">
        <link href="{{ url('assets') }}/startbootstrap-sb-admin-2/dist/css/timeline.css" rel="stylesheet">
        <link href="{{ url('assets') }}/startbootstrap-sb-admin-2/dist/css/sb-admin-2.css" rel="stylesheet">
        <link href="{{ url('assets') }}/morrisjs/morris.css" rel="stylesheet">
        <link href="{{ url('assets') }}/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">

        <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
        <![endif]-->
    </head>

    <body>

        <div id="wrapper">

            @include('admin.includes.menu')

            <!-- Page Content -->
            <div id="page-wrapper">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-lg-12">
                            <h1 class="page-header">@yield('title')</h1>
                        </div>
                    </div>

                    @yield('content')
                </div>
            </div>
        </div>

        <script src="{{ url('assets') }}/jquery/dist/jquery.min.js"></script>
        <script src="{{ url('assets') }}/bootstrap/dist/js/bootstrap.min.js"></script>
        <script src="{{ url('assets') }}/metisMenu/dist/metisMenu.min.js"></script>
        <script src="{{ url('assets') }}/raphael/raphael-min.js"></script>
        <script src="{{ url('assets') }}/morrisjs/morris.min.js"></script>

        @yield('scripts')

        <script src="{{ url('assets') }}/startbootstrap-sb-admin-2/dist/js/sb-admin-2.js"></script>

    </body>
</html>