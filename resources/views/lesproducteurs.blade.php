@extends('layouts.app')

@section('topcontent1')
<h1 class="titrepage">{{ trans('titrepage.lesproducteurs') }}</h1>
@stop

@section('content')
                    <div class="col-md-3 producteur" style="background-color:#ccc">
                        @foreach ($producteurs as $producteur)
                        <p class="lighten33">
                            <h4>{{ $producteur->exploitation }}</h4>
                            {{ $producteur->prenom }} {{ $producteur->nom }}
                        </p>
                        {{ $producteur->ad1 }}<br />
                        @if($producteur->ad2)
                        {{ $producteur->ad2 }}<br />
                        @endif
                        {{ $producteur->cp }} {{ $producteur->ville }}<br />
                        {{ $producteur->tel }}<br />
                        @if($producteur->mobile)
                        {{ $producteur->mobile }}<br />
                        @endif
                        {{ $producteur->email }}
                        <p>{{ $producteur->remarques }}</p>
                        <hr />
                        @endforeach
                    </div>
@endsection
