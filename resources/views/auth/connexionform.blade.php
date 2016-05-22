@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">

                    @if (session('alert.danger'))
                        <div class="alert alert-danger">
                            {!! session('alert.danger') !!}
                        </div>
                    @endif
                    @hasSection('alert-danger')
                        <div class="alert alert-danger">
                            @yield('alert-danger')
                        </div>
                    @endif

                    @if (session('alert.success'))
                        <div class="alert alert-success">
                            {!! session('alert.success') !!}
                        </div>
                    @endif
                    @hasSection('alert-success')
                        <div class="alert alert-success">
                            @yield('alert-success')
                        </div>
                    @endif

                    <h3>Connexion</h3>
                </div>
                <div class="panel-body">
                    <form class="form-horizontal" role="form" method="POST" action="{{ url('/connexion') }}">
                        {!! csrf_field() !!}

                        <div class="form-group{{ $errors->has('pseudo') ? ' has-error' : '' }}">
                            <label class="col-md-4 control-label">Pseudo</label>

                            <div class="col-md-6">
                                <input type="text" class="form-control" name="pseudo" value="{{ $oldPseudo or old('pseudo') }}">

                                @if ($errors->has('pseudo'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('pseudo') }}</strong>
                                </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                            <label class="col-md-4 control-label">Mot de passe</label>

                            <div class="col-md-6">
                                <input type="password" class="form-control" name="password">

                                @if ($errors->has('password'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('password') }}</strong>
                                </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-6 col-md-offset-4">
                                <div class="checkbox">
                                    <label>
                                        <input type="checkbox" name="remember"> Se souvenir de moi
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-6 col-md-offset-4">
                                <button type="submit" class="btn btn-primary" onClick="javascript:avert_transfert()">
                                    <i class="fa fa-btn fa-sign-in"></i>Se connecter
                                </button>

                                <a class="btn btn-link" href="{{ url('/password/reset') }}">Mot de passe oublié ?</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection