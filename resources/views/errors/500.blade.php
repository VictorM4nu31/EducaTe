@extends('errors.layout')

@section('code', '500')
@section('title', 'Error del Servidor')
@section('subtitle', 'Algo falló en nuestro sistema')

@section('badge')
    <div class="error-badge badge-red">
        <span class="badge-dot"></span>
        Error Interno
    </div>
@endsection

@section('description')
    Ocurrió un error inesperado en nuestros servidores. Ya estamos trabajando para
    resolverlo lo antes posible. Por favor intenta de nuevo en unos minutos.
@endsection