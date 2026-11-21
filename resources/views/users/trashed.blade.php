@extends('layouts.bootstrap')
@section('title', 'Papelera')
@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h1 class="h4 mb-0">Usuarios deshabilitados</h1>
    <a href="{{ route('users.index') }}" class="btn btn-secondary">Volver al listado</a>
</div>

<div class="card shadow-sm">
    <div class="table-responsive">
        <table class="table table-striped align-middle mb-0">
            <thead><tr><th>ID</th><th>Nombre</th><th>Correo</th><th>Deshabilitado el</th><th class="text-end">Acciones</th></tr></thead>
            <tbody>
            @forelse($users as $user)
                <tr>
                    <td>{{ $user->id }}</td>
                    <td>{{ $user->name }}</td>
                    <td>{{ $user->email }}</td>
                    <td>{{ $user->deleted_at->format('d/m/Y H:i') }}</td>
                    <td class="text-end">
                        <form method="POST" action="{{ route('users.restore', $user->id) }}" class="d-inline">
                            @csrf @method('PATCH')
                            <button class="btn btn-sm btn-success">Restaurar</button>
                        </form>
                        <form method="POST" action="{{ route('users.force', $user->id) }}" class="d-inline"
                              onsubmit="return confirm('¿Eliminar permanentemente? No se puede deshacer.')">
                            @csrf @method('DELETE')
                            <button class="btn btn-sm btn-danger">Eliminar permanente</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr><td colspan="5" class="text-center text-muted">La papelera está vacía.</td></tr>
            @endforelse
            </tbody>
        </table>
    </div>
</div>
<div class="mt-3">{{ $users->links() }}</div>
@endsection