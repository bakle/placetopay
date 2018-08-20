@component('mail::message')
# Transacci&oacute;n #{{ $transaction->transaction_id }}

<label>
    <strong>Fecha Procesamiento Bancario: </strong>
    {{ $transaction->bank_process_date }}
</label>
<br>
<label>
    <strong>Estado De La Transacci&oacute;n: </strong>
{{ $transaction->transaction_state }}
</label>
<br>
<label>
    <strong>Fecha De La Transacci&oacute;n: </strong>
    {{ $transaction->created_at }}
</label>

<br>

Gracias,<br>
{{ config('app.name') }}
@endcomponent
