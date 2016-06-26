<tr class="">
    <td></td>
    <td colspan="4">


    <form class="form-inline" role="form" method="POST" action="{{ route('livraison.store') }}">
            {!! csrf_field() !!}

@include('livraison.form')

            <button type="submit" class="btn btn-xs btn-primary">
                <i class="fa fa-btn fa-user"></i>Valider
            </button>

    </form>
    </td>
</tr>