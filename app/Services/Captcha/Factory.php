<?php
namespace Services\Captcha;

/**
 * Class CaptchaFactory
 * @package App\Services\Captcha
 */
class Factory
{

    /**
     * @param $name
     * @param $captchaConfig
     * @return HCaptcha|ReCaptcha
     * @throws \Exception
     */
    public static function create($captchaConfig)
    {
        $name = $captchaConfig["captcha_type"];
        switch ($name) {

            case HCaptcha::CAPTCHA_NAME :
                {
                    return new HCaptcha($captchaConfig);
                }

            case ReCaptcha::CAPTCHA_NAME :
                {
                    return new ReCaptcha($captchaConfig);
                }

            default :
                {
                    throw New \Exception('Invalid captcha type specified');
                }
        }
    }
}