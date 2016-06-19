@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">Bienvenue sur le site de La Source</div>

                <div class="panel-body">
                    <div class="col-md-3 relais" style="background-color:#ccc">
                        <h3>Les relais</h3>
                        @foreach ($relaiss as $relais)
                        <p class="encadred2">
                            <h4>{{ $relais->ville }}</h4>
                            {{ $relais->retrait }}
                        </p>
                        {{ $relais->nom }}<br />
                        {{ $relais->ad1 }}<br />
                        @if($relais->ad2)
                        {{ $relais->ad2 }}<br />
                        @endif
                        {{ $relais->cp }} {{ $relais->ville }}<br />
                        {{ $relais->tel }}<br />
                        {{ $relais->email }}
                        <p>{{ $relais->ouvertures }}</p>
                        <p>{{ $relais->remarques }}</p>
                        <hr />
                        @endforeach
                    </div>
                    <div class="col-md-9">
                        <ul>
                            <li>Liste des paniers (tous ??) avec les prochaines livraisons.</li>
                            <li>Coordonnées complètes de La Source :</li>
                        </ul>
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
<h4>Présentation de l’Association La Source</h4>
@include('presentation')

@endsection

@section('footer3')
@parent

@endsection

