@extends('errors.layout')

@section('code', '429')
@section('title', 'Demasiadas Solicitudes')
@section('subtitle', 'Vas muy rápido, tómate un descanso')

@section('badge')
    <div class="error-badge badge-orange">
        <span class="badge-dot"></span>
        Límite Alcanzado
    </div>
@endsection

@section('description')
    Has realizado demasiadas solicitudes en un corto período de tiempo.
    Espera unos minutos y vuelve a intentarlo. Tu progreso está guardado.
@endsection