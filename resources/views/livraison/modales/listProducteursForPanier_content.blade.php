<form id="PanierSyncProducteurs" class="form-inline" role="form" method="POST" action="{{ route('PanierSyncProducteurs', [$panier_id]) }}">
  {!! csrf_field() !!}
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
  <button type="submit" class="btn btn-primary">Save changes</button>
</form>