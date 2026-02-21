@extends('errors.layout')

@section('code', '402')
@section('title', 'Pago Requerido')
@section('subtitle', 'Este contenido necesita una suscripción activa')

@section('badge')
    <div class="error-badge badge-orange">
        <span class="badge-dot"></span>
        Contenido Premium
    </div>
@endsection

@section('description')
    Para acceder a este recurso educativo necesitas contar con una suscripción activa.
    Consulta con tu institución o administrador para más información.
@endsection