@extends('Shared.Layouts.Master')

@section('title')
    @parent
    @lang('AccessCodes.title')
@stop

@section('top_nav')
    @include('ManageEvent.Partials.TopNav')
@stop

@section('menu')
    @include('ManageEvent.Partials.Sidebar')
@stop

@section('page_title')
    <i class='ico-money mr5'></i>
    @lang('AccessCodes.title')
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
                                            class='loadModal btn btn-success' type="button">
                                        <i class="ico-ticket"></i> @lang("AccessCodes.create_access_code")
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
                                            <th width="60%">@lang("AccessCodes.access_codes_code")</th>
                                            <th width="10%" class="has-text-center">@lang("AccessCodes.access_codes_usage_count")</th>
                                            <th width="20%" class="has-text-center">@lang("AccessCodes.access_codes_created_at")</th>
                                            <th width="10%"></th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($event->access_codes as $accessCode)
                                            <tr>
                                                <td><strong>{{ $accessCode->code }}</strong></td>
                                                <td class="has-text-center"><strong>{{ $accessCode->usage_count }}</strong></td>
                                                <td class="has-text-center">{{ $accessCode->created_at }}</td>
                                                {{-- Can only remove if haven't been used before--}}
                                                @if ($accessCode->usage_count === 0)
                                                <td class="has-text-right">
                                                    <a class="deleteThis"
                                                       style="cursor:pointer"
                                                        data-route={{ route('postDeleteEventAccessCode', [
                                                            'event_id' => $accessCode->event_id,
                                                            'access_code_id' => $accessCode->id,
                                                        ]) }}>
                                                        Remove
                                                    </a>
                                                </td>
                                                @else
                                                    <td></td>
                                                @endif
                                            </tr>
                                        @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            @else
                                <div class="alert alert-info">
                                    @lang("AccessCodes.no_access_codes_yet")
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
