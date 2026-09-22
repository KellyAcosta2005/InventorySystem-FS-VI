@extends('layouts.app')

@section('title', 'Crear cuenta')

@section('content')
    <section class="rounded-3xl border border-slate-200 bg-white p-7 shadow-xl shadow-slate-200/60 sm:p-9">
        <div class="mb-8">
            <p class="mb-2 text-sm font-bold uppercase tracking-[0.18em] text-blue-600">Únete al equipo</p>
            <h1 class="text-3xl font-black tracking-tight text-slate-950">Crear cuenta</h1>
            <p class="mt-2 text-sm leading-6 text-slate-500">Crea tu empresa y conviértete en su primer administrador.</p>
        </div>

        @if ($errors->any())
            <div class="mb-6 rounded-xl border border-red-200 bg-red-50 px-4 py-3 text-sm font-semibold text-red-700">
                @foreach ($errors->all() as $error)
                    <p>{{ $error }}</p>
                @endforeach
            </div>
        @endif

        <form method="POST" action="{{ route('register') }}" class="space-y-5">
            @csrf
            <div>
                <label for="company_name" class="mb-2 block text-sm font-bold text-slate-700">Nombre de la empresa</label>
                <input id="company_name" type="text" name="company_name" value="{{ old('company_name') }}" required autofocus autocomplete="organization" class="w-full rounded-xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm outline-none transition placeholder:text-slate-400 focus:border-blue-500 focus:bg-white focus:ring-4 focus:ring-blue-100">
            </div>
            <div>
                <label for="name" class="mb-2 block text-sm font-bold text-slate-700">Nombre completo</label>
                <input id="name" type="text" name="name" value="{{ old('name') }}" required autocomplete="name" class="w-full rounded-xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm outline-none transition placeholder:text-slate-400 focus:border-blue-500 focus:bg-white focus:ring-4 focus:ring-blue-100">
            </div>
            <div>
                <label for="email" class="mb-2 block text-sm font-bold text-slate-700">Correo electrónico</label>
                <input id="email" type="email" name="email" value="{{ old('email') }}" required autocomplete="email" class="w-full rounded-xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm outline-none transition placeholder:text-slate-400 focus:border-blue-500 focus:bg-white focus:ring-4 focus:ring-blue-100">
            </div>
            <div>
                <label for="password" class="mb-2 block text-sm font-bold text-slate-700">Contraseña</label>
                <input id="password" type="password" name="password" required autocomplete="new-password" class="w-full rounded-xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm outline-none transition placeholder:text-slate-400 focus:border-blue-500 focus:bg-white focus:ring-4 focus:ring-blue-100">
            </div>
            <div>
                <label for="password_confirmation" class="mb-2 block text-sm font-bold text-slate-700">Confirmar contraseña</label>
                <input id="password_confirmation" type="password" name="password_confirmation" required autocomplete="new-password" class="w-full rounded-xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm outline-none transition placeholder:text-slate-400 focus:border-blue-500 focus:bg-white focus:ring-4 focus:ring-blue-100">
            </div>
            <button type="submit" class="w-full rounded-xl bg-blue-600 px-5 py-3.5 text-sm font-bold text-white shadow-lg shadow-blue-600/20 transition hover:bg-blue-700 focus:outline-none focus:ring-4 focus:ring-blue-200">Crear cuenta</button>
        </form>

        <p class="mt-7 text-center text-sm text-slate-500">¿Ya tienes una cuenta? <a href="{{ route('login') }}" class="font-bold text-blue-700 hover:text-blue-800">Inicia sesión</a></p>
    </section>
@endsection