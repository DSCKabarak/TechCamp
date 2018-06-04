@extends('Shared.Layouts.MasterWithoutMenus')

@section('title')
    @lang("Organiser.create_organiser")
@stop

@section('head')
    <style>
        .modal-header {
            background-color: transparent !important;
            color: #666 !important;
            text-shadow: none !important;;
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
                    <h2>@lang("Organiser.create_organiser")</h2>

                    {!! Form::open(array('url' => route('postCreateOrganiser'), 'class' => 'ajax')) !!}
                    @if(@$_GET['first_run'] == '1')
                        <div class="alert alert-info">
                            @lang("Organiser.create_organiser_text")
                        </div>
                    @endif

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                {!! Form::label('name', trans("Organiser.organiser_name"), array('class'=>'required control-label ')) !!}
                                {!!  Form::text('name', Input::old('name'),
                                            array(
                                            'class'=>'form-control'
                                            ))  !!}
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                {!! Form::label('email', trans("Organiser.organiser_email"), array('class'=>'control-label required')) !!}
                                {!!  Form::text('email', Input::old('email'),
                                            array(
                                            'class'=>'form-control ',
                                            'placeholder'=>trans("Organiser.organiser_email_placeholder")
                                            ))  !!}
                            </div>
                        </div>
                    </div>




                    <div class="form-group">
                        {!! Form::label('about', trans("Organiser.organiser_description"), array('class'=>'control-label ')) !!}
                        {!!  Form::textarea('about', Input::old('about'),
                                    array(
                                    'class'=>'form-control ',
                                    'placeholder'=>trans("Organiser.organiser_description_placeholder"),
                                    'rows' => 4
                                    ))  !!}
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                {!! Form::label('taxid', 'Tax ID', array('class'=>'control-label required')) !!}
                                {!! Form::text('taxid', Input::old('taxid'), array('class'=>'form-control', 'placeholder'=>'Tax ID'))  !!}
                            </div>
                        </div>
                        
                        <div class="col-md-3">
                            <div class="form-group">
                                {!! Form::label('taxname', 'Tax name', array('class'=>'control-label required')) !!}
                                {!! Form::text('taxname', Input::old('taxname'), array('class'=>'form-control', 'placeholder'=>'Tax name'))  !!}
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="form-group">
                                {!! Form::label('taxvalue', 'Tax value', array('class'=>'control-label required')) !!}
                                {!! Form::text('taxvalue', Input::old('taxvalue'), array('class'=>'form-control', 'placeholder'=>'Tax Value'))  !!}
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                {!! Form::label('facebook', trans("Organiser.organiser_facebook"), array('class'=>'control-label ')) !!}

                                <div class="input-group">
                                    <span style="background-color: #eee;" class="input-group-addon">facebook.com/</span>
                                    {!!  Form::text('facebook', Input::old('facebook'),
                                                    array(
                                                    'class'=>'form-control ',
                                                    'placeholder'=>trans("Organiser.organiser_username_facebook_placeholder")
                                                    ))  !!}
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                {!! Form::label('twitter', trans("Organiser.organiser_twitter"), array('class'=>'control-label ')) !!}

                                <div class="input-group">
                                    <span style="background-color: #eee;" class="input-group-addon">twitter.com/</span>
                                    {!!  Form::text('twitter', Input::old('twitter'),
                                             array(
                                             'class'=>'form-control ',
                                                    'placeholder'=>trans("Organiser.organiser_username_twitter_placeholder")
                                             ))  !!}
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        {!! Form::label('organiser_logo', trans("Organiser.organiser_logo"), array('class'=>'control-label ')) !!}
                        {!! Form::styledFile('organiser_logo') !!}
                    </div>

                    {!! Form::submit(trans("Organiser.create_organiser"), ['class'=>" btn-block btn btn-success"]) !!}
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
@stop
