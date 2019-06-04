<div id="modalError_" class="modal fade" tabindex="-1" role="dialog">

  <div class="modal-dialog" role="document">

    <div class="modal-content">

      <div class="modal-header">

        <h4 class="modal-title text-danger">{{ trans('modal.error.title') }}</h4>

        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true"><i class="fas fa-times align-text-bottom"></i></span>
        </button>

      </div>

      <div class="modal-body">

        <p><strong>{{ trans('modal.error.text') }}</strong></p>
        <p><strong>{{ trans('modal.error.try-again') }}</strong></p>

      </div>

      <div class="modal-footer">

        <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="fa fa-home"></i></button>

      </div>

    </div>

  </div>

</div>
