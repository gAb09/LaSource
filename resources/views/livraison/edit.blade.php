<form class="form-inline flexcontainer" role="form" method="POST" action="{{ route('livraison.update', $item->id) }}">
    {!! csrf_field() !!}


    @include('livraison.form')

    <button type="submit" class="btn btn-xs btn-primary">
        <i class="fa fa-btn fa-user"></i>Valider
    </button>


</form>
