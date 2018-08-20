@extends('layouts.master')

@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header bg-dark text-white">
                    <h4>Transacci&oacute;n: #{{ $transaction->transaction_id }}</h4>
                </div>
                <div class="card-body">
                    <h5 class="card-title">Detalles</h5>
                    <table class="table table-table-striped">
                        <tbody>
                            <tr>
                                <td>ID Transacci&oacute;n</td>
                                <td>{{ $transaction->transaction_id }}</td>
                            </tr>
                            <tr>
                                <td>Fecha Procesamiento Bancario</td>
                                <td>{{ $transaction->bank_process_date }}</td>
                            </tr>
                            <tr>
                                <td>Estado De La Transacci&oacute;n</td>
                                <td>
                                    <span class="{{ $transaction->class }}">{{ $transaction->transaction_state }}</span>
                                </td>
                            </tr>
                            <tr>
                                <td>Fecha De La Transacci&oacute;n</td>
                                <td>{{ $transaction->created_at }}</td>
                            </tr>
                            <tr>
                                <td>Valor Transacci&oacute;n</td>
                                <td>${{ $transaction->amount }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection