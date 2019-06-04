<div id="modalEdit_" class="modal fade" tabindex="-1" role="dialog" data-id="" data-modelo="" data-marca="" data-ano="">

  <div class="modal-dialog modal-lg">

    <div class="modal-content">

      <div class="modal-header">

        <span><h3><i class="fas fa-edit"></i> {{ trans('modal.edit.title') }}</h3></span>

        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true"><i class="fas fa-times align-text-bottom"></i></span>
        </button>

      </div>

      <div class="modal-body">

        @include('carros/_form')

      </div>

      <div class="modal-footer">

        <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="fa fa-home"></i></button>

        <button type="button" class="update-car btn btn-info"><i class="fa fa-save"></i></button>

      </div>

    </div>

  </div>

</div>
