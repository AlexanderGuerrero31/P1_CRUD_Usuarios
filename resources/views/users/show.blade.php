@extends('layouts.bootstrap')
@section('title', 'Detalle de usuario')
@section('content')
<div class="row justify-content-center"><div class="col-md-6">
    <div class="card shadow-sm">
        <div class="card-header">Detalle del usuario</div>
        <ul class="list-group list-group-flush">
            <li class="list-group-item"><b>ID:</b> {{ $user->id }}</li>
            <li class="list-group-item"><b>Nombre:</b> {{ $user->name }}</li>
            <li class="list-group-item"><b>Correo:</b> {{ $user->email }}</li>
            <li class="list-group-item"><b>Rol:</b> {{ $user->role }}</li>
            <li class="list-group-item"><b>Registrado:</b> {{ $user->created_at->format('d/m/Y H:i') }}</li>
        </ul>
        <div class="card-footer"><a href="{{ route('users.index') }}" class="btn btn-secondary">Volver</a></div>
    </div>
</div></div>
@endsection