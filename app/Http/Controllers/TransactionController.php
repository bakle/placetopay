<?php

namespace App\Http\Controllers;

use App\Transaction;
use Illuminate\Http\Request;

class TransactionController extends Controller
{
    
    /**
     * Show Transactions List.
     *
     * @return view     
     **/
    public function index()
    {
        $transactions = Transaction::paginate(10);
        return view('transactions.list', compact('transactions'));
    }


    /**
     * Show Transactions Detail.
     *
     * @return view     
     **/
    public function show(Transaction $transaction)
    {
        $transactionInformation = $this->getTransactionStatus($transaction);

        $transaction->request_date = $transactionInformation['requestDate'];
        $transaction->bank_process_date = $transactionInformation['bankProcessDate'];
        $transaction->on_test = $transactionInformation['onTest'];
        $transaction->transaction_state = $transactionInformation['transactionState'];
        $transaction->save();

        switch ($transaction->transaction_state) {
            case 'OK':
                $class = 'badge badge-success';
            break;
            case 'PENDING':
                $class = 'badge badge-warning';
            break;
            case '':
                $class = '';
            break;
            default:
                $class = 'badge badge-danger';
            break;
        }

        $transaction->class = $class;

        return view('transactions.show', compact('transaction'));
    }


    /**
     * Show Transactions List.
     *
     * @return view     
     **/
    public function getTransactionStatus(Transaction $transaction)
    {
        /*
        |---------------------------------------------------------------------------------------
        | Obtener El Estado De Una Transaccion Con EL Servicio De Place To Pay, Y Actualizar 
        | La Transacccion De La BD Con los Valores Del Servicio.
        |---------------------------------------------------------------------------------------
        */

        try {
            $soapClient = new \SoapClient(env('PLACETOPAY_WSDL'));    
            $transactionInformation = collect($soapClient->getTransactionInformation([
                'auth' => config('placetopay.auth'),
                'transactionID' => $transaction->transaction_id
            ])->getTransactionInformationResult);

            return $transactionInformation;
        }
        catch (\Exception $e) {
            Log::error($e);
            session()->flash('error_message', 'No se pudo obtener la información completa de la transaccion, por favor intente más tarde.');
            return collect();
        }
    }
}
