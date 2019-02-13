@extends('Shared.Layouts.Master')

@section('title')
    @parent

    @lang("Widgets.event_widgets")
@stop

@section('top_nav')
    @include('ManageEvent.Partials.TopNav')
@stop

@section('menu')
    @include('ManageEvent.Partials.Sidebar')
@stop

@section('page_title')
    <i class='ico-money mr5'></i>
    @lang("DiscountCodes.title")
@stop

@section('head')

@stop

@section('page_header')
    <style>
        .page-header {display: none;}
    </style>
@stop


@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="panel">
                <div class="panel-body">
                    <div class="row">
                        <div class="col-md-9">
                            <div class="btn-toolbar" role="toolbar">
                                <div class="btn-group btn-group-responsive">
                                    <button data-modal-id='CreateAccessCode'
                                            data-href="{{route('showCreateEventAccessCode', [ 'event_id' => $event->id ])}}"
                                            class='loadModal btn btn-success' type="button"><i class="ico-ticket"></i> @lang("DiscountCodes.create_discount_code")
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row"><div class="col-md-12">&nbsp;</div></div>
                    <div class="row">
                        <div class="col-md-12">
                            @if($event->access_codes->count())
                                <div class="table-responsive">
                                    <table class="table">
                                        <thead>
                                        <tr>
                                            <th>@lang("DiscountCodes.discount_codes_code")</th>
                                            <th class="has-text-right">@lang("DiscountCodes.discount_codes_created_at")</th>
                                        </tr>
                                        </thead>

                                        <tbody>
                                        @foreach($event->access_codes as $access_code)
                                            <tr>
                                                <td><strong>{{ $access_code->code }}</strong></td>
                                                <td class="has-text-right">{{ $access_code->created_at }}</td>
                                            </tr>
                                        @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            @else
                                <div class="alert alert-info">
                                    @lang("DiscountCodes.no_discount_codes_yet")
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
