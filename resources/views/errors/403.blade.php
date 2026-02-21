@extends('errors.layout')

@section('code', '403')
@section('title', 'Acceso Prohibido')
@section('subtitle', 'No tienes permiso para ver esta sección')

@section('badge')
    <div class="error-badge badge-red">
        <span class="badge-dot"></span>
        Sin Permisos
    </div>
@endsection

@section('description')
    @if(isset($exception) && $exception->getMessage())
        {{ $exception->getMessage() }}
    @else
        Tu rol actual no tiene acceso a esta área de la plataforma.
        Si crees que esto es un error, contacta al administrador de tu institución.
    @endif
@endsection