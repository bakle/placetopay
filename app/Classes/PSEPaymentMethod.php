<?php
namespace App\Classes;

use App\User;
use App\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Interfaces\PaymentMethodInterface;

class PSEPaymentMethod implements PaymentMethodInterface
{

    private $userData = [];
    private $transaction = [];
    public function __construct(Request $request, User $user)
    {
        /*
        |---------------------------------------------------------------------------------------
        | Se Preparan Los Datos Del Usuario Para Enviar Con La Transaccion 
        |---------------------------------------------------------------------------------------
        */

        $this->userData['document'] = $user->document;
        $this->userData['documentType'] = $user->document_type->name;
        $this->userData['firstName'] = $user->first_name;
        $this->userData['lastName'] = $user->last_name;
        $this->userData['company'] = $user->company;
        $this->userData['emailAddress'] = $user->email_address;
        $this->userData['address'] = $user->address;
        $this->userData['city'] = $user->city;
        $this->userData['province'] = $user->province;
        $this->userData['country'] = $user->country;
        $this->userData['phone'] = $user->phone;
        $this->userData['mobile'] = $user->mobile;

        /*
        |---------------------------------------------------------------------------------------
        | Se Prepara Los Datos De La Transaccion 
        |---------------------------------------------------------------------------------------
        */

        /* Se resta uno (1) para que "Persona" sea 0 y "Empresa" sea 1. No se pone en el select con esos valores para poder validar la existencia de esos campos en la base de datos */
        $this->transaction['bankInterface'] = ($request->person_type -1);
        
        $this->transaction['bankCode'] = $request->bank;        
        $this->transaction['reference'] = str_random(25);
        $this->transaction['returnURL'] = route('show_transaction_detail', [$this->transaction['reference']]);
        $this->transaction['description'] = 'Pago Prueba (B)';
        $this->transaction['language'] = strtoupper(config('app.locale'));
        $this->transaction['currency'] = 'COP';
        $this->transaction['totalAmount'] = session('price', 20000);
        $this->transaction['taxAmount'] = 0;
        $this->transaction['devolutionBase'] = 0;
        $this->transaction['tipAmount'] = 0;
        $this->transaction['payer'] = $this->userData;
        $this->transaction['buyer'] = $this->userData;
        $this->transaction['shipping'] = $this->userData;
        $this->transaction['ipAddress'] = $request->ip();
        $this->transaction['userAgent'] = $request->userAgent();
        $this->transaction['additionalData'] = [];
    }
    
    public function sendPayment()
    {

        /*
        |---------------------------------------------------------------------------------------
        | Se Ejecuta El Servicio createTransaction De Place To Pay
        |---------------------------------------------------------------------------------------
        */

        try {

            $soapClient = new \SoapClient(env('PLACETOPAY_WSDL'));
            $transactionResult = collect($soapClient->createTransaction([
                'auth' => config('placetopay.auth'),
                'transaction' => $this->transaction
            ])->createTransactionResult);

            /*
            |---------------------------------------------------------------------------------------
            | Si La Respuesta Del Servicio No Es Vacia, Y El Codigo Es SUCCESS, Entonces Se
            | Almacenan Los Datos En La BD, Para Luego Verificar El Status De La Transaccion 
            |---------------------------------------------------------------------------------------
            */
            
            if (!empty($transactionResult)) {
                if ($transactionResult['returnCode'] == "SUCCESS") {
                    $transactionResult['reference'] = $this->transaction['reference'];
                    $this->storeTransaction($transactionResult);
                    session()->flash('bankURL', $transactionResult['bankURL']);
                    return true;
                }
                else {
                    session()->flash('error_message', $transactionResult['responseReasonText']);
                    return false;
                }                
            }
        }
        catch (\Exception $e) {
            Log::error($e);
            session()->flash('error_message', 'Ocurrió un error en la transacción, por favor intente de nuevo.');
            return false;
        }
    }


    public function storeTransaction($transactionResult)
    {
        Transaction::create([
            'transaction_id' => $transactionResult['transactionID'],
            'session_id' => $transactionResult['sessionID'],
            'reference' => $transactionResult['reference'],
            'amount' => session('price'),
            'return_code' => $transactionResult['returnCode'],
            'trazability_code' => $transactionResult['trazabilityCode'],
            'transaction_cycle' => $transactionResult['transactionCycle'],
            'bank_currency' => $transactionResult['bankCurrency'],
            'bank_factor' => $transactionResult['bankFactor'],
            'bank_url' => $transactionResult['bankURL'],
            'response_code' => $transactionResult['responseCode'],
            'response_reason_code' => $transactionResult['responseReasonCode'],
            'response_reason_text' => $transactionResult['responseReasonText'],
            'user_id' => session('user_id'),
        ]);
    }
}