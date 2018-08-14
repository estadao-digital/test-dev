@extends('product.layouts.master')

@section('content')

    <div class="well">

        {!! Form::open(['url' => '/processform', 'class' => 'form-horizontal']) !!}

        <fieldset>

            <legend>Legend</legend>

            <!-- Email -->
            <div class="form-group">
                {!! Form::label('email', 'Email:', ['class' => 'col-lg-2 control-label']) !!}
                <div class="col-lg-10">
                    {!! Form::email('email', $value = null, ['class' => 'form-control', 'placeholder' => 'email']) !!}
                </div>
            </div>

            <!-- Password -->
            <div class="form-group">
                {!! Form::label('password', 'Password:', ['class' => 'col-lg-2 control-label']) !!}
                <div class="col-lg-10">
                    {!! Form::password('password',['class' => 'form-control', 'placeholder' => 'Password', 'type' => 'password']) !!}
                    <div class="checkbox">
                        {!! Form::label('checkbox', 'Checkbox') !!}
                        {!! Form::checkbox('checkbox') !!}
                    </div>
                </div>
            </div>

            <!-- Text Area -->
            <div class="form-group">
                {!! Form::label('textarea', 'Textarea', ['class' => 'col-lg-2 control-label']) !!}
                <div class="col-lg-10">
                    {!! Form::textarea('textarea', $value = null, ['class' => 'form-control', 'rows' => 3]) !!}
                    <span class="help-block">A longer block of help text that breaks onto a new line and may extend beyond one line.</span>
                </div>
            </div>

            <!-- Radio Buttons -->
            <div class="form-group">
                {!! Form::label('radios', 'Radios', ['class' => 'col-lg-2 control-label']) !!}
                <div class="col-lg-10">
                    <div class="radio">
                        {!! Form::label('radio1', 'This is option 1.') !!}
                        {!! Form::radio('radio', 'option1', true, ['id' => 'radio1']) !!}

                    </div>
                    <div class="radio">
                        {!! Form::label('radio2', 'This is option 2.') !!}
                        {!! Form::radio('radio', 'option2', false, ['id' => 'radio2']) !!}
                    </div>
                </div>
            </div>

            <!-- Select With One Default -->
            <div class="form-group">
                {!! Form::label('select', 'Select w/Default', ['class' => 'col-lg-2 control-label'] )  !!}
                <div class="col-lg-10">
                    {!!  Form::select('select', ['S' => 'Small', 'L' => 'Large', 'XL' => 'Extra Large', '2XL' => '2X Large'],  'S', ['class' => 'form-control' ]) !!}
                </div>
            </div>

            <script type="text/javascript">
                $(document).ready(function() {
                    $('.js-example-basic-multiple').select2();
                });
            </script>
            <div class="form-group">
                <label for="multipleselect[]" class="col-lg-2 control-label">Multi Select</label>
                <div class="col-lg-10">
                    <select class="js-example-basic-multiple form-control" multiple="multiple" name="state" id="state">
                        <option value="AL">Alabama</option>
                        <option value="rewa">asdfa vsf</option>
                        <option value="oasdfb">paois asd fasd</option>
                        <option value="asdf">sdfva paosidjf poasjdf</option>
                        <option value="afs">fasd aposidjf paoidsjf</option>
                        <option value="asd">obafasdflo</option>
                        <option value="as">sdfas</option>
                        <option value="WY">Wyoming</option>
                    </select>
                </div>
            </div>


            <!-- Submit Button -->
            <div class="form-group">
                <div class="col-lg-10 col-lg-offset-2">
                    {!! Form::submit('Submit', ['class' => 'btn btn-lg btn-info pull-right'] ) !!}
                </div>
            </div>

        </fieldset>

        {!! Form::close()  !!}

    </div>


@stop