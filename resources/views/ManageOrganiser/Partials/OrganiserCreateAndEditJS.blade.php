$(document).ready(function(){
    var charge_tax = $("input[type=radio][name='charge_tax']:checked").val();
    if (charge_tax == 1) {
        $('#tax_fields').show();
    } else {
        $('#tax_fields').hide();
    }

    $('input[type=radio][name=charge_tax]').change(function() {
        if (this.value == 1) {
            $('#tax_fields').show();
        }
        else {
            $('#tax_fields').hide();
        }
    });
});