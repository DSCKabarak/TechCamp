@extends('Shared.Layouts.BlankSlate')

@section('blankslate-icon-class')
    ico-question2
@stop

@section('blankslate-title')
    @lang("Question.no_questions_yet")
@stop

@section('blankslate-text')
    @lang("Question.no_questions_yet_text")
@stop

@section('blankslate-body')
    <button data-invoke="modal" data-modal-id='CreateQuestion' data-href="{{route('showCreateEventQuestion', array('event_id'=>$event->id))}}" href='javascript:void(0);'  class=' btn btn-success mt5 btn-lg' type="button" >
        <i class="ico-question"></i>
        @lang("Question.create_question")
    </button>
@stop


