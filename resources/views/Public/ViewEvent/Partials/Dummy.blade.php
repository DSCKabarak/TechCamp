<form class="online_payment ajax" action="<?php echo route('postCreateOrder', ['event_id' => $event->id]); ?>" method="post">
    <div class="online_payment">
        <div class="row">
            <div class="col-md-12">
                <div class="form-group">
                    {!! Form::label('card-number', trans("Public_ViewEvent.card_number")) !!}
                    <input required="required" type="text" autocomplete="off" placeholder="**** **** **** ****"
                           class="form-control card-number" size="20" data="number">
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-xs-6">
                <div class="form-group">
                    {!! Form::label('card-expiry-month', trans("Public_ViewEvent.expiry_month")) !!}
                    {!! Form::selectRange('card-expiry-month', 1, 12, null, [
                    'class' => 'form-control card-expiry-month',
                    'data' => 'exp_month'
                    ] ) !!}
                </div>
            </div>
            <div class="col-xs-6">
                <div class="form-group">
                    {!! Form::label('card-expiry-year', trans("Public_ViewEvent.expiry_year")) !!}
                    {!! Form::selectRange('card-expiry-year',date('Y'),date('Y')+10,null, [
                    'class' => 'form-control card-expiry-year',
                    'data' => 'exp_year'
                    ] ) !!}
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="form-group">
                    {!! Form::label('card-expiry-year', trans("Public_ViewEvent.cvc_number")) !!}
                    <input required="required" placeholder="***" class="form-control card-cvc" data="cvc">
                </div>
            </div>
        </div>

        {!! Form::token() !!}

        <input class="btn btn-lg btn-success card-submit" style="width:100%;" type="submit" value="@lang("Public_ViewEvent.complete_payment")">
    </div>
</form>

