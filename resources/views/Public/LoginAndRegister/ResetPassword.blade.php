@extends('Shared.Layouts.MasterWithoutMenus')

@section('title')
Reset Password
@stop

@section('content')
    <div class="row">
        <div class="col-md-4 col-md-offset-4">

           {!! Form::open(array('url' => route('postResetPassword'), 'class' => 'panel')) !!}

            <div class="panel-body">
                <div class="logo">
                   {!!HTML::image('assets/images/logo-dark.png')!!}
                </div>
                <h2>@lang("User.reset_password")</h2>
                @if (Session::has('status'))
                <div class="alert alert-info">
                    @lang("User.reset_password_success")
                </div>
                @else

                @if (count($errors) > 0)
                <div class="alert alert-danger">
                    <strong>@lang("basic.whoops")!</strong> @lang("User.reset_input_errors")<br><br>
                    <ul>
                        @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
                @endif

                <div class="form-group">
                    {!! Form::label('email', trans("User.your_email"), ['class' => 'control-label']) !!}
                    {!! Form::text('email', null, ['class' => 'form-control', 'autofocus' => true]) !!}
                </div>
                <div class="form-group">
                    {!! Form::label('password', trans("User.new_password"), ['class' => 'control-label']) !!}
                    {!! Form::password('password',  ['class' => 'form-control']) !!}
                </div>
                <div class="form-group">
                    {!! Form::label('password_confirmation', trans("User.confirm_new_password"), ['class' => 'control-label']) !!}
                    {!! Form::password('password_confirmation',  ['class' => 'form-control']) !!}
                </div>
                {!! Form::hidden('token',  $token) !!}
                <div class="form-group nm">
                    <button type="submit" class="btn btn-block btn-success">Submit</button>
                </div>
                <div class="signup">
                  <a class="semibold" href="{{route('login')}}">
                      <i class="ico ico-arrow-left"></i> @lang("basic.back_to_login")
                  </a>
                </div>
            </div>
            {!! Form::close() !!}

            @endif
        </div>
    </div>
@stop