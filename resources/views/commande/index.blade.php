@extends('layouts.app')

@section('titre')
@parent
@endsection



@section('topcontent1')
<h1 class="titrepage">{{ trans('titrepage.commande.index') }}</h1>

@endsection



@section('message')
@parent
@endsection


@section('content')

{{ $models->links() }}

<table class="index_commandes  colmd12">
       <thead>
               <th style="width:10%">
                       N°
               </th>
               <th  style="width:15%">
                       Client
               </th>
               <th  style="width:30%">
                       Paniers commandés
               </th>
               <th  style="width:15%">
                       Livraison concernée
               </th>
               <th style="width:10%">
                       Paiement
               </th>
               <th style="width:25%">
                       Relais
               </th>
               <th style="width:10%">
                       Statut
               </th>
       </thead>

       <tbody>

               @foreach($models as $model)

               @include('commande.index_row')

               @endforeach

       </tbody>

</table>


@endsection

@section('script')
@parent
@endsection
