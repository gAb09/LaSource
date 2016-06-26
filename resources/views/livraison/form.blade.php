<!-- id -->

    {{ $item->id }}


<!-- date_cloture -->

    <input type="text" class="form-control" name="date_cloture" value="{{ $item->date_cloture or old('date_cloture') }}">

    @if ($errors->has('date_cloture'))
    <span class="help-block">
        <strong>{{ $errors->first('date_cloture') }}</strong>
    </span>
    @endif


<!-- date_paiement -->

    <input type="text" class="form-control" name="date_paiement" value="{{ $item->date_paiement or old('date_paiement') }}">

    @if ($errors->has('date_paiement'))
    <span class="help-block">
        <strong>{{ $errors->first('date_paiement') }}</strong>
    </span>
    @endif


<!-- date_livraison -->

    <input type="text" class="form-control" name="date_livraison" value="{{ $item->date_livraison or old('date_livraison') }}">

    @if ($errors->has('date_livraison'))
    <span class="help-block">
        <strong>{{ $errors->first('date_livraison') }}</strong>
    </span>
    @endif

