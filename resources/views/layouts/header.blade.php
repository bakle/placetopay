<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <a class="navbar-brand" href="{{ url('/') }}">Place To Pay Test</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#menu" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="menu">
        <ul class="navbar-nav">
            <li class="nav-item">
                <a class="nav-link @if(request()->is('transactions')) active @endif" href="{{ route('show_transactions') }}">Ver Transacciones</a>
            </li>
            <li class="nav-item">
                <a class="nav-link @if(request()->is('payment*')) active @endif" href="{{ url('/') }}">Realizar Pago</a>
            </li>
        </ul>
    </div>
</nav>
@component('components.alert_messages')
@endcomponent
<div class="mb-5"></div>