<?php

namespace App\Http\Controllers;

use App\PersonType;
use App\DocumentType;
use App\Http\Requests\PaymentRequest;
use Facades\App\Classes\BankInformation;
use App\Classes\PSEPaymentMethod;
use App\Interfaces\PaymentMethodInterface;
use Facades\App\Http\Controllers\UserController;

class PaymentController extends Controller
{
    /**
     * Mostrar el formulario de Pago
     *
     * @return view     
     **/
    public function create()
    {

        /*
        |---------------------------------------------------------------------------------------
        | Se Almacena en Sesion Un Valor Cualquiera A Pagar, Si No Existe.
        |---------------------------------------------------------------------------------------
        */

        if (!session()->has('price')) {
            $price = rand(1000, 10000);
            session(['price' => $price]);
        }
        

        /*
        |---------------------------------------------------------------------------------------
        | Obtener La Lista De Bancos. Si La Lista Esta Vacia, Se Muestra un Mensaje De Error 
        |---------------------------------------------------------------------------------------
        */

        $bankList = BankInformation::getBankList()->pluck('bankName', 'bankCode');
        
        if (!count($bankList)) {
            session()->flash('error_message', 'No se pudo obtener la lista de Entidades Financieras, por favor intente más tarde.');
        }
        
        /*
        |---------------------------------------------------------------------------------------
        | Obtener La Lista De Tipos De Persona Y Tipos De Documento 
        |---------------------------------------------------------------------------------------
        */

        $personTypes = PersonType::pluck('name', 'id');
        $documentTypes = DocumentType::pluck('description', 'name');
        return view('payments.create', compact('bankList', 'personTypes', 'documentTypes'));
    }


    /**
     * Almacenar la informacion del Pago
     *
     * @return view     
     **/
    public function store(PaymentRequest $request)
    {

        /*
        |---------------------------------------------------------------------------------------
        | Se Almacena El Usuario Que Realiza La Transaccion En La BD Y Se Agrega En Sesion
        | El user_id Para Relacionar La Transaccion Con El Usuario. Esto Se Almacena En Sesion
        | Ya Que No Se Tiene Un Sistema De Login Para Obtener EL Usuario Logueado.
        |---------------------------------------------------------------------------------------
        */

        $user = UserController::store($request, 'user');
        session(['user_id' => $user->id]);

        /*
        |---------------------------------------------------------------------------------------
        | Se Realiza La Transaccion PSE Con los Datos Preparados 
        |---------------------------------------------------------------------------------------
        */

        return $this->makeTransaction(new PSEPaymentMethod($request, $user));        
        
    }

    /**
     * Realiza la transaccion
     *
     * @return void
     **/
    public function makeTransaction(PaymentMethodInterface $paymentMethod)
    {
        /*
        |---------------------------------------------------------------------------------------
        | Se Ejecuta EL MEtodo sendPayment Para Realizar Todo El Proceso Del Pago Segun El Metodo
        | De Pago, En Este Caso El Unico Metodo Disponible Es PSE.
        |---------------------------------------------------------------------------------------
        */

        $transactionResult = $paymentMethod->sendPayment();
        if ($transactionResult && session()->has('bankURL')) {
            return redirect()->away(session('bankURL'));
        }

        /*
        |---------------------------------------------------------------------------------------
        | Si No Se Realiza El Pago, Se Devuelve A La Pagina Anterior. 
        |---------------------------------------------------------------------------------------
        */
        
        return back();
        
    }
}
