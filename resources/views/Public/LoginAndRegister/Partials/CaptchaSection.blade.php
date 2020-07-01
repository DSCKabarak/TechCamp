@if(config('attendize.captcha.captcha_is_on') && config('attendize.captcha.captcha_secret'))
<div class="form-group ">
    @if(config('attendize.captcha.captcha_type') == 'recaptcha')
        @include('Public.LoginAndRegister.Partials.CaptchaRecaptcha')
    @endif
    @if(config('attendize.captcha.captcha_type') == 'hcaptcha')
        @include('Public.LoginAndRegister.Partials.CaptchaHcaptcha')
    @endif
</div>
@endif
