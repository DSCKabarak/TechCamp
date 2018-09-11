<div role="dialog"  class="modal fade" style="display: none;">
   {!! Form::open(array('url' => route('postMessageOrder', array('attendee_id' => $order->id)), 'class' => 'ajax reset closeModalAfter')) !!}
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header text-center">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h3 class="modal-title">
                    <i class="ico-envelope"></i>
                    @lang("ManageEvent.message_order", ["order"=>$order->full_name])
                    <br>
                    <span style="font-size: 17px;">
                        @lang("ManageEvent.order_ref", ["order_ref"=>$order->reference])
                    </span>
                </h3>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            {!! Form::label('subject',  trans("Message.subject"), array('class'=>'control-label required')) !!}
                            {!!  Form::text('subject', Input::old('subject'),
                                        array(
                                        'class'=>'form-control'
                                        ))  !!}
                        </div>

                        <div class="form-group">
                            {!! Form::label('message', trans("Message.content"), array('class'=>'control-label required')) !!}
                            {!!  Form::textarea('message', Input::old('message'),
                                        array(
                                        'class'=>'form-control',
                                        'rows' => '5'
                                        ))  !!}
                        </div>

                        <div class="form-group">
                            <div class="checkbox custom-checkbox">
                                <input type="checkbox" name="send_copy" id="send_copy" value="1">
                                <label for="send_copy">&nbsp;&nbsp;@lang("Message.send_a_copy_to", ["organiser"=>$order->event->organiser->email])</label>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="help-block">
                    {!! @trans("ManageEvent.order_contact_will_receive_instructions", ["email"=>$order->event->organiser->email]) !!}
                </div>

            </div> <!-- /end modal body-->
            <div class="modal-footer">
               {!! Form::button(trans("basic.cancel"), ['class'=>"btn modal-close btn-danger",'data-dismiss'=>'modal']) !!}
               {!! Form::submit(trans("ManageEvent.send_message"), ['class'=>"btn btn-success"]) !!}
            </div>
        </div><!-- /end modal content-->
       {!! Form::close() !!}
    </div>
</div>

