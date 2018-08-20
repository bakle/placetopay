<?php

namespace App\Jobs;

use App\Transaction;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use App\Http\Controllers\TransactionController;

class CheckPendingTransactions implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $transactions = Transaction::where(function($query){
            $query->where('transaction_state', 'PENDING')->orWhereNull('transaction_state');
        })->whereRaw('TIMESTAMPDIFF(MINUTE, created_at, "' . now() .'") > 7')->get();

        foreach ($transactions as $transaction) {
            $transactionInformation = TransactionController::getTransactionStatus($transaction);
            $transaction->request_date = $transactionInformation['requestDate'];
            $transaction->bank_process_date = $transactionInformation['bankProcessDate'];
            $transaction->on_test = $transactionInformation['onTest'];
            $transaction->transaction_state = $transactionInformation['transactionState'];
            $transaction->save();
        }
    }
}
