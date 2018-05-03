<script>
    $(function() {
        $('.payment_gateway_options').hide();
        $('#gateway_{{$account->payment_gateway_id}}').show();

        $('.gateway_selector').on('change', function(e) {
            $('.payment_gateway_options').hide();
            $('#gateway_' + $(this).val()).fadeIn();
        });

    });
</script>

{!! Form::model($account, array('url' => route('postEditAccountPayment'), 'class' => 'ajax ')) !!}
<div class="form-group">
    {!! Form::label('payment_gateway_id', trans("ManageAccount.default_payment_gateway"), array('class'=>'control-label ')) !!}
    {!! Form::select('payment_gateway_id', $payment_gateways, $account->payment_gateway_id, ['class' => 'form-control gateway_selector']) !!}
</div>

{{--Stripe--}}
<section class="payment_gateway_options" id="gateway_{{config('attendize.payment_gateway_stripe')}}">
    <h4>@lang("ManageAccount.stripe_settings")</h4>
    <div class="row">
        <div class="col-md-6">
            <div class="form-group">
                {!! Form::label('stripe[apiKey]', trans("ManageAccount.stripe_secret_key"), array('class'=>'control-label ')) !!}
                {!! Form::text('stripe[apiKey]', $account->getGatewayConfigVal(config('attendize.payment_gateway_stripe'), 'apiKey'),[ 'class'=>'form-control'])  !!}
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                {!! Form::label('publishableKey', trans("ManageAccount.stripe_publishable_key"), array('class'=>'control-label ')) !!}
                {!! Form::text('stripe[publishableKey]', $account->getGatewayConfigVal(config('attendize.payment_gateway_stripe'), 'publishableKey'),[ 'class'=>'form-control'])  !!}
            </div>
        </div>
    </div>
</section>

{{--Paypal--}}
<section class="payment_gateway_options"  id="gateway_{{config('attendize.payment_gateway_paypal')}}">
    <h4>@lang("ManageAccount.paypal_settings")</h4>

    <div class="row">
        <div class="col-md-6">
            <div class="form-group">
                {!! Form::label('paypal[username]', trans("ManageAccount.paypal_username"), array('class'=>'control-label ')) !!}
                {!! Form::text('paypal[username]', $account->getGatewayConfigVal(config('attendize.payment_gateway_paypal'), 'username'),[ 'class'=>'form-control'])  !!}
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                {!! Form::label('paypal[password]', trans("ManageAccount.paypal_password"), ['class'=>'control-label ']) !!}
                {!! Form::text('paypal[password]', $account->getGatewayConfigVal(config('attendize.payment_gateway_paypal'), 'password'),[ 'class'=>'form-control'])  !!}
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="form-group">
                {!! Form::label('paypal[signature]', trans("ManageAccount.paypal_signature"), array('class'=>'control-label ')) !!}
                {!! Form::text('paypal[signature]', $account->getGatewayConfigVal(config('attendize.payment_gateway_paypal'), 'signature'),[ 'class'=>'form-control'])  !!}
            </div>
        </div>
    </div>
        <div class="row">
            <div class="col-md-12">
                <div class="form-group">
                    {!! Form::label('paypal[brandName]', trans("ManageAccount.branding_name"), array('class'=>'control-label ')) !!}
                    {!! Form::text('paypal[brandName]', $account->getGatewayConfigVal(config('attendize.payment_gateway_paypal'), 'brandName'),[ 'class'=>'form-control'])  !!}
                    <div class="help-block">
                        @lang("ManageAccount.branding_name_help")
                    </div>
                </div>
            </div>
        </div>


</section>

{{--BitPay--}}
<section class="payment_gateway_options" id="gateway_{{config('attendize.payment_gateway_bitpay')}}">
    <h4>@lang("ManageAccount.bitpay_settings")</h4>
    <div class="row">
        <div class="col-md-12">
            <div class="form-group">
                {!! Form::label('bitpay[apiKey]', trans("ManageAccount.bitpay_api_key"), array('class'=>'control-label ')) !!}
                {!! Form::text('bitpay[apiKey]', $account->getGatewayConfigVal(config('attendize.payment_gateway_bitpay'), 'apiKey'),[ 'class'=>'form-control'])  !!}
            </div>
        </div>
    </div>
</section>


{{--Coinbase--}}
<section class="payment_gateway_options"  id="gateway_{{config('attendize.payment_gateway_coinbase')}}">
    <h4>@lang("ManageAccount.coinbase_settings")</h4>

    <div class="row">
        <div class="col-md-6">
            <div class="form-group">
                {!! Form::label('coinbase[apiKey]', trans("ManageAccount.api_key"), array('class'=>'control-label ')) !!}
                {!! Form::text('coinbase[apiKey]', $account->getGatewayConfigVal(config('attendize.payment_gateway_coinbase'), 'apiKey'),[ 'class'=>'form-control'])  !!}
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                {!! Form::label('coinbase[secret]', trans("ManageAccount.secret_code"), ['class'=>'control-label ']) !!}
                {!! Form::text('coinbase[secret]', $account->getGatewayConfigVal(config('attendize.payment_gateway_coinbase'), 'secret'),[ 'class'=>'form-control'])  !!}
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="form-group">
                {!! Form::label('coinbase[accountId]', trans("ManageAccount.account_id"), array('class'=>'control-label ')) !!}
                {!! Form::text('coinbase[accountId]', $account->getGatewayConfigVal(config('attendize.payment_gateway_coinbase'), 'accountId'),[ 'class'=>'form-control'])  !!}
            </div>
        </div>
    </div>


</section>

{{--BDO MIGS--}}
<section class="payment_gateway_options"  id="gateway_{{config('attendize.payment_gateway_migs')}}">
    <h4>@lang("ManageAccount.mastercard_internet_gateway_service_settings")</h4>

    <div class="row">
        <div class="col-md-6">
            <div class="form-group">
                {!! Form::label('migs[merchantAccessCode]', trans("ManageAccount.merchant_access_code"), array('class'=>'control-label ')) !!}
                {!! Form::text('migs[merchantAccessCode]', $account->getGatewayConfigVal(config('attendize.payment_gateway_migs'), 'merchantAccessCode'),[ 'class'=>'form-control'])  !!}
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                {!! Form::label('migs[merchantId]', trans("ManageAccount.merchant_id"), ['class'=>'control-label ']) !!}
                {!! Form::text('migs[merchantId]', $account->getGatewayConfigVal(config('attendize.payment_gateway_migs'), 'merchantId'),[ 'class'=>'form-control'])  !!}
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="form-group">
                {!! Form::label('migs[secureHash]', trans("ManageAccount.secure_hash_code"), array('class'=>'control-label ')) !!}
                {!! Form::text('migs[secureHash]', $account->getGatewayConfigVal(config('attendize.payment_gateway_migs'), 'secureHash'),[ 'class'=>'form-control'])  !!}
            </div>
        </div>
    </div>


</section>




<div class="row">
    <div class="col-md-12">
        <div class="panel-footer">
            {!! Form::submit(trans("ManageAccount.save_payment_details_submit"), ['class' => 'btn btn-success pull-right']) !!}
        </div>
    </div>
</div>


{!! Form::close() !!}