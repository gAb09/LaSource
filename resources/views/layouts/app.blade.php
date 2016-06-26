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
<body id="app-layout" class="layout_flexcontainer">
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
                    @if (Auth::guest())
                    <!-- Infos sur les Paniers et La Source -->
                        @include('layouts.menuLeft.guest')
                    @endif
                </ul>

                <!-- Right Side Of Navbar -->
                <ul class="nav navbar-nav navbar-right">
                    @include('layouts.menuRight.dev')
                    @if (Auth::guest())
                    <!-- Authentication Links -->
                        @include('layouts.menuRight.guest')
                    @else
                        @include('layouts.menuRight.auth')
                    @endif
                </ul>
            </div>
        </div>
    </nav>

    <!-- - - - - - - - - - - - - - - - MESSAGES - - - - - - - - - - - - - - -->
    @section('message')
    <div class="container-fluid">
        <div class="col-md-12 messages">
            @if (session('status'))
            <div class="alert alert-danger">
                {!! session('status') !!}
            </div>
            @endif
            @if (session('success'))
            <div class="alert alert-success">
                {!! session('success') !!}
            </div>
            @endif
        </div>
    </div>
    @show

    <!-- - - - - - - - - - - - - - - - TOP CONTENT (2 zones) - - - - - - - - - - - - - - -->
    <main class="layout-flexcontent">
    <div class="container-fluid">

        <div class="col-md-6 topcontent1">
            @yield('topcontent1')
        </div>

        <div class="col-md-6 topcontent2">
            @yield('topcontent2')
        </div> 
    </div>

    <!-- - - - - - - - - - - - - - - -  CONTENT (2 zones) - - - - - - - - - - - - - - -->
    @yield('content')
    </main>

    @include('layouts.footer')

    <!-- JavaScripts -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
    {{-- <script src="{{ elixir('js/app.js') }}"></script> --}}
    @section('script')
    <script src="/js/global.js"></script>
    @show

</body>
</html>