{{ Form::open(['id' => 'carroForm', 'url' => '']) }}

<div class="form-row">

  <div class="form-group col-md-12">

    {{ Form::label('modelo', trans('modal.form.lbl.modelo')) }}

    <div class="input-group">

      <div class="input-group-prepend">
        <span class="input-group-text">
          <i class="fas fa-car"></i>
        </span>
      </div>

      {{ Form::text(
          'carro[modelo]',
          null,
          array(
            'class' => 'form-control modelo',
            'placeholder' => trans('modal.form.plh.modelo')
          )
        )
      }}

    </div>

  </div>

</div>

<div class="form-row">

  <div class="form-group col-md-8">

    {{ Form::label('marca', trans('modal.form.lbl.marca')) }}

    <div class="input-group">

      <div class="input-group-prepend">
        <span class="input-group-text">
          <i class="fas fa-car"></i>
        </span>
      </div>

      {{ Form::select(
          'carro[marca]',
          [''=>'SELECIONE'],
          null,
          array(
            'class' => 'form-control marca select-marca',
            'placeholder' => trans('modal.form.plh.marca')
          )
        )
      }}

    </div>

  </div>

  <div class="form-group col-md-4">

    {{ Form::label('ano', trans('modal.form.lbl.ano')) }}

    <div class="input-group">

      <div class="input-group-prepend">
        <span class="input-group-text">
          <i class="fas fa-car"></i>
        </span>
      </div>

      {{ Form::number(
          'carro[ano]',
          null,
          array(
            'class' => 'form-control ano',
            'placeholder' => trans('modal.form.plh.ano')
          )
        )
      }}

    </div>

  </div>

</div>

<div class="form-row">
  <ul class="error-list">
    <li class="error modelo-error"></li>
    <li class="error marca-error"></li>
    <li class="error ano-error"></li>
  </ul>
</div>

{{ Form::close() }}
