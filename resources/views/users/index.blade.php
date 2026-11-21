@extends('layouts.bootstrap')
@section('title', 'Usuarios')
@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h1 class="h4 mb-0">Usuarios</h1>
    <div>
        @if(auth()->user()->isAdmin())
            <a href="{{ route('users.trashed') }}" class="btn btn-outline-secondary">Papelera</a>
        @endif
        <a href="{{ route('users.create') }}" class="btn btn-primary">Nuevo usuario</a>
    </div>
</div>

<div class="card shadow-sm">
    <div class="table-responsive">
        <table class="table table-striped align-middle mb-0">
            <thead>
                <tr><th>ID</th><th>Nombre</th><th>Correo</th><th>Rol</th><th class="text-end">Acciones</th></tr>
            </thead>
            <tbody>
            @forelse($users as $user)
                <tr>
                    <td>{{ $user->id }}</td>
                    <td>{{ $user->name }}</td>
                    <td>{{ $user->email }}</td>
                    <td><span class="badge text-bg-{{ $user->isAdmin() ? 'danger' : 'secondary' }}">{{ $user->role }}</span></td>
                    <td class="text-end">
                        <a href="{{ route('users.show', $user) }}" class="btn btn-sm btn-info">Ver</a>
                        @if(auth()->user()->isAdmin() || !$user->isAdmin())
                            <a href="{{ route('users.edit', $user) }}" class="btn btn-sm btn-warning">Editar</a>
                        @endif
                        @if(auth()->user()->isAdmin() && $user->id !== auth()->id())
                            <button class="btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#del{{ $user->id }}">Eliminar</button>

                            <div class="modal fade text-start" id="del{{ $user->id }}" tabindex="-1">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title">Eliminar a {{ $user->name }}</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                        </div>
                                        <div class="modal-body">
                                            <p>Elige cómo eliminar este usuario:</p>
                                            <ul>
                                                <li><b>Eliminación lógica:</b> se deshabilita, pero se puede restaurar desde la papelera.</li>
                                                <li><b>Eliminación permanente:</b> se borra de la base de datos y no se puede recuperar.</li>
                                            </ul>
                                        </div>
                                        <div class="modal-footer">
                                            <form method="POST" action="{{ route('users.destroy', $user->id) }}">
                                                @csrf @method('DELETE')
                                                <button class="btn btn-warning">Eliminación lógica</button>
                                            </form>
                                            <form method="POST" action="{{ route('users.force', $user->id) }}">
                                                @csrf @method('DELETE')
                                                <button class="btn btn-danger">Eliminación permanente</button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif
                    </td>
                </tr>
            @empty
                <tr><td colspan="5" class="text-center text-muted">No hay usuarios registrados.</td></tr>
            @endforelse
            </tbody>
        </table>
    </div>
</div>

<div class="mt-3">{{ $users->links() }}</div>
@endsection