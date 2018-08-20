@extends('layouts.master')

@section('content')
    <div class="row">
        <div class="col-lg-6 offset-lg-3">
            <div class="card">
                <div class="card-header bg-dark text-white">
                    <h4>Detalles De La Compra</h4>
                </div>
                <div class="card-body">
                    <table class="table table-table-stripper">
                        <tbody>
                            <tr>
                                <td>Total Articulos</td>
                                <td>1</td>
                            </tr>
                            <tr>
                                <td>Subtotal</td>
                                <td>${{ $price }}</td>
                            </tr>
                            <tr>
                                <td>Impuestos</td>
                                <td>$0</td>
                            </tr>
                            <tr>
                                <td>Total</td>
                                <td>${{ $price }}</td>
                            </tr>
                        </tbody>
                    </table>
                    <div class="text-center">
                        <a href="{{ route('show_payment_form') }}" class="btn btn-primary text-white">Pagar Con PSE</a>
                    </div>
                    
                </div>
            </div>
        </div>
    </div>
@endsection