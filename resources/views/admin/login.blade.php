<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="description" content="">
        <meta name="author" content="">

        <title>Accedi :: Amministrazione :: Laravel-Italia.it</title>

        <link href="{{ url('assets') }}/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
        <link href="{{ url('assets') }}/metisMenu/dist/metisMenu.min.css" rel="stylesheet">
        <link href="{{ url('assets') }}/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
        <link href="{{ url('assets') }}/startbootstrap-sb-admin-2/dist/css/sb-admin-2.css" rel="stylesheet">

        <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
        <![endif]-->
    </head>

    <body>
        <div class="container">
            
            <div class="row">
                <div class="col-md-4 col-md-offset-4">
                    <div class="login-panel panel panel-default">
                        <div class="panel-heading">
                            <h3 class="panel-title">Amministrazione</h3>
                        </div>
                        <div class="panel-body">
                            <p>Inserisci le tue credenziali per accedere.</p>

                            <form role="form">
                                <fieldset>
                                    <div class="form-group">
                                        <input class="form-control" placeholder="E-mail" name="email" type="email" autofocus>
                                    </div>
                                    <div class="form-group">
                                        <input class="form-control" placeholder="Password" name="password" type="password" value="">
                                    </div>
                                    <div class="checkbox">
                                        <label>
                                            <input name="remember" type="checkbox" value="Remember Me">Remember Me
                                        </label>
                                    </div>

                                    <hr>

                                    @if(Session::has('error_message'))
                                        <div class="alert alert-danger alert-dismissable">
                                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                                            {{ Session::get('error_message') }}
                                        </div>
                                    @endif

                                    <!-- Change this to a button or input when using this as a form -->
                                    <a href="index.html" class="btn btn-lg btn-success btn-block">Login</a>
                                </fieldset>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-4 col-md-offset-4" style="text-align: center; margin-top:5%;">
                    <img src="{{ url('img/logo_small.png') }}" alt="logo" />
                </div>
            </div>
        </div>

        <script src="{{ url('assets') }}/jquery/dist/jquery.min.js"></script>
        <script src="{{ url('assets') }}/bootstrap/dist/js/bootstrap.min.js"></script>
        <script src="{{ url('assets') }}/metisMenu/dist/metisMenu.min.js"></script>
        <script src="{{ url('assets') }}/startbootstrap-sb-admin-2/dist/js/sb-admin-2.js"></script>
    </body>
</html>