<tr 
id="row_{{ $item->id }}" 
ondblclick = onDblClick="javascript:edit(this, {!! $item->id !!});"
>

    <!-- id -->
    <td>
        {{ $item->id }}
    </td>

    <!-- date_livraison -->
    <td>
        <input type="text" class="form-control" name="date_livraison" value="{{ $item->livraison or old('date_livraison') }}">

        @if ($errors->has('date_livraison'))
        <span class="help-block">
            <strong>{{ $errors->first('date_livraison') }}</strong>
        </span>
        @endif
    </td>

    <!-- date_cloture -->
    <td>
        <input type="text" class="form-control" name="date_paiement" value="{{ $item->paiement or old('date_paiement') }}">

        @if ($errors->has('date_paiement'))
        <span class="help-block">
            <strong>{{ $errors->first('date_paiement') }}</strong>
        </span>
        @endif
    </td>

    <!-- date_paiement -->
    <td>
        <input type="text" class="form-control" name="nom" value="{{ $item->nom or old('nom') }}">

        @if ($errors->has('nom'))
        <span class="help-block">
            <strong>{{ $errors->first('nom') }}</strong>
        </span>
        @endif
    </td>


</tr>
