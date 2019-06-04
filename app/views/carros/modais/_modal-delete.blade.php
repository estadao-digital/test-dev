<div id="modalDelete_" class="modal fade" tabindex="-1" role="dialog">

  <div class="modal-dialog" role="document">

    <div class="modal-content">

      <div class="modal-header">

        <span><h3><i class="fas fa-trash-alt"></i> {{ trans('modal.delete.title') }}</h3></span>

        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true"><i class="fas fa-times align-text-bottom"></i></span>
        </button>

      </div>

      <div class="modal-body">

        <p><strong>{{ trans('modal.delete.text') }}</strong></p>

        <ul class="list-group list-group-flush">

          <li class="list-group-item d-flex justify-content-between align-items-center p-1">

            <span class="badge badge-dark badge-pill">{{ trans('table.lbl.modelo') }}</span>

            <p class="modelo"></p>

          </li>

          <li class="list-group-item d-flex justify-content-between align-items-center p-1">

            <span class="badge badge-secondary badge-pill">{{ trans('table.lbl.marca') }}</span>

            <p class="marca"></p>

          </li>

          <li class="list-group-item d-flex justify-content-between align-items-center p-1">

            <span class="badge badge-secondary badge-pill">{{ trans('table.lbl.ano') }}</span>

            <p class="ano"></p>

          </li>

        </ul>

      </div>

      <div class="modal-footer">

        <button type="button" class="btn btn-secondary cancelar" data-dismiss="modal"><i class="fa fa-home"></i></button>

        {{ Form::open(['id' => 'deleteForm', 'url' => '']) }}

          <a class="btn btn-danger delete-car" href=""><i class="fa fa-save"></i></a>

        {{ Form::close() }}

      </div>

    </div>

  </div>

</div>
