<!-- <!DOCTYPE html -->
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>La Source</title>

    <!-- Fonts -->
    <link href="{{asset('font-awesome/css/font-awesome.min.css')}}" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Lato:100,300,400,700" rel='stylesheet' type='text/css'>

    <!-- Styles -->
    <link href="{{asset('bootstrap/dist/css/bootstrap.min.css')}}" rel="stylesheet">
    {{-- <link href="{{ elixir('css/app.css') }}" rel="stylesheet"> --}}
    <link href="{{asset('js/jquery-ui-1.11.4.custom/jquery-ui.min.css')}}" rel="stylesheet">
    <link href="{{asset('js/jquery-ui-1.11.4.custom/jquery-ui.structure.min.css')}}" rel="stylesheet">
    <link href="{{asset('js/jquery-ui-1.11.4.custom/jquery-ui.theme.min.css')}}" rel="stylesheet">



    <!-- Styles persos -->
    <link href="/css/lasource/global.css" rel="stylesheet">

    <style>
    body {
        font-family: 'Lato';
    }

    .fa-btn {
        margin-right: 6px;
    }
    </style>
</head>

<body id="app-layout" class="stickycontainer">
    @section('modal')
    @show
    <nav class="navbar navbar-default navbar-static-top">
        <div style="width:97%" class="container">
            <div class="navbar-header">


                <!-- Trigger modemploi -->
                @hasSection ('modemploi')
                <div class="modemploi_exists" onMouseOver="javascript:showModemploi();">
                    @else
                <div class="hidden">
                    @endif
                    ?
                </div>

                <!-- Collapsed Hamburger -->
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#app-navbar-collapse">
                    <span class="sr-only">Toggle Navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>


                <!-- Branding Image -->
                <a class="navbar-brand" href="{{ url('/') }}">
                    Les paniers<br />de La Source<br />
                </a>

            </div>

            <div class="collapse navbar-collapse" id="app-navbar-collapse">
                <!-- Left Side Of Navbar -->
                <ul class="nav navbar-nav">
                    @if (Auth::guest())
                    <!-- Infos sur les Paniers et La Source -->
                    @include('layouts.menuLeft.guest')
                    @else
                    @include('layouts.menuLeft.auth')
                    @endif
                </ul>

                <!-- Right Side Of Navbar -->
                <ul class="nav navbar-nav navbar-right">
                    @if (Auth::guest())
                    <!-- Authentication Links -->
                    @include('layouts.menuRight.guest')
                    @else
                    @include('layouts.menuRight.auth')
                    @if (Auth::user()->role->id == 1)
                    @include('layouts.menuRight.dev')
                    @endif
                    @endif
                </ul>
            </div>
        </div>
    </nav>

    <!-- - - - - - - - - - - - - - - - MODEMPLOI - - - - - - - - - - - - - - -->
    <div id="modemploi" class="modemploi" onClick="javascript:showModemploi();">
    @section('modemploi')
    @show
    </div>


    <!-- - - - - - - - - - - - - - - - MESSAGES - - - - - - - - - - - - - - -->
    @section('message')

    {{-- var_dump(\Session::all()) --}}
    {{-- var_dump(Auth::user()->role->id or "rr") --}}

    <div id="messages" class="col-md-6 col-md-offset-3 messages">
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
    @show


    <!-- - - - - - - - - - - - - - - - TOP CONTENT - - - - - - - - - - - - - - -->
    @hasSection('topcontent1')
    <main class="allowstickyfooter">

        <div class="container-fluid">

            <div class="col-md-12 topcontent1">
                @yield('topcontent1')
            </div>

        </div>
        @endif
        
    <!-- - - - - - - - - - - - - - - -  CONTENT () - - - - - - - - - - - - - - -->
    @yield('content')

    </main>

    @include('layouts.footer')

    <!-- JQuery (local) -->
    <script src="{{asset('js/jquery-ui-1.11.4.custom/external/jquery/jquery.js')}}"></script>

    <!-- JQuery UI (local) -->
    <script src="{{asset('js/jquery-ui-1.11.4.custom/jquery-ui.min.js')}}"></script>
    <script src="{{asset('js/jquery-ui-1.11.4.custom/datepicker-fr.js')}}"></script>

    <!-- JavaScripts
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>  -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
    {{-- <script src="{{ elixir('js/app.js') }}"></script> --}}
    @section('script')
    <script src="/js/global.js"></script>
    @show

</body>
</html>