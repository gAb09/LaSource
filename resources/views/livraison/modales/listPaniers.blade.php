<!-- Modal -->
<div class="modal-listPaniers" role="document">
  <div class="modal-content">

    <div class="modal-header">
      <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
      <h4 class="modal-title" id="myModalLabel">
        {!! $titre_page !!}
      </h4>
    </div>

    <div id="modal-body" class="modal-body col-md-12 flexcontainer">
      @include('livraison.modales.listPaniers_content')
    </div>

    <div class="modal-footer">
      <button type="button" class="btn btn-sm btn-default" data-dismiss="modal">Close</button>
    </div>
  </div>
</div>