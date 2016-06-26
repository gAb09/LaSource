<!-- id -->
<div>
    {{ $item->id }}
</div>


<!-- date_cloture -->
<div>
    <input type="text" class="form-control" name="date_cloture" value="{{ $item->date_cloture or old('date_cloture') }}">
</div>


<!-- date_paiement -->
<div>
    <input type="text" class="form-control" name="date_paiement" value="{{ $item->date_paiement or old('date_paiement') }}">
</div>


<!-- date_livraison -->
<div>
    <input type="text" class="form-control" name="date_livraison" value="{{ $item->date_livraison or old('date_livraison') }}">
</div>

