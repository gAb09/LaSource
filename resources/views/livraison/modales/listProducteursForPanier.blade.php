<!-- Modal -->
    <div class="modal-choixproducteurs" role="document">
      <div class="modal-content">

        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <h4 class="modal-title" id="ModallistProducteursForPanierLabel">
            {!! $titre_page !!}
          </h4>
        </div>

        <div class="modal-body col-md-12 ChoixProducteurs">
          @include('livraison.modales.listProducteursForPanier_content')
        </div>

        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
      </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
