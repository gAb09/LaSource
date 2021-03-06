@extends('layouts.app')

@section('topcontent1')
<h1 class="titrepage">{{ trans('titrepage.lesrelais') }}</h1>
@endsection

@section('content')
                    <div class="col-md-3 relais" style="background-color:#ccc">
                        @foreach ($relaiss as $relais)
                        <p class="lighten50">
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
@endsection