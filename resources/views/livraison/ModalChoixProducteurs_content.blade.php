<table class="col-md-12">
  <tbody>
    @foreach($producteurs as $producteur)

    @if($producteur->lied)
    <tr class="choisirunproducteur ombrable {{ $producteur->lied }}">

      <td>
        <button type="button" class="btn btn-warning btn-xs">
          <i class="fa fa-btn fa-check"></i>Retirer ce producteur
        </button>
      </td>

      <td>
        <div class"type">{{ $producteur->nompourpaniers }}</div>  
      </td>

      @else
      <tr class="choisirunproducteur ombrable">

        <td>
          <button type="button" class="btn btn-primary btn-xs">
            <i class="fa fa-btn fa-check"></i>Ajouter ce producteur
          </button>
        </td>

        <td>
          <div class"type">{{ $producteur->nompourpaniers }}</div>  
        </td>

      </tr>
      @endif
      @endforeach

    </tbody>
  </table>