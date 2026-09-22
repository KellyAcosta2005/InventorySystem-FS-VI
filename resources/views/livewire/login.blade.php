<div>
    @if ($errors->any())
        <div class="mb-6 rounded-xl border border-red-200 bg-red-50 px-4 py-3 text-sm font-semibold text-red-700">
            @foreach ($errors->all() as $error)
                <p>{{ $error }}</p>
            @endforeach
        </div>
    @endif

    <form wire:submit="login" class="space-y-5">
        <div>
            <label for="email" class="mb-2 block text-sm font-bold text-slate-700">Correo electrónico</label>
            <input id="email" type="email" wire:model="email" required autofocus autocomplete="email" class="w-full rounded-xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm outline-none transition placeholder:text-slate-400 focus:border-blue-500 focus:bg-white focus:ring-4 focus:ring-blue-100">
            @error('email') <p class="mt-2 text-xs font-semibold text-red-600">{{ $message }}</p> @enderror
        </div>
        <div>
            <label for="password" class="mb-2 block text-sm font-bold text-slate-700">Contraseña</label>
            <input id="password" type="password" wire:model="password" required autocomplete="current-password" class="w-full rounded-xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm outline-none transition placeholder:text-slate-400 focus:border-blue-500 focus:bg-white focus:ring-4 focus:ring-blue-100">
            @error('password') <p class="mt-2 text-xs font-semibold text-red-600">{{ $message }}</p> @enderror
        </div>
        <button type="submit" class="w-full rounded-xl bg-blue-600 px-5 py-3.5 text-sm font-bold text-white shadow-lg shadow-blue-600/20 transition hover:bg-blue-700 focus:outline-none focus:ring-4 focus:ring-blue-200">Entrar al sistema</button>
    </form>

    <p class="mt-7 text-center text-sm text-slate-500">¿Aún no tienes cuenta? <a href="{{ route('register') }}" class="font-bold text-blue-700 hover:text-blue-800">Regístrate aquí</a></p>
</div>