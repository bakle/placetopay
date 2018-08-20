@extends('layouts.master')

@section('content')
    <div class="row">
        <div class="col-lg-12 mb-4">
            <div class="card ">
                <div class="card-header text-white bg-secondary">
                    <h4>Pagar Con PSE</h4>
                </div>
                <div class="card-body">                    
                    {!! Form::open(['route' => 'store_payment']) !!}

                        @include('payments.form')

                    {!! Form::close() !!}
                </div>
                
            </div>

        </div>
    </div>
   

@endsection