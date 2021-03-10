<?php


namespace Innovaweb\Transbank\Helpers;


class HelperTransbankResponseCode
{

    /**
     * VCI
     *
     * @param string $code vic.
     * @return string retorna el significado del código, Este campo es información adicional suplementaria al responseCode pero el comercio no debe validar este campo. Porque constantemente se agregan nuevos mecanismos de autenticación que se traducen en nuevos valores para este campo que no están necesariamente documentados.
     *
     */
    public static function VCI($code)
    {
        $code = strtoupper(strval($code));
        try {
            $codes = [
                'TSY' => 'Autenticación exitosa.',
                'TSN' => 'Autenticación fallida.',
                'TO' => 'Tiempo máximo excedido para autenticación.',
                'ABO' => 'Autenticación abortada por tarjeta habiente.',
                'U3' => 'Error interno en la autenticación.',
                'NP' => 'No Participa, probablemente por ser una tarjeta extranjera que no participa en el programa 3DSecure.',
                'ACS2' => 'Autenticación fallida extranjera.',
            ];
            return $codes[$code];
        } catch (\Exception $exception) {
            return 'Exception : Código no encontrado.';
        }
    }

    /**
     * ResponseCode
     *
     * @param string $code response_code.
     * @return string retorna el significado del código, Código de respuesta de la autorización.
     *
     */
    public static function ResponseCode($code)
    {
        $code = strval($code);
        try {
            $codes = [
                '0' => 'Transacción aprobada.',
                '-1' => 'Rechazo - Posible error en el ingreso de datos de la transacción.',
                '-2' => 'Rechazo - Se produjo fallo al procesar la transacción, este mensaje de rechazo se encuentra relacionado.',
                '-3' => 'Rechazo - Interno Transbank.',
                '-4' => 'Rechazo - Rechazada por parte del emisor.',
                '-5' => 'Rechazo - Transacción con riesgo de posible fraude.',
            ];
            return $codes[$code];
        } catch (\Exception $exception) {
            return 'Exception : Código no encontrado.';
        }
    }

    /**
     * Status
     *
     * @param string $code status.
     * @return string retorna el significado del código, Estado de la transacción, Largo máximo: 64
     *
     */
    public static function Status($code)
    {
        $code = strtoupper(strval($code));
        try {
            $codes = [
                'INITIALIZED' => 'Transacción inicializada.',
                'AUTHORIZED' => 'Transacción autorizada.',
                'REVERSED' => 'Transacción revertida.',
                'FAILED' => 'Transacción fallida.',
                'NULLIFIED' => 'Transacción anulada.',
                'PARTIALLY_NULLIFIED' => 'Transacción parcialmente anulada.',
                'CAPTURED' => 'Transacción capturada.',
            ];
            return $codes[$code];
        } catch (\Exception $exception) {
            return 'Exception : Código no encontrado.';
        }
    }

    /**
     * PaymentTypeCode
     *
     * @param string $code payment_type_code.
     * @return string retorna el significado del código, Tipo de pago de la transacción.
     *
     */
    public static function PaymentTypeCode($code)
    {
        $code = strtoupper(strval($code));
        try {
            $codes = [
                'VD' => 'Venta Débito.',
                'VN' => 'Venta Normal.',
                'VC' => 'Venta en cuotas.',
                'SI' => '3 cuotas sin interés.',
                'S2' => '2 cuotas sin interés.',
                'NC' => 'N Cuotas sin interés.',
                'VP' => 'Venta Prepago.',
            ];
            return $codes[$code];
        } catch (\Exception $exception) {
            return 'Exception : Código no encontrado.';
        }
    }

}
