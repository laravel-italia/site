<header>
    <div class="top">
        <a href="{{ url('/') }}">
            <div id="logo">
                <img src="{{ url('images/logo.png') }}" alt="logo" class="pull-left" />
                <div class="pull-left">
                    <h4 class="text-primary">Laravel Italia</h4>
                    <span class="text-primary text-uppercase">LA COMMUNITY ITALIANA DI LARAVEL</span>
                </div>
            </div>
        </a>

        <div class="user_buttons">
            @if(Auth::check())
                <a href="{{ url('admin/dashboard') }}" class="login">Amministrazione</a>
            @endif
        </div>

        <nav class="navbar navbar-default">
            <div class="container-fluid">
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                </div>

                <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                    <ul class="nav navbar-nav">
                        <li>
                            <a href="{{ url('articoli') }}">Articoli</a>
                        </li>
                        <li>
                            <a href="{{ url('serie') }}">Serie</a>
                        </li>
                        <li>
                            <a href="{{ Config::get('site.forum_url') }}" target="_blank">Forum</a>
                        </li>
                        <li>
                            <a href="{{ Config::get('site.slack_url') }}">Slack</a>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
    </div>
</header>
