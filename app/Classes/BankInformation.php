<?php
namespace App\Classes;

use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Cache;

class BankInformation
{

    /**
     * Get Bank List Information
     *
     * @return array     
     **/
    public function getBankList()
    {

        /*
        |---------------------------------------------------------------------------------------
        | Verificar Si Existe La Lista De Bancos En El cache. Si Existe, Se Devuelve La Lista
        | Del Cache.
        |---------------------------------------------------------------------------------------
        */

        if (Cache::has('bankList')) {
            return collect(Cache::get('bankList'));
        }

        /*
        |---------------------------------------------------------------------------------------
        | Traer La Lista De Bancos Del Servicio De PLace To Pay. Si Ocurre Algun Error,
        | Se Devuelve Una Lista Vacia.
        |---------------------------------------------------------------------------------------
        */

        try {
            $soapClient = new \SoapClient(env('PLACETOPAY_WSDL'));
            $bankList = collect($soapClient->getBankList([
                'auth' => config('placetopay.auth')
            ])->getBankListResult);
        }
        catch (\Exception $e) {
            Log::error($e);
            return collect();
        }
        
        /*
        |---------------------------------------------------------------------------------------
        | Si La Lista De Bancos Que Se Obtuvo Del Servicio No Esta Vacia, Entonces Se Almacena 
        | En Cache Con Expiracion de 24H Y Se Devuelve La Lista De Bancos
        |---------------------------------------------------------------------------------------
        */

        if (count(optional($bankList)->first())) {
            Cache::put('bankList', $bankList->first(), now()->addDay());
            return collect($bankList->first());
        }

        /*
        |---------------------------------------------------------------------------------------
        | Si La Lista De Bancos Es Vacia, Se Devuelve Una Lista Vacia 
        |---------------------------------------------------------------------------------------
        */
        
        return collect();
        
    }
}