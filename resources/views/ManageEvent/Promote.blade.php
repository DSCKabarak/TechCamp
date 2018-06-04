@extends('Shared.Layouts.Master')

@section('title')
@parent <?php /*Seems like unfinished page, but only 2 variables, so translating*/ ?>
@lang("Event.promote_event")
@stop

@section('top_nav')
    @include('ManageEvent.Partials.TopNav')
@stop


@section('menu')
    @include('ManageEvent.Partials.Sidebar')
@stop

@section('page_title')
<i class="ico-bullhorn mr5"></i>
@lang("Event.promote_event")
@stop


@section('content')
<div class='row'>
    <div class="col-md-12">
        <h1>
            @lang("Event.promote")
            <pre>
                [PROMOTE PAGE]
            </pre>
        </h1>
    </div>
</div>
@stop


