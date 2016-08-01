    @extends('layouts.app')

@section('content')

<div class="container espace_client">
    <div class="row">
        <div class="">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h2>Espace client de {{$model->Client->prenom}} {{$model->Client->nom}}  ({{ $model->pseudo }})</h2>
                </div>

                <div class="panel-body">

                    <h3>Mes coordonnées</h3>
                    {{ $model->Client->prenom }} {{ $model->Client->nom }} ({{ $model->pseudo }})<br />
                    {{ $model->Client->ad1 }}<br />
                    {{ $model->Client->ad2 }}<br />
                    {{ $model->Client->cp }} {{ $model->Client->ville }}<br />
                    Tél : {{ $model->Client->tel }}<br />
                    Portable : {{ $model->Client->mobile }}<br />
                    Courriel : {{ $model->email }}<br />
                    Rôle : {{ $model->role->etiquette }}<br />
                    
                </div>
                <div class="panel-body">

                    <h3>Mes commandes</h3>
                    sfljdLJm<br />                    
                    dsf.,F=,fd=<br />                    
                    gEGdf,lg,<br />                    
                    F,f;,=é'tqgfhg<br />                    
                    v,;:c ;:,ùqfe<br />                    
                    fldflù  ù<br />                    
                </div>

            </div>
        </div>
    </div>
</div>
@endsection
