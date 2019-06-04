<div id="modalCreate_" class="modal fade" tabindex="-1" role="dialog">

  <div class="modal-dialog modal-lg">

    <div class="modal-content">

      <div class="modal-header">

        <span><h3><i class="fas fa-save"></i> {{ trans('modal.create.title') }}</h3></span>

        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true"><i class="fas fa-times align-text-bottom"></i></span>
        </button>

      </div>

      <div class="modal-body">

        @include('carros/_form')

        <div class="form-row">
          <ul class="error-list">
            <li class="error modelo-error-create"></li>
            <li class="error marca-error-create"></li>
            <li class="error ano-error-create"></li>
          </ul>
        </div>

      </div>

      <div class="modal-footer">

        <button type="button" class="btn btn-danger cancelar" data-dismiss="modal"><i class="fa fa-home"></i></button>

        <button type="button" class="store-car btn btn-info"><i class="fa fa-save"></i></button>

      </div>

    </div>

  </div>

</div>
