<div role="dialog"  class="modal fade" style="display: none;">
    <style>
        .account_settings .modal-body {
            border: 0;
            margin-bottom: -35px;
            border: 0;
            padding: 0;
        }

        .account_settings .panel-footer {
            margin: -15px;
            margin-top: 20px;
        }

        .account_settings .panel {
            margin-bottom: 0;
            border: 0;
        }
    </style>
    <div class="modal-dialog account_settings">
        <div class="modal-content">
            <div class="modal-header text-center">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h3 class="modal-title">
                    <i class="ico-cogs"></i>
                    @lang("ManageAccount.account")</h3>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12">
                        <!-- tab -->
                        <ul class="nav nav-tabs">
                            <li class="active"><a href="#general_account" data-toggle="tab">@lang("ManageAccount.general")</a></li>
                            <li><a href="#payment_account" data-toggle="tab">@lang("ManageAccount.payment")</a></li>
                            <li><a href="#users_account" data-toggle="tab">@lang("ManageAccount.users")</a></li>
                            <li><a href="#about" data-toggle="tab">@lang("ManageAccount.about")</a></li>
                        </ul>
                        <div class="tab-content panel">
                            <div class="tab-pane active" id="general_account">
                                {!! Form::model($account, array('url' => route('postEditAccount'), 'class' => 'ajax ')) !!}
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            {!! Form::label('first_name', trans("ManageAccount.first_name"), array('class'=>'control-label required')) !!}
                                            {!!  Form::text('first_name', old('first_name'),
                                        array(
                                        'class'=>'form-control'
                                        ))  !!}
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            {!! Form::label('last_name', trans("ManageAccount.last_name"), array('class'=>'control-label required')) !!}
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
                                            {!! Form::label('email', trans("ManageAccount.email"), array('class'=>'control-label required')) !!}
                                            {!!  Form::text('email', old('email'),
                                        array(
                                        'class'=>'form-control'
                                        ))  !!}
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            {!! Form::label('timezone_id', trans("ManageAccount.timezone"), array('class'=>'control-label required')) !!}
                                            {!! Form::select('timezone_id', $timezones, $account->timezone_id, ['class' => 'form-control']) !!}
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            {!! Form::label('currency_id', trans("ManageAccount.default_currency"), array('class'=>'control-label required')) !!}
                                            {!! Form::select('currency_id', $currencies, $account->currency_id, ['class' => 'form-control']) !!}
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="panel-footer">
                                            {!! Form::submit(trans("ManageAccount.save_account_details_submit"), ['class' => 'btn btn-success pull-right']) !!}
                                        </div>
                                    </div>
                                </div>

                                {!! Form::close() !!}
                            </div>
                            <div class="tab-pane " id="payment_account">

                                @include('ManageAccount.Partials.PaymentGatewayOptions')

                            </div>
                            <div class="tab-pane" id="users_account">
                                {!! Form::open(array('url' => route('postInviteUser'), 'class' => 'ajax ')) !!}

                                <div class="table-responsive">
                                    <table class="table table-bordered">

                                        <tbody>
                                        @foreach($account->users as $user)
                                            <tr>
                                                <td>
                                                    {{$user->first_name}} {{$user->last_name}}
                                                </td>
                                                <td>
                                                    {{$user->email}}
                                                </td>
                                                <td>
                                                    {!! $user->is_parent ? '<span class="label label-info">'.trans("ManageAccount.accout_owner").'</span>' : '' !!}
                                                </td>

                                            </tr>
                                        @endforeach
                                        <tr>
                                            <td colspan="3">
                                                <div class="input-group">
                                                    {!! Form::text('email', '',  ['class' => 'form-control', 'placeholder' => trans("ManageAccount.email_address_placeholder")]) !!}
                                                    <span class="input-group-btn">
                                                          {!!Form::submit(trans("ManageAccount.add_user_submit"), ['class' => 'btn btn-primary'])!!}
                                                    </span>
                                                </div>
                                                <span class="help-block">
                                                    @lang("ManageAccount.add_user_help_block")
                                                </span>
                                            </td>

                                        </tr>

                                        </tbody>
                                    </table>
                                </div>
                                {!! Form::close() !!}
                            </div>
                            <div class="tab-pane " id="about">
                                <h4>
                                    @lang("ManageAccount.version_info")
                                </h4>
                                <p>
                                    @if(is_array($version_info) && $version_info['is_outdated'])
                                        @lang("ManageAccount.version_out_of_date", ["installed" => $version_info['installed'], "latest"=> $version_info['latest'], "url"=>"https://attendize.com/documentation.php#download"]).
                                    @elseif(is_array($version_info))
                                        @lang("ManageAccount.version_up_to_date", ["installed" => $version_info['installed']])
                                    @else
                                        Error retrieving the latest Attendize version.
                                    @endif
                                </p>
                                <h4>
                                    {!! @trans("ManageAccount.licence_info") !!}
                                </h4>
                                <p>
                                    {!! @trans("ManageAccount.licence_info_description") !!}
                                </p>
                                <h4>
                                    {!! @trans("ManageAccount.open_source_soft") !!} Open-source Software
                                </h4>
                                <p>
                                    {!! @trans("ManageAccount.open_source_soft_description") !!}
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
