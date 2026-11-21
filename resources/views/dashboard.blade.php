@extends('layouts.bootstrap')
@section('title', 'Dashboard')
@section('content')
<div class="card shadow-sm">
    <div class="card-body">
        <h1 class="h4">Bienvenido, {{ auth()->user()->name }}</h1>
        <p>Tu rol es: <strong>{{ auth()->user()->role }}</strong></p>
        <a href="{{ route('users.index') }}" class="btn btn-primary">Administrar usuarios</a>
    </div>
</div>
@endsection