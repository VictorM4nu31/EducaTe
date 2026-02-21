@extends('errors.layout')

@section('code', '401')
@section('title', 'No Autorizado')
@section('subtitle', 'Esta área es solo para miembros')

@section('badge')
    <div class="error-badge badge-yellow">
        <span class="badge-dot"></span>
        Acceso Restringido
    </div>
@endsection

@section('description')
    Necesitas iniciar sesión para poder acceder a este contenido.
    Si ya tienes una cuenta, por favor verifica tus credenciales e intenta de nuevo.
@endsection

@section('extra_action')
    <a href="{{ route('login') }}" class="btn btn-primary"
        style="background: linear-gradient(135deg, var(--green) 0%, #16a34a 100%);">
        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="none" viewBox="0 0 24 24" stroke="currentColor"
            stroke-width="2.5">
            <path stroke-linecap="round" stroke-linejoin="round"
                d="M15.75 9V5.25A2.25 2.25 0 0013.5 3h-6a2.25 2.25 0 00-2.25 2.25v13.5A2.25 2.25 0 007.5 21h6a2.25 2.25 0 002.25-2.25V15M12 9l-3 3m0 0l3 3m-3-3h12.75" />
        </svg>
        Iniciar Sesión
    </a>
@endsection