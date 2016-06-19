@extends('layouts.app')

@section('topcontent1')
<h1 class="titrepage">Les paniers de viande bio de La Source</h1>
@stop

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-body">
                    <div class="col-md-9">
                        @include('accueil_texte')
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('footer1')
@parent

@endsection

@section('footer2')
@parent
@endsection

@section('footer3')
@parent

@endsection

