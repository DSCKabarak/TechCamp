<div role="dialog"  class="modal fade " style="display: none;">
    {!! Form::open(array('url' => route('postMessageAttendees', array('event_id' => $event->id)), 'class' => 'reset ajax closeModalAfter')) !!}
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header text-center">
                <button type="button" class="close" data-dismiss="modal">×</button>
                <h3 class="modal-title">
                    <i class="ico-envelope"></i>
                    @lang("ManageEvent.message_attendees_title")</h3>
            </div>
            <div class="modal-body">
                <ul class="nav nav-tabs">
                    <li class="active"><a href="#new_message" data-toggle="tab">@lang("Message.new_message")</a></li>
                    <li><a href="#sent_messages" data-toggle="tab">@lang("Message.sent_messages")</a></li>
                </ul>

                <div class="tab-content panel">
                    <div class="tab-pane active" id="new_message">
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
                                    {!! Form::label('recipients', trans("Message.send_to"), array('class'=>'control-label required')) !!}
                                    {!!  Form::select('recipients', [
                                            'all' => trans("Message.all_event_attendees")
                                        ] + [trans("Message.attendees_with_ticket_type") => $tickets] ,
                                        null, [
                                            'class'=>'form-control'
                                        ])  !!}
                                </div>

                                <div class="form-group hide">
                                    {!! Form::label('sent_time', trans("Message.schedule_send_time"), array('class'=>'control-label required')) !!}
                                    {!!  Form::text('sent_time', Input::old('sent_time'),
                                        array(
                                        'class'=>'form-control'
                                        ))  !!}
                                    <div class="help-block">
                                        @lang("Message.leave_blank_to_send_immediately")
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane" id="sent_messages">

                        @if(count($event->messages) > 0)
                            <div class="table-layout">
                                <!-- content -->
                                <div class="col-lg-12 valign-top panel panel-default">
                                    <div class="nm">
                                        <table class="table table-hover table-email">
                                            <thead>
                                            <tr>
                                                <td style="width: 100px;">
                                                    <h5>
                                                        <b>@lang("Message.date")</b>
                                                    </h5>
                                                </td>
                                                <td>
                                                    <h5>
                                                        <b>@lang("Message.message")</b>
                                                    </h5>
                                                </td>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            @foreach($event->messages as $message)
                                                <tr>
                                                    <td class="meta">
                                                        @if($message->sent_at!=null) <?php /* Can occur when there was mailing error*/ ?>
                                                            <p class="date">{{$message->sent_at->format(env("DEFAULT_DATETIME_FORMAT"))}}</p>
                                                        @else
                                                            <p class="date">@lang("Message.unsent")</p>
                                                        @endif
                                                    </td>
                                                    <td class="message">
                                                        <h5 class="sender">@lang("Message.to"): <b>{{$message->recipients_label}}</b></h5>
                                                        <h5 class="heading"><a href="javascript:void();">{{$message->subject}}</a></h5>

                                                        <p class="text">{{nl2br($message->message)}}</p>
                                                    </td>
                                                </tr>
                                            @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                    <!--/ email list -->
                                </div>
                                <!--/ content -->
                            </div>
                        @else
                            <div class="alert alert-info">
                                @lang("Message.no_messages_for_event")
                            </div>
                        @endif
                    </div>
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
