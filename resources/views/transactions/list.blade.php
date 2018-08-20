@extends('layouts.master')

@section('content')
    <div class="row">
        <div class="col-lg-12">
            @if(count($transactions) > 0)
            <table class="table table-table-striped">
                <thead>
                    <tr>
                        <th>Transacci&oacute;n</th>
                        <th>Usuario</th>                        
                        <th>Fecha De Transacci&oacute;n</th>
                        <th>Valor Transacci&oacute;n</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($transactions as $transaction)
                        <tr>
                            <td>{{ $transaction->transaction_id }}</td>
                            <td>{{ $transaction->user->full_name }}</td>                            
                            <td>{{ $transaction->created_at }}</td>
                            <td>${{ $transaction->amount }}</td>
                            <td><a href="{{ route('show_transaction_detail', [$transaction->reference]) }}">Ver</a></td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            @else
                <div class="text-center">
                    <h3 class="text-warning mb-4">No Hay Transacciones Disponibles.</h3>
                    <a href="{{ route('show_payment_form') }}" class="btn btn-dark ">Crear Pago Con PSE</a>
                </div>
                
            @endif
        </div>
    </div>
@endsection