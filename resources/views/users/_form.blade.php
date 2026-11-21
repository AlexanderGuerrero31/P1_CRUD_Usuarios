<div class="mb-3">
    <label class="form-label">Nombre</label>
    <input name="name" value="{{ old('name', $user->name ?? '') }}"
           class="form-control @error('name') is-invalid @enderror" required>
    @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
</div>
<div class="mb-3">
    <label class="form-label">Correo electrónico</label>
    <input type="email" name="email" value="{{ old('email', $user->email ?? '') }}"
           class="form-control @error('email') is-invalid @enderror" required>
    @error('email') <div class="invalid-feedback">{{ $message }}</div> @enderror
</div>
<div class="mb-3">
    <label class="form-label">Contraseña @isset($user)<small class="text-muted">(déjala vacía para no cambiarla)</small>@endisset</label>
    <input type="password" name="password"
           class="form-control @error('password') is-invalid @enderror" @empty($user) required @endempty>
    @error('password') <div class="invalid-feedback">{{ $message }}</div> @enderror
</div>
<div class="mb-3">
    <label class="form-label">Confirmar contraseña</label>
    <input type="password" name="password_confirmation" class="form-control">
</div>
@if(auth()->user()->isAdmin())
    <div class="mb-3">
        <label class="form-label">Rol</label>
        <select name="role" class="form-select @error('role') is-invalid @enderror">
            @foreach(['empleado', 'admin'] as $rol)
                <option value="{{ $rol }}" @selected(old('role', $user->role ?? 'empleado') === $rol)>{{ $rol }}</option>
            @endforeach
        </select>
        @error('role') <div class="invalid-feedback">{{ $message }}</div> @enderror
    </div>
@endif