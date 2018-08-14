@extends('product.layouts.master')

@section('content')

    <link rel="stylesheet" type="text/css" href="./assets/css/bootstrap.css?v=v1.113.22"/>
    <link rel="stylesheet" type="text/css" href="./assets/css/font-awesome.css?v=v1.113.22"/>
    <link rel="stylesheet" type="text/css" href="./assets/css/bootstrap-theme.css?v=v1.113.22"/>
    <script type="text/javascript" src="./assets/js/jquery-1.11.3.js?v=v1.113.22"></script>
    <script type="text/javascript" src="./assets/js/bootstrap.js?v=v1.113.22"></script>
    <script type="text/javascript" src="./assets/at/dist/js/jquery.caret.js?v=v1.113.22"></script>
    <script type="text/javascript" src="./assets/at/dist/js/jquery.atwho.js?v=v1.113.22"></script>
    <script type="text/javascript" src="./assets/js/script.js?v=v1.113.22"></script>
    <link rel="stylesheet" type="text/css" href="./assets/chosen/chosen.css?v=v1.113.22"/>
    <link rel="stylesheet" type="text/css" href="./assets/emoji/css/jquery.emoji.css?v=v1.113.22"/>
    <link rel="stylesheet" type="text/css" href="./assets/css/userinfo.css?v=v1.113.22"/>
    <link rel="stylesheet" type="text/css" href="./assets/dataTables/extensions/Responsive/css/responsive.bootstrap.min.css?v=v1.113.22"/>
    <link rel="stylesheet" type="text/css" href="./assets/dataTables/media/css/dataTables.bootstrap.css?v=v1.113.22"/>
    <link rel="stylesheet" type="text/css" href="./assets/dataTables/media/css/jquery.dataTables.css?v=v1.113.22"/>
    <link rel="stylesheet" type="text/css" href="./assets/css/dataTables.css?v=v1.113.22"/>
    <link rel="stylesheet" type="text/css" href="./assets/croppie/croppie.min.css?v=v1.113.22"/>
    <link rel="stylesheet" type="text/css" href="./assets/css/main.css?v=v1.113.22"/>
    <link rel="stylesheet" type="text/css" href="./assets/css/media.css?v=v1.113.22"/>    
    <link rel="stylesheet" type="text/css" href="./assets/css/admin.css?v=v1.113.22"/>
    <link rel="stylesheet" type="text/css" href="./assets/css/superfilter.css?v=v1.113.22"/>
    <link rel="stylesheet" type="text/css" href="./assets/datetimepicker/css/bootstrap-datetimepicker.css?v=v1.113.22"/>
    <link rel="stylesheet" type="text/css" href="./assets/dataTables/extensions/ColReorder/css/colReorder.dataTables.css?v=v1.113.22"/>
    <link rel="stylesheet" type="text/css" href="./assets/dataTables/extensions/Colvis/css/dataTables.Colvis.css?v=v1.113.22"/>
    <link rel="stylesheet" type="text/css" href="./assets/dataTables/extensions/ColResize/css/dataTables.colResize.css?v=v1.113.22"/>
    <link rel="stylesheet" type="text/css" href="./assets/adm/css/quizplus_form.css?v=v1.113.22"/>    <script>



    <script type="text/javascript" src="./assets/emoji/js/jquery.emoji.js?v=v1.113.22"></script>
    <script type="text/javascript" src="./assets/js/userinfo.js?v=v1.113.22"></script>
    <script type="text/javascript" src="./assets/chosen/chosen.jquery.js?v=v1.113.22"></script>
    <script type="text/javascript" src="./assets/js/superfilter.js?v=v1.113.22"></script>
    <script type="text/javascript" src="./assets/js/group_superfilter.js?v=v1.113.22"></script>
    <script type="text/javascript" src="./assets/adm/js/quizplus_form.js?v=v1.113.22"></script>
    <script type="text/javascript" src="./assets/datetimepicker/js/moment-with-locales.min.js?v=v1.113.22"></script>
    <script type="text/javascript" src="./assets/datetimepicker/js/bootstrap-datetimepicker.min.js?v=v1.113.22"></script>
    <script type="text/javascript" src="./assets/dataTables/media/js/jquery.dataTables.js?v=v1.113.22"></script>
    <script type="text/javascript" src="./assets/dataTables/media/js/dataTables.bootstrap.js?v=v1.113.22"></script>
    <script type="text/javascript" src="./assets/dataTables/extensions/Responsive/js/dataTables.responsive.min.js?v=v1.113.22"></script>
    <script type="text/javascript" src="./assets/dataTables/extensions/ColReorder/js/dataTables.colReorder.js?v=v1.113.22"></script>
    <script type="text/javascript" src="./assets/dataTables/extensions/Colvis/js/dataTables.Colvis.js?v=v1.113.22"></script>
    <script type="text/javascript" src="./assets/dataTables/extensions/ColResize/js/dataTables.colResize-modificado.js?v=v1.113.22"></script>
    <script type="text/javascript" src="./assets/js/check_files.js?v=v1.113.22"></script>
    <script type="text/javascript" src="./assets/js/privacy_view.js?v=v1.113.22"></script>
    <script type="text/javascript" src="./assets/croppie/croppie.min.js?v=v1.113.22"></script></body>





    <div class="well">

        {!! Form::open(['url' => '/tester/salvar/', 'class' => 'form-horizontal']) !!}

        <fieldset>

            <legend>Legend</legend>
            <!-- Email -->
            <div class="form-group">
                {!! Form::label('name', 'Email:', ['class' => 'col-lg-2 control-label']) !!}
                <div class="col-lg-10">
                    {!! Form::email('name', $value = null, ['class' => 'form-control', 'placeholder' => 'email']) !!}
                </div>
            </div>

            <!-- Password -->
            {{--<div class="form-group">--}}
                {{--{!! Form::label('password', 'Password:', ['class' => 'col-lg-2 control-label']) !!}--}}
                {{--<div class="col-lg-10">--}}
                    {{--{!! Form::password('password',['class' => 'form-control', 'placeholder' => 'Password', 'type' => 'password']) !!}--}}
                    {{--<div class="checkbox">--}}
                        {{--{!! Form::label('checkbox', 'Checkbox') !!}--}}
                        {{--{!! Form::checkbox('checkbox') !!}--}}
                    {{--</div>--}}
                {{--</div>--}}
            {{--</div>--}}

            {{--<!-- Text Area -->--}}
            {{--<div class="form-group">--}}
                {{--{!! Form::label('textarea', 'Textarea', ['class' => 'col-lg-2 control-label']) !!}--}}
                {{--<div class="col-lg-10">--}}
                    {{--{!! Form::textarea('textarea', $value = null, ['class' => 'form-control', 'rows' => 3]) !!}--}}
                    {{--<span class="help-block">A longer block of help text that breaks onto a new line and may extend beyond one line.</span>--}}
                {{--</div>--}}
            {{--</div>--}}

            {{--<!-- Radio Buttons -->--}}
            {{--<div class="form-group">--}}
                {{--{!! Form::label('radios', 'Radios', ['class' => 'col-lg-2 control-label']) !!}--}}
                {{--<div class="col-lg-10">--}}
                    {{--<div class="radio">--}}
                        {{--{!! Form::label('radio1', 'This is option 1.') !!}--}}
                        {{--{!! Form::radio('radio', 'option1', true, ['id' => 'radio1']) !!}--}}

                    {{--</div>--}}
                    {{--<div class="radio">--}}
                        {{--{!! Form::label('radio2', 'This is option 2.') !!}--}}
                        {{--{!! Form::radio('radio', 'option2', false, ['id' => 'radio2']) !!}--}}
                    {{--</div>--}}
                {{--</div>--}}
            {{--</div>--}}

            {{--<!-- Select With One Default -->--}}
            {{--<div class="form-group">--}}
                {{--{!! Form::label('select', 'Select w/Default', ['class' => 'col-lg-2 control-label'] )  !!}--}}
                {{--<div class="col-lg-10">--}}
                    {{--{!!  Form::select('select', ['S' => 'Small', 'L' => 'Large', 'XL' => 'Extra Large', '2XL' => '2X Large'],  'S', ['class' => 'form-control' ]) !!}--}}
                {{--</div>--}}
            {{--</div>--}}

            {{--<script type="text/javascript">--}}
                {{--$(document).ready(function() {--}}
                    {{--$('.js-example-basic-multiple').select2();--}}
                {{--});--}}
            {{--</script>--}}
            {{--<div class="form-group">--}}
                {{--<label for="multipleselect[]" class="col-lg-2 control-label">Multi Select</label>--}}
                {{--<div class="col-lg-10">--}}
                    {{--<select class="js-example-basic-multiple form-control" multiple="multiple" name="state" id="state">--}}
                        {{--<option value="AL">Alabama</option>--}}
                        {{--<option value="rewa">asdfa vsf</option>--}}
                        {{--<option value="oasdfb">paois asd fasd</option>--}}
                        {{--<option value="asdf">sdfva paosidjf poasjdf</option>--}}
                        {{--<option value="afs">fasd aposidjf paoidsjf</option>--}}
                        {{--<option value="asd">obafasdflo</option>--}}
                        {{--<option value="as">sdfas</option>--}}
                        {{--<option value="WY">Wyoming</option>--}}
                    {{--</select>--}}
                {{--</div>--}}
            {{--</div>--}}


            <!-- Submit Button -->
            <div class="form-group">
                <div class="col-lg-10 col-lg-offset-2">
                    {!! Form::submit('Submit', ['class' => 'btn btn-lg btn-info pull-right'] ) !!}
                </div>
            </div>



        </fieldset>

        {!! Form::close()  !!}

    </div>

    <div class="form-group">
        <div class="col-lg-10">
            @if ($errors->any())
                <ul class="alert alert-danger">
                    @foreach($errors->all() as $error)
                        <li>{{ @$error }}</li>
                    @endforeach
                </ul>
            @endif
        </div>
    </div>

@stop