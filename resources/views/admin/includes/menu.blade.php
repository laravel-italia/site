<!-- Navigation -->
<nav class="navbar navbar-default navbar-static-top" role="navigation" style="margin-bottom: 0">
    <div class="navbar-header">
        <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
        </button>
        <a class="navbar-brand" href="{{ url('admin/dashboard') }}">Amministrazione :: Laravel-Italia.it</a>
    </div>
    <!-- /.navbar-header -->

    <ul class="nav navbar-top-links navbar-right">
        <!-- /.dropdown -->
        <li class="dropdown">
            <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                {{ Auth::user()->name }} <i class="fa fa-user fa-fw"></i>  <i class="fa fa-caret-down"></i>
            </a>
            <ul class="dropdown-menu dropdown-user">
                <li><a href="{{ url('/') }}"><i class="fa fa-rocket fa-fw"></i> Vai al Sito</a>
                </li>
                <li class="divider"></li>
                <li><a href="{{ url('logout') }}"><i class="fa fa-sign-out fa-fw"></i> Logout</a>
                </li>
            </ul>
            <!-- /.dropdown-user -->
        </li>
        <!-- /.dropdown -->
    </ul>
    <!-- /.navbar-top-links -->

    <div class="navbar-default sidebar" role="navigation">
        <div class="sidebar-nav navbar-collapse">
            <ul class="nav" id="side-menu">
                <li>
                    <a href="{{ url('admin/dashboard') }}"><i class="fa fa-dashboard fa-fw"></i> Pagina Principale</a>
                </li>
                <li>
                    <a href="#"><i class="fa fa-pencil fa-fw"></i> Articoli<span class="fa arrow"></span></a>
                    <ul class="nav nav-second-level">
                        <li>
                            <a href="{{ url('admin/articles/add') }}">Scrivi Nuovo</a>
                        </li>
                        <li>
                            <a href="{{ url('admin/articles') }}">Elenco</a>
                        </li>
                    </ul>
                </li>
                <li>
                    <a href="{{ url('admin/media') }}"><i class="fa fa-upload fa-fw"></i> Media</a>
                </li>
                @if(Auth::user()->isAdministrator())
                    <li>
                    <a href="#"><i class="fa fa-th-list fa-fw"></i> Serie<span class="fa arrow"></span></a>
                    <ul class="nav nav-second-level">
                        <li>
                            <a href="{{ url('admin/series/add') }}">Aggiungi Nuova</a>
                        </li>
                        <li>
                            <a href="{{ url('admin/series') }}">Elenco</a>
                        </li>
                    </ul>
                </li>
                    <li>
                    <a href="{{ url('admin/categories') }}"><i class="fa fa-files-o fa-fw"></i> Categorie</a>
                </li>
                <li>
                    <a href="{{ url('admin/users') }}"><i class="fa fa-group fa-fw"></i> Utenti</a>
                </li>
                @endif
            </ul>
        </div>
        <!-- /.sidebar-collapse -->
    </div>
    <!-- /.navbar-static-side -->
</nav>