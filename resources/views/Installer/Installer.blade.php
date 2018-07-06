@extends('Shared.Layouts.MasterWithoutMenus')

@section('title')
    @lang("Installer.title")
@stop

@section('head')
    <style>
        .modal-header {
            background-color: transparent !important;
            color: #666 !important;
            text-shadow: none !important;;
        }
        .alert-success {
            background-color: #dff0d8 !important;
            border-color: #d6e9c6  !important;
            color: #3c763d  !important;
        }
    </style>
@stop

@section('content')
    <div class="row">
        <div class="col-md-7 col-md-offset-2">
            <div class="panel">
                <div class="panel-body">
                    <div class="logo">
                        {!!HTML::image('assets/images/logo-dark.png')!!}
                    </div>

                    <h1>@lang("Installer.setup")</h1>
                    @if (count($errors) > 0)
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                    @endif

                    <h3>@lang("Installer.php_version_check")</h3>
                    @if (version_compare(phpversion(), '5.5.9', '<'))
                        <div class="alert alert-warning">
                            @lang("Installer.php_too_low", ["requires"=>"5.5.9", "has"=>phpversion()])
                        </div>
                    @else
                        <div class="alert alert-success">
                            @lang("Installer.php_enough", ["requires"=>"5.5.9", "has"=>phpversion()])
                        </div>
                    @endif

                    <h3>@lang("Installer.files_n_folders_check")</h3>
                    @foreach($paths as $path)

                        @if(!File::isWritable($path))
                            <div class="alert alert-danger">
                                @lang("Installer.path_not_writable", ["path"=>$path])
                            </div>
                        @else
                            <div class="alert alert-success">
                                @lang("Installer.path_writable", ["path"=>$path])
                            </div>
                        @endif

                    @endforeach

                    <h3>@lang("Installer.php_requirements_check")</h3>
                    @foreach($requirements as $requirement)

                        @if(!extension_loaded($requirement))
                            <div class="alert alert-danger">
                                @lang("Installer.requirement_not_met", ["requirement"=>$requirement])
                            </div>
                        @else
                            <div class="alert alert-success">
                                @lang("Installer.requirement_met", ["requirement"=>$requirement])
                            </div>
                        @endif

                    @endforeach

                    <h3>@lang("Installer.php_optional_requirements_check")</h3>

                    @foreach($optional_requirements as $optional_requirement)

                        @if(!extension_loaded($optional_requirement))
                            <div class="alert alert-warning">
                                @lang("Installer.optional_requirement_not_met", ["requirement"=>$optional_requirement])
                            </div>
                        @else
                            <div class="alert alert-success">
                                @lang("Installer.requirement_met", ["requirement"=>$optional_requirement])
                            </div>
                        @endif

                    @endforeach

                    {!! Form::open(array('url' => route('postInstaller'), 'class' => 'installer_form')) !!}

                    <h3>@lang("Installer.app_settings")</h3>

                    <div class="form-group">
                        {!! Form::label('app_url', trans("Installer.application_url"), array('class'=>'required control-label ')) !!}
                        {!!  Form::text('app_url', Input::old('app_url'),
                                    array(
                                    'class'=>'form-control',
                                    'placeholder' => 'http://www.myticketsite.com'
                                    ))  !!}
                    </div>

                    <h3>@lang("Installer.database_settings")</h3>
                    <p>@lang("Installer.database_message")</p>

                    <div class="form-group">
                        {!! Form::label('database_type', trans("Installer.database_type"), array('class'=>'required control-label ')) !!}
                        {!!  Form::select('database_type', array(
                                  'mysql' => "MySQL",
                                  'pgsql' => "Postgres",
                                    ), Input::old('database_type'),
                                    array(
                                    'class'=>'form-control'
                                    ))  !!}
                    </div>

                    <div class="form-group">
                        {!! Form::label('database_host', trans("Installer.database_host"), array('class'=>'control-label required')) !!}
                        {!!  Form::text('database_host', $value = env("DB_HOST") ,
                                    array(
                                    'class'=>'form-control ',
                                    'placeholder'=>''
                                    ))  !!}


                    </div>
                    <div class="form-group">
                        {!! Form::label('database_name', trans("Installer.database_name"), array('class'=>'required control-label required')) !!}
                        {!!  Form::text('database_name', $value = env("DB_DATABASE") ,
                                    array(
                                    'class'=>'form-control'
                                    ))  !!}
                    </div>

                    <div class="form-group">
                        {!! Form::label('database_username', trans("Installer.database_username"), array('class'=>'control-label required')) !!}
                        {!!  Form::text('database_username', $value = env("DB_USERNAME"),
                                    array(
                                    'class'=>'form-control ',
                                    'placeholder'=>'',
                                    ))  !!}
                    </div>
                    <div class="form-group">
                        {!! Form::label('database_password', trans("Installer.database_password"), array('class'=>'control-label required')) !!}
                        {!!  Form::text('database_password', $value = env("DB_PASSWORD"),
                                    array(
                                    'class'=>'form-control ',
                                    'placeholder'=>'',
                                    ))  !!}
                    </div>

                    <div class="form-group">
                        <script>
                            $(function () {
                                $.ajaxSetup({
                                    headers: {
                                        'X-CSRF-Token': "{{csrf_token()}}"
                                    }
                                });

                                $('.test_db').on('click', function (e) {

                                    var url = $(this).attr('href');

                                    $.post(url, $(".installer_form").serialize(), function (data) {
                                        if (data.status === 'success') {
                                            alert('@lang("Installer.database_test_connect_success")');
                                        } else {
                                            alert('@lang("Installer.database_test_connect_failure")');
                                        }
                                    }, 'json').fail(function (data) {
                                        var returned = $.parseJSON(data.responseText);
                                        console.log(returned.error);
                                        alert('@lang("Installer.database_test_connect_failure_message")\n\n' + '@lang("Installer.database_test_connect_failure_error_type"): ' + returned.error.type + '\n' + '@lang("Installer.database_test_connect_failure_error_message"): ' + returned.error.message);
                                    });

                                    e.preventDefault();
                                });
                            });
                        </script>
                        <a href="{{route('postInstaller',['test' => 'db'])}}" class="test_db">
                            @lang("Installer.test_database_connection")
                        </a>
                    </div>

                    <h3>@lang("Installer.email_settings")</h3>

                    <div class="form-group">
                        {!! Form::label('mail_from_address', trans("Installer.mail_from_address"), array('class'=>' control-label required')) !!}
                        {!!  Form::text('mail_from_address', $value = env("MAIL_FROM_ADDRESS") ,
                                    array(
                                    'class'=>'form-control'
                                    ))  !!}
                    </div>
                    <div class="form-group">
                        {!! Form::label('mail_from_name', trans("Installer.mail_from_name"), array('class'=>' control-label required')) !!}
                        {!!  Form::text('mail_from_name', $value = env("MAIL_FROM_NAME") ,
                                    array(
                                    'class'=>'form-control'
                                    ))  !!}
                    </div>
                    <div class="form-group">
                        {!! Form::label('mail_driver', trans("Installer.mail_from_address"), array('class'=>' control-label required')) !!}
                        {!!  Form::text('mail_driver', $value = env("MAIL_DRIVER"),
                                    array(
                                    'class'=>'form-control ',
                                    'placeholder' => 'mail'
                                    ))  !!}
                        <div class="help-block">
                            @lang("Installer.mail_from_help")
                        </div>
                    </div>

                    <div class="form-group">
                        {!! Form::label('mail_port', trans("Installer.mail_port"), array('class'=>' control-label ')) !!}
                        {!!  Form::text('mail_port', $value = env("MAIL_PORT"),
                                    array(
                                    'class'=>'form-control'
                                    ))  !!}
                    </div>
                    <div class="form-group">
                        {!! Form::label('mail_encryption', trans("Installer.mail_encryption"), array('class'=>' control-label ')) !!}
                        {!!  Form::text('mail_encryption', Input::old('mail_encryption'),
                                    array(
                                    'class'=>'form-control',
                                    'placeholder' => "tls/ssl"
                                    ))  !!}
                    </div>
                    <div class="form-group">
                        {!! Form::label('mail_host', trans("Installer.mail_host"), array('class'=>' control-label ')) !!}
                        {!!  Form::text('mail_host', $value = env("MAIL_HOST"),
                                    array(
                                    'class'=>'form-control'
                                    ))  !!}
                    </div>
                    <div class="form-group">
                        {!! Form::label('mail_username', trans("Installer.mail_username"), array('class'=>' control-label ')) !!}
                        {!!  Form::text('mail_username', Input::old('mail_username'),
                                    array(
                                    'class'=>'form-control'
                                    ))  !!}
                    </div>
                    <div class="form-group">
                        {!! Form::label('mail_password', trans("Installer.mail_password"), array('class'=>' control-label ')) !!}
                        {!!  Form::text('mail_password', Input::old('mail_password'),
                                    array(
                                    'class'=>'form-control'
                                    ))  !!}
                    </div>
                    {!! csrf_field() !!}
                    @include("Installer.Partials.Footer")

                    {!! Form::submit(trans("Installer.install"), ['class'=>" btn-block btn btn-success"]) !!}
                    {!! Form::close() !!}

                </div>
            </div>
        </div>
    </div>
@stop
