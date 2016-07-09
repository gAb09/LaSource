<!-- Modal -->
<form id="syncPaniers" class="form-inline" role="form" method="POST" action="{{ route('ProducteurSyncPaniers', [$panier_id]) }}">
  {!! csrf_field() !!}
  <div class="modal-choixproducteurs" role="document">
    <div class="modal-content">

      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="ModalPanierSyncProducteursLabel">
          {!! $titre_page !!}
        </h4>
      </div>

      <div id="modal-bodyChoixProducteurs" class="modal-body col-md-12 ChoixProducteurs">
        @include('livraison.modales.listeProducteursPourPanier_content')
      </div>

      <div class="modal-footer">
        <button type="button" class="btn btn-sm btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</form>