<form class="online_payment ajax" action="<?php echo route('postCreateOrder', ['event_id' => $event->id]); ?>"
      method="POST" id="free-payment-form">

    <p>
        {!! @trans('Public_ViewEvent.no_payment_required') !!}
    </p>

    <div id="form-errors"></div>

    @csrf

    <input class="btn btn-lg btn-success card-submit" style="width:100%;" type="submit"
           value="{!! @trans('Public_ViewEvent.continue') !!}">

</form>
