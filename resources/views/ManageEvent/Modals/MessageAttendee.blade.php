<div role="dialog" class="modal fade" style="display: none;">
    {!! Form::open(array('url' => route('postMessageAttendee', array('attendee_id' => $attendee->id)), 'class' => 'ajax
    reset closeModalAfter')) !!}
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header text-center">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h3 class="modal-title">
                    <i class="ico-envelope"></i>
                    @lang("ManageEvent.message_attendee_title", ["attendee"=>$attendee->full_name])
                </h3>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            {!! Form::label('subject', trans("Message.subject"), array('class'=>'control-label
                            required')) !!}
                            {!! Form::text('subject', old('subject'),
                            array(
                            'class'=>'form-control'
                            )) !!}
                        </div>

                        <div class="form-group">
                            {!! Form::label('message', trans("Message.content"), array('class'=>'control-label
                            required')) !!}

                            {!! Form::textarea('message', old('message'),
                            array(
                            'class'=>'form-control',
                            'rows' => '5'
                            )) !!}
                        </div>

                        <div class="form-group">
                            <div class="custom-checkbox">
                                <input type="checkbox" name="send_copy" id="send_copy" value="1">
                                <label for="send_copy">&nbsp;&nbsp;{{ @trans("Message.send_a_copy_to",
                                    ["organiser"=>$attendee->event->organiser->email]) }}</label>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="help-block">
                    {{ @trans("Message.before_send_message", ["organiser"=>$attendee->event->organiser->email]) }}
                </div>
            </div> <!-- /end modal body-->
            <div class="modal-footer">
                {!! Form::button(trans("basic.cancel"), ['class'=>"btn modal-close btn-danger",'data-dismiss'=>'modal'])
                !!}
                {!! Form::submit(trans("Message.send_message"), ['class'=>"btn btn-success"]) !!}
            </div>
        </div><!-- /end modal content-->
        {!! Form::close() !!}
    </div>
</div>
