<?php

namespace Innovaweb\Transbank\Helpers;

class HelperRedirect
{

    public static function redirectHTML($url, $token = '')
    {
        return self::HtmlWrap($url, $token);
    }

    private static function htmlWrap($url, $token)
    {
        $formName = 'webpay-redirect-form-' . uniqid();

        return
            '<html lang="es">
            <head>
                <title>Conectando con Transbank</title>
            </head>
            <body>
                <form action="' . $url . '" id="' . $formName . '" method="POST">
                    <input type="hidden" name="token_ws" value="' . $token . '" />
                </form>
                <script>document.getElementById("' . $formName . '").submit();</script>
            </body>
        </html>';
    }
}
