@extends('layouts.bootstrap')
@section('title', 'Nuevo usuario')
@section('content')
<div class="row justify-content-center"><div class="col-md-6">
    <div class="card shadow-sm">
        <div class="card-header">Registrar usuario</div>
        <div class="card-body">
            <form method="POST" action="{{ route('users.store') }}">
                @csrf
                @include('users._form')
                <a href="{{ route('users.index') }}" class="btn btn-secondary">Cancelar</a>
                <button class="btn btn-primary">Guardar</button>
            </form>
        </div>
    </div>
</div></div>
@endsection