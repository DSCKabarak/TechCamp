@extends('Shared.Layouts.BlankSlate')

@section('blankslate-icon-class')
    ico-ticket
@stop

@section('blankslate-title')
    @lang("Ticket.no_tickets_yet")
@stop

@section('blankslate-text')
    @lang("Ticket.no_tickets_yet_text")
@stop

@section('blankslate-body')
    <button data-invoke="modal" data-modal-id='CreateTicket' data-href="{{route('showCreateTicket', array('event_id'=>$event->id))}}" href='javascript:void(0);'  class=' btn btn-success mt5 btn-lg' type="button" >
        <i class="ico-ticket"></i>
        @lang("Ticket.create_ticket")
    </button>
@stop
