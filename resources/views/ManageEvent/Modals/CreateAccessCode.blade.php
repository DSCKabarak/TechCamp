<div role="dialog" class="modal fade" style="display: none;">
    {!! Form::open(['url' => route('postCreateEventAccessCode', ['event_id' => $event->id]), 'class' => 'ajax']) !!}
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header text-center">
                <button type="button" class="close" data-dismiss="modal">×</button>
                <h3 class="modal-title">
                    <i class="ico-ticket"></i>
                    @lang("DiscountCodes.create_discount_code")</h3>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            {!! Form::label('code', trans("DiscountCodes.discount_code_title"), ['class'=>'control-label required']) !!}
                            {!! Form::text('code', Input::old('code'),
                                        [
                                            'class'=>'form-control',
                                            'placeholder' => trans("DiscountCodes.discount_code_title_placeholder")
                                        ])  !!}
                        </div>
                    </div>
                </div>
            </div> <!-- /end modal body-->
            <div class="modal-footer">
                {!! Form::button(trans("basic.cancel"), ['class'=>"btn modal-close btn-danger",'data-dismiss'=>'modal']) !!}
                {!! Form::submit(trans("DiscountCodes.create_discount_code"), ['class'=>"btn btn-success"]) !!}
            </div>
        </div><!-- /end modal content-->
        {!! Form::close() !!}
    </div>
</div>