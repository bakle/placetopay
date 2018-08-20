<div class="form-row mb-3">
    {{ Form::PSelect('bank', 'Seleccione el banco:', $bankList, null, [], 'col-lg-4') }}
    {{ Form::PSelect('person_type', 'Seleccione el tipo de persona:', $personTypes, null, [], 'col-lg-4') }}
    {{ Form::PSelect('document_type', 'Seleccione el tipo de documento:', $documentTypes, null, [], 'col-lg-4') }}
</div>

<div class="form-row mb-3">
    {!! Form::PText('document', 'Número de documento:', null, [], 'col-lg-4') !!}
    {!! Form::PText('first_name', 'Nombre:', null, [], 'col-lg-4') !!}
    {!! Form::PText('last_name', 'Apellido:', null, [], 'col-lg-4') !!}
</div>

<div class="form-row">
    {!! Form::PEmail('email', 'Correo electrónico:', null, [], 'col-lg-4') !!}
    {!! Form::PText('city', 'Ciudad:', null, [], 'col-lg-4') !!}
    {!! Form::PText('province', 'Departamento/Provincia:', null, [], 'col-lg-4') !!}
</div>

<div class="form-row">
    <label><strong>Total A Pagar:</strong> &nbsp;</label> ${{ session('price') }}
</div>

<div class="form-group">
    {!! Form::submit('Pagar', ['class' => 'btn btn-primary']) !!}
</div>