<form id="PanierSyncProducteurs" class="form-inline" role="form" method="POST" action="{{ route('PanierSyncProducteurs', [$panier_id]) }}">
  {!! csrf_field() !!}
    <div class="modemploi">
    Les producteurs fournissant ce panier sont surlignés en vert. Un clic sur sa ligne lie/délie un producteur.
  </div>

  <table class="col-md-12">
    <tbody>
      @foreach($producteurs as $producteur)

      @if($producteur->lied)
      <div class="flexcontainer choisirunpanier ombrable {{ $producteur->lied }}" onClick="javascript:toggleLied(this)">
        <input type="checkbox" class="hidden form-control" name="resultat[]" checked="checked" value="{{ $producteur->id }}">

        <div class"type">
          {{ $producteur->nompourpaniers }}
        </div>  

      </div>
      
      @else
      <div class="flexcontainer choisirunpanier ombrable {{ $producteur->lied }}" onClick="javascript:toggleLied(this)">
        <input type="checkbox" class="hidden form-control" name="resultat[]" value="{{ $producteur->id }}">

        <div class"type">
          {{ $producteur->nompourpaniers }}
        </div>  

      </div>
      @endif
      @endforeach

    </tbody>
  </table>
  <br />
  <button type="submit" class="btn btn-primary">Valider</button>
</form>