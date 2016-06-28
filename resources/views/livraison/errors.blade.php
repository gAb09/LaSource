    @if ($errors->has('date_cloture'))
    <div class="alert alert-danger">
        {{ $errors->first('date_cloture') }}
    </div>
    @endif

    @if ($errors->has('date_paiement'))
    <div class="alert alert-danger">
        {{ $errors->first('date_paiement') }}
    </div>
    @endif


    @if ($errors->has('date_livraison'))
    <div class="alert alert-danger">
        {{ $errors->first('date_livraison') }}
    </div>
    @endif
