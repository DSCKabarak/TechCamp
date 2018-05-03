<div role="dialog"  class="modal fade" style="display: none;">
   {!! Form::open(array('url' => route('postResendTicketToAttendee', array('attendee_id' => $attendee->id)), 'class' => 'ajax reset closeModalAfter')) !!}
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header text-center">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h3 class="modal-title">
                    <i class="ico-envelope"></i>
                    @lang("ManageEvent.resend_ticket_to_attendee", ["attendee"=>$attendee->full_name])
                </h3>
            </div>
            <div class="modal-body">
                <div class="help-block">
                    @lang("ManageEvent.resend_ticket_help", ["email"=>$attendee->email])
                </div>
            </div> <!-- /end modal body-->
            <div class="modal-footer">
               {!! Form::button(trans("basic.cancel"), ['class'=>"btn modal-close btn-danger",'data-dismiss'=>'modal']) !!}
               {!! Form::submit(trans("ManageEvent.send_ticket"), ['class'=>"btn btn-success"]) !!}
            </div>
        </div><!-- /end modal content-->
        {!! Form::close() !!}
    </div>
</div>