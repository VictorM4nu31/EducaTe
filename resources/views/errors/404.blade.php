@extends('errors.layout')

@section('code', '404')
@section('title', 'Página No Encontrada')
@section('subtitle', 'Parece que esta lección no existe')

@section('badge')
    <div class="error-badge badge-blue">
        <span class="badge-dot"></span>
        No Encontrado
    </div>
@endsection

@section('description')
    La página que buscas pudo haber sido movida, eliminada o tal vez escribiste
    la dirección incorrecta. Regresa al inicio y continúa aprendiendo.
@endsection