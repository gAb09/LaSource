<!-- <!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Laravel</title>

    <!-- Fonts -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.4.0/css/font-awesome.min.css" rel='stylesheet' type='text/css'>
    <link href="https://fonts.googleapis.com/css?family=Lato:100,300,400,700" rel='stylesheet' type='text/css'>

    <!-- Styles -->
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" rel="stylesheet">
    {{-- <link href="{{ elixir('css/app.css') }}" rel="stylesheet"> --}}

    <!-- Styles persos -->
    <link href="/css/global.css" rel="stylesheet">

    <style>
    body {
        font-family: 'Lato';
    }

    .fa-btn {
        margin-right: 6px;
    }
    </style>
</head>
<body id="app-layout">
    <nav class="navbar navbar-default navbar-static-top">
        <div class="container">
            <div class="navbar-header">

                <!-- Collapsed Hamburger -->
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#app-navbar-collapse">
                    <span class="sr-only">Toggle Navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>

                <!-- Branding Image -->
                <a class="navbar-brand" href="{{ url('/') }}">
                    Les paniers de La Source<br />

                </a>
            </div>

            <div class="collapse navbar-collapse" id="app-navbar-collapse">
                <!-- Left Side Of Navbar -->
                <ul class="nav navbar-nav">
                    <li><p>Statut du transfert : {{ Session::get('transfert_statut') }}</p></li>
                </ul>

                <!-- Right Side Of Navbar -->
                <ul class="nav navbar-nav navbar-right">
                    <!-- Authentication Links -->
                    @if (Auth::guest())

                    <li><a href="{{ url('/connexion') }}">Connexion</a></li>
                    <li><a href="{{ url('/register') }}">Inscription</a></li>
                    @else
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                            {{Auth::user()->pseudo }} <span class="caret"></span>
                        </a>

                        <ul class="dropdown-menu" role="menu">
                            <li><a href="{{ url('/logout') }}"><i class="fa fa-btn fa-sign-out"></i>Deconnexion</a></li>
                            <li><a href="{{ URL::route('client.edit', Auth::user()->id) }}">Modifier mes coordonnées</a></li>
                        </ul>
                    </li>
                    @endif
                </ul>
            </div>
        </div>
    </nav>

    <!-- - - - - - - - - - - - - - - - TOP CONTENT (2 zones) - - - - - - - - - - - - - - -->
    <div class="container-fluid">

        <div class="col-md-6 topcontent1">
            @yield('topcontent1')
        </div>

        <div class="col-md-6 topcontent2">
            @yield('topcontent2')
        </div> 
    </div>


    @yield('content')

    <div class="container-fluid col-md-12 footermain">
        <div class="col-md-12 footer closed" onClick="javascript:gererVolet(this)">
            @section('footer')
            @show
            <div class="col-md-6 footer1">
                @section('footer1')
                Association La Source<br />
                {{Html::linkAction('ContactController@ContactLS', 'Contacter La Source par courriel')}}
                @show
            </div>

            <div class="col-md-6 footer2">
                @section('footer2')
                Pour tout problème relatif à l'inscription, la connexion ou un message d’erreur :<br />
                {{Html::linkAction('ContactController@ContactOM', 'Contacter le Ouaibmaistre par courriel')}}
                @show
            </div>
        </div> 
    </div>



    <!-- JavaScripts -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
    {{-- <script src="{{ elixir('js/app.js') }}"></script> --}}
    @section('script')
    <script src="/js/global.js"></script>
    @show

</body>
</html>