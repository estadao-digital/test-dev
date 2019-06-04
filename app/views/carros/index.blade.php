@extends('template')

@section('CSS')
@endsection

@section('CONTENT')

<div class="card-header">

  <div class="card-title">
    <h2>{{ trans('application.lbl.carros.list') }}</h2>
  </div>

</div>

<div class="card-body">

  <table id="carrosTableContainer" class="table-striped table-sm">

    <div id="buttons-toolbar">

      <a
        id="cadastrar-btn"
        class="btn btn-success"
        href="#modalCreate_"
        data-toggle="modal"
        data-tooltip="tooltip" data-placement="top" title="Cadastrar">
        {{ trans('application.lbl.create') }}
      </a>

    </div>

  </table>

</div>

<div class="card-footer">
  <p><b>{{ trans('application.created.by') }}</b></p>
</div>

@endsection

@section('SCRIPTS')
@endsection
