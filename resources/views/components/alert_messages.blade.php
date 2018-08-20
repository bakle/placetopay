@if(session()->has('error_message'))
    <div class="alert alert-danger">
        {{ session('error_message') }}
    </div>
@endif

@if(session()->has('success_message'))
    <div class="alert alert-success">
        {{ session('success_message') }}
    </div>
@endif

@if(count($errors) > 0)
    <div class="alert alert-danger">
        Tiene algunos errores, por favor verif&iacute;quelos e intente de nuevo.
    </div>
@endif
