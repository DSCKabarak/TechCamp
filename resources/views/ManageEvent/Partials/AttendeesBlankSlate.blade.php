@extends('Shared.Layouts.BlankSlate')


@section('blankslate-icon-class')
    ico-users
@stop

@section('blankslate-title')
    @lang("ManageEvent.no_attendees_yet")
@stop

@section('blankslate-text')
    @lang("ManageEvent.no_attendees_yet_text")
@stop

@section('blankslate-body')
<button data-invoke="modal" data-modal-id='InviteAttendee' data-href="{{route('showInviteAttendee', array('event_id'=>$event->id))}}" href='javascript:void(0);'  class=' btn btn-success mt5 btn-lg' type="button" >
    <i class="ico-user-plus"></i>
    @lang("ManageEvent.invite_attendee")
</button>
@stop


