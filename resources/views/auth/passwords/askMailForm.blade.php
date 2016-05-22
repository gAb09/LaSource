@extends('layouts.app')

<!-- Main Content -->
@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3>@yield('titre')</h3>
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

                </div>
                <div class="panel-body">
                    @yield('action')
                        {!! csrf_field() !!}

                        <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                            <label class="col-md-4 control-label">E-Mail Address</label>

                            <div class="col-md-6">
                                <input type="email" class="form-control" name="email" value="{{ old('email') }}">

                                @if ($errors->has('email'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-6 col-md-offset-4">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fa fa-btn fa-envelope"></i>Envoyer
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
