<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    public function index()
    {
        $users = User::orderBy('name')->paginate(10);
        return view('users.index', compact('users'));
    }

    public function create()
    {
        return view('users.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', 'unique:users,email'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'role' => ['nullable', Rule::in(['admin', 'empleado'])],
        ]);

        // Solo el administrador puede asignar roles; el empleado siempre crea empleados
        $data['role'] = $request->user()->isAdmin() ? ($data['role'] ?? 'empleado') : 'empleado';

        User::create($data);

        return redirect()->route('users.index')->with('status', 'Usuario registrado correctamente.');
    }

    public function show(User $user)
    {
        return view('users.show', compact('user'));
    }

    public function edit(Request $request, User $user)
    {
        abort_if(!$request->user()->isAdmin() && $user->isAdmin(), 403);
        return view('users.edit', compact('user'));
    }

    public function update(Request $request, User $user)
    {
        abort_if(!$request->user()->isAdmin() && $user->isAdmin(), 403);

        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', Rule::unique('users', 'email')->ignore($user->id)],
            'password' => ['nullable', 'string', 'min:8', 'confirmed'],
            'role' => ['nullable', Rule::in(['admin', 'empleado'])],
        ]);

        if (!$request->user()->isAdmin()) {
            unset($data['role']);
        }
        if (empty($data['password'])) {
            unset($data['password']);
        }

        $user->update($data);

        return redirect()->route('users.index')->with('status', 'Usuario actualizado correctamente.');
    }

    // Eliminación lógica (Soft Delete)
    public function destroy(Request $request, User $user)
    {
        abort_if($user->id === $request->user()->id, 403, 'No puedes eliminar tu propia cuenta.');

        $user->delete();

        return redirect()->route('users.index')->with('status', 'Usuario deshabilitado (eliminación lógica).');
    }

    public function trashed()
    {
        $users = User::onlyTrashed()->orderBy('name')->paginate(10);
        return view('users.trashed', compact('users'));
    }

    public function restore(int $id)
    {
        User::onlyTrashed()->findOrFail($id)->restore();

        return redirect()->route('users.trashed')->with('status', 'Usuario restaurado correctamente.');
    }

    // Eliminación permanente (Delete)
    public function forceDelete(Request $request, int $id)
    {
        $user = User::withTrashed()->findOrFail($id);
        abort_if($user->id === $request->user()->id, 403, 'No puedes eliminar tu propia cuenta.');

        $user->forceDelete();

        return redirect()->route('users.index')->with('status', 'Usuario eliminado permanentemente.');
    }
}