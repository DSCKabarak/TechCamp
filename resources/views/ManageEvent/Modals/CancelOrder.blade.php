<div role="dialog" class="modal fade " style="display: none;">
    {!!
        Form::open([
            'url' => route('postCancelOrder', ['order_id' => $order->id]),
            'class' => 'closeModalAfter ajax',
        ])
    !!}
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header text-center">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h3 class="modal-title">
                    <i class="ico-cart2"></i>
                    {{ @trans('ManageEvent.cancel_order_:ref', ['ref' => $order->order_reference]) }}</h3>
            </div>
            <div class="modal-body">
                @if($attendees->count())
                    @if ($order->is_payment_received)
                    <div class="alert alert-warning">
                        @lang("ManageEvent.cancelling_order_will_refund_attendees", ['type' => 'order'])
                    </div>
                    @endif
                    <div class="form-errors hidden"></div>
                    <div class="help-block">
                        @lang("ManageEvent.select_attendee_to_cancel")
                    </div>
                    <div class="well bgcolor-white" style="padding:0;">
                        <div class="table-responsive">
                            <table class="table table-hover ">
                                <tbody>
                                <tr>
                                    <td style="width: 20px;">
                                        <div class="checkbox">
                                            <label>
                                                {!! Form::checkbox('all_attendees', 'on', false, ['class' => 'check-all',
                                                'data-toggle-class'=>'attendee-check']) !!}
                                                <script>
                                                    $(function () {
                                                        $('.check-all').on('click', function () {
                                                            $('.attendee-check').prop('checked', this.checked);
                                                        });
                                                    });
                                                </script>
                                            </label>
                                        </div>
                                    </td>
                                    <td colspan="3">@lang("ManageEvent.select_all")</td>
                                </tr>
                                @foreach($attendees as $attendee)
                                    <tr class="{{ $attendee->is_cancelled ? 'danger' : '' }}">
                                        <td>
                                            @if (!$attendee->is_cancelled)
                                                {!! Form::checkbox('attendees[]', $attendee->id, false, ['class' => 'attendee-check']) !!}
                                            @endif
                                        </td>
                                        <td>
                                            {{$attendee->first_name}}
                                            {{$attendee->last_name}}
                                        </td>
                                        <td>{{$attendee->email}}</td>
                                        <td>
                                            {{{$attendee->ticket->title}}}
                                            {{{$order->order_reference}}}-{{{$attendee->reference_index}}}
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                @else
                    <div class="alert alert-info cancelOrderOption">
                        @lang("ManageEvent.all_attendees_cancelled")
                    </div>
                @endif
            </div>
            @if($attendees->count() || !$order->is_refunded)
                <div class="modal-footer">
                    {!!
                        Form::button(trans('basic.back_to_orders'), [
                            'class' => 'btn modal-close btn-danger',
                            'data-dismiss' => 'modal',
                        ])
                    !!}
                    {!! Form::submit(trans('ManageEvent.confirm_order_cancel'), ['class' => 'btn btn-primary']) !!}
                </div>
            @endif
        </div>
        {!! Form::close() !!}
    </div>
</div>
