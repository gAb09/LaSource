<!-- Modal -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-choisirpaniers" role="document">
    <div class="modal-content">

      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">
          <?php $date = ($item->date_livraisonFR)?'du '.$item->date_livraisonFR:'à venir';?>
          {!! trans('titrepage.livraison.choisirpaniers', ['date' => $date]) !!}
        </h4>
      </div>

      <div id="modal-body" class="modal-body col-md-12 flexcontainer">
        @include('livraison.choixpaniers_content')
      </div>

      <div class="modal-footer">
        <button type="button" class="btn btn-sm btn-default" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary" onClick="alert('Coucou Odile !!\nTu veux un panier ??');">Save changes</button>
      </div>
    </div>
  </div>
</div>
