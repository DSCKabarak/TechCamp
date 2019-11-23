<div role="dialog"  class="modal fade" style="display: none;">
    {!! Form::model($user, array('url' => route('postEditUser'), 'class' => 'ajax closeModalAfter')) !!}
        <div class="modal-dialog account_settings">
            <div class="modal-content">
                <div class="modal-header text-center">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h3 class="modal-title">
                        <i class="ico-user"></i>
                        @lang("User.my_profile")</h3>
                </div>
                <div class="modal-body">
                    @if(!Auth::user()->first_name)
                        <div class="alert alert-info">
                            <b>
                                @lang("User.welcome_to_app", ["app"=>config('attendize.app_name')])
                            </b><br>
                            @lang("User.after_welcome")
                        </div>
                    @endif
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                {!! Form::label('first_name', trans("User.first_name"), array('class'=>'control-label required')) !!}
                                {!!  Form::text('first_name', old('first_name'),
                                            array(
                                            'class'=>'form-control'
                                            ))  !!}
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                {!! Form::label('last_name', trans("User.last_name"), array('class'=>'control-label required')) !!}
                                {!!  Form::text('last_name', old('last_name'),
                                            array(
                                            'class'=>'form-control'
                                            ))  !!}
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                {!! Form::label('email', trans("User.email"), array('class'=>'control-label required')) !!}
                                {!!  Form::text('email', old('email'),
                                            array(
                                            'class'=>'form-control '
                                            ))  !!}
                            </div>
                        </div>
                    </div>

                    <div class="row more-options">
                        <div class="col-md-12">

                            <div class="form-group">
                                {!! Form::label('password', trans("User.old_password"), array('class'=>'control-label')) !!}
                                {!!  Form::password('password',
                                            array(
                                            'class'=>'form-control'
                                            ))  !!}
                            </div>
                            <div class="form-group">
                                {!! Form::label('new_password', trans("User.new_password"), array('class'=>'control-label')) !!}
                                {!!  Form::password('new_password',
                                            array(
                                            'class'=>'form-control'
                                            ))  !!}
                            </div>
                            <div class="form-group">
                                {!! Form::label('new_password_confirmation', trans("User.confirm_new_password"), array('class'=>'control-label')) !!}
                                {!!  Form::password('new_password_confirmation',
                                            array(
                                            'class'=>'form-control'
                                            ))  !!}
                            </div>
                        </div>
                    </div>
                    <a data-show-less-text='@lang("User.hide_change_password")' href="javascript:void(0);" class="in-form-link show-more-options">
                        @lang("User.change_password")
                    </a>
                </div>
                <div class="modal-footer">
                   {!! Form::button(trans("basic.cancel"), ['class'=>"btn modal-close btn-danger",'data-dismiss'=>'modal']) !!}
                   {!! Form::submit(trans("basic.save_details"), ['class' => 'btn btn-success pull-right']) !!}
                </div>
            </div>
        </div>
    {!! Form::close() !!}
</div>
