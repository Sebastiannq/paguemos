<form method="POST" action="{{ route('register.store') }}" style="max-width: 500px; margin: auto;">
    @csrf
    <h2 style="text-align: center;">CREAR CUENTA</h2>

    <div style="display: flex; gap: 10px; margin-bottom: 15px;">
        <div style="flex: 1;">
            <label>Primer Nombre</label>
            <input type="text" name="primer_nom" value="{{ old('primer_nom') }}" style="width: 100%;" required>
        </div>
        <div style="flex: 1;">
            <label>Segundo Nombre</label>
            <input type="text" name="segund_nom" value="{{ old('segund_nom') }}" style="width: 100%;">
        </div>
    </div>

    <div style="display: flex; gap: 10px; margin-bottom: 15px;">
        <div style="flex: 1;">
            <label>Primer Apellido</label>
            <input type="text" name="primer_apelli" value="{{ old('primer_apelli') }}" style="width: 100%;" required>
        </div>
        <div style="flex: 1;">
            <label>Segundo Apellido</label>
            <input type="text" name="segund_apelli" value="{{ old('segund_apelli') }}" style="width: 100%;">
        </div>
    </div>

    <div style="margin-bottom: 15px;">
        <label>Correo Electrónico</label>
        <input type="email" name="email" value="{{ old('email') }}" style="width: 100%;" required>
        @error('email') <span style="color: red;">{{ $message }}</span> @enderror
    </div>

    <div style="margin-bottom: 15px;">
        <label>Contraseña</label>
        <input type="password" name="password" style="width: 100%;" required>
    </div>

    <div style="margin-bottom: 15px;">
        <label>Confirmar Contraseña</label>
        <input type="password" name="password_confirmation" style="width: 100%;" required>
    </div>

    @if ($errors->any())
    <div style="background: #ffcccc; color: red; padding: 10px; margin-bottom: 15px; border-radius: 5px;">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

    <button type="submit" style="width: 100%; padding: 10px; background: #d81b60; color: white; border: none; cursor: pointer;">
        Crear Cuenta
    </button>
</form>