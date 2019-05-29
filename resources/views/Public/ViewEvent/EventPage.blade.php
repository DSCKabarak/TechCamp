@extends('Public.ViewEvent.Layouts.EventPage')

@section('head')
    @include('Public.ViewEvent.Partials.GoogleTagManager')
@endsection

@section('content')
    @include('Public.ViewEvent.Partials.EventHeaderSection')
    @include('Public.ViewEvent.Partials.EventTicketsSection')
    @include('Public.ViewEvent.Partials.EventDescriptionSection')
    @include('Public.ViewEvent.Partials.EventShareSection')
    @include('Public.ViewEvent.Partials.EventMapSection')
    @include('Public.ViewEvent.Partials.EventOrganiserSection')
    @include('Public.ViewEvent.Partials.EventFooterSection')
@stop

