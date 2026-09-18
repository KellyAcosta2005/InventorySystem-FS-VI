@extends('layouts.app')

@section('title', 'Iniciar sesión')

@section('content')
    <section class="rounded-3xl border border-slate-200 bg-white p-7 shadow-xl shadow-slate-200/60 sm:p-9">
        <div class="mb-8">
            <p class="mb-2 text-sm font-bold uppercase tracking-[0.18em] text-blue-600">Bienvenido de nuevo</p>
            <h1 class="text-3xl font-black tracking-tight text-slate-950">Iniciar sesión</h1>
            <p class="mt-2 text-sm leading-6 text-slate-500">Accede a tu panel de control de inventario.</p>
        </div>

        @if ($errors->any())
            <div class="mb-6 rounded-xl border border-red-200 bg-red-50 px-4 py-3 text-sm font-semibold text-red-700">
                @foreach ($errors->all() as $error)
                    <p>{{ $error }}</p>
                @endforeach
            </div>
        @endif

        <form method="POST" action="{{ route('login') }}" class="space-y-5">
            @csrf
            <div>
                <label for="email" class="mb-2 block text-sm font-bold text-slate-700">Correo electrónico</label>
                <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus autocomplete="email" class="w-full rounded-xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm outline-none transition placeholder:text-slate-400 focus:border-blue-500 focus:bg-white focus:ring-4 focus:ring-blue-100">
            </div>
            <div>
                <label for="password" class="mb-2 block text-sm font-bold text-slate-700">Contraseña</label>
                <input id="password" type="password" name="password" required autocomplete="current-password" class="w-full rounded-xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm outline-none transition placeholder:text-slate-400 focus:border-blue-500 focus:bg-white focus:ring-4 focus:ring-blue-100">
            </div>
            <label class="flex items-center gap-2 text-sm font-semibold text-slate-600">
                <input type="checkbox" name="remember" value="1" class="size-4 rounded border-slate-300 text-blue-600 focus:ring-blue-500">
                Recordarme
            </label>
            <button type="submit" class="w-full rounded-xl bg-blue-600 px-5 py-3.5 text-sm font-bold text-white shadow-lg shadow-blue-600/20 transition hover:bg-blue-700 focus:outline-none focus:ring-4 focus:ring-blue-200">Entrar al sistema</button>
        </form>

        <p class="mt-7 text-center text-sm text-slate-500">¿Aún no tienes cuenta? <a href="{{ route('register') }}" class="font-bold text-blue-700 hover:text-blue-800">Regístrate aquí</a></p>
    </section>
@endsection