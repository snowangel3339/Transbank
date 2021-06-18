<?php


namespace Innovaweb\Transbank;

use Innovaweb\Transbank\Helpers\HelperRedirect;
use Transbank\Webpay\Oneclick as OneClick;

class OneClickMall
{
    /** @const INTEGRATION Development environment */
    const INTEGRATION = 'integration';

    /** @const PRODUCTION Production environment */
    const PRODUCTION = 'production';

    public $token;
    public $url;
    public $commerce_code;

    public function __construct($webpay_plus_commerce_code = '',
                                $webpay_plus_api_key = '',
                                $environment = self::INTEGRATION)
    {
        if ($environment === self::PRODUCTION and !empty($webpay_plus_commerce_code) and !empty($webpay_plus_api_key)) {
            OneClick::configureOneclickMallDeferredForTesting($webpay_plus_commerce_code, $webpay_plus_api_key);
            $this->commerce_code = $webpay_plus_commerce_code;
        } else {
            OneClick::configureOneclickMallForTesting();
            $this->commerce_code = 597055555543;

        }
    }

    /**
     * createInscription
     *
     */
    public function createInscription($username, $email, $url_return)
    {

        try {

            $response = OneClick\MallInscription::start($username, $email, $url_return);
            $this->token = $response->getToken();
            $this->url = $response->getUrlWebpay();

            return [
                'status' => 'success',
                'response' => $response
            ];

        } catch (\Exception $exception) {
            return [
                'status' => 'error',
                'exception' => $exception->getMessage(),
            ];
        }
    }

    /**
     * finishInscription
     *
     */
    public function finishInscription($tbk_token)
    {
        try {
            if (!$tbk_token) {
                $tbk_token  = $_POST['TBK_TOKEN'];
            }
            $response = OneClick\MallInscription::finish($tbk_token );

            if((int) $response->getResponseCode() === 0){
                return [
                    'status' => 'success',
                    'response' => $response
                ];
            }else{
                return [
                    'status' => 'error',
                    'exception' => $response,
                ];
            }


        } catch (\Exception $exception) {
            return [
                'status' => 'error',
                'exception' => $exception->getMessage(),
            ];
        }
    }

    /**
     * authorize

     */
    public function authorize($username, $tbkUser, $order_id, $amount)
    {
        $details = [
            [
                "commerce_code" => $this->commerce_code,
                "buy_order" => $order_id,
                "amount" => $amount,
                "installments_number" => 1
            ]
        ];
        try {
            $response = OneClick\MallTransaction::authorize($username, $tbkUser, $order_id, $details);
            return [
                'status' => 'success',
                'response' => $response
            ];

        } catch (\Exception $exception) {
            return [
                'status' => 'error',
                'exception' => $exception->getMessage(),
            ];
        }
    }

    /**
     * getStatus
     *
     */
    public function getStatus($buyOrder)
    {
        try {
            $response = OneClick\MallTransaction::getStatus($buyOrder);
            return [
                'status' => 'success',
                'response' => $response
            ];

        } catch (\Exception $exception) {
            return [
                'status' => 'error',
                'exception' => $exception->getMessage(),
            ];
        }
    }

    public function redirectHTML($url = '', $token = '')
    {
        $url = empty($url) ? $this->url : $url;
        $token = empty($token) ? $this->token : $token;
        return HelperRedirect::redirectHTML($url, $token, 'oneclick');
    }
}
