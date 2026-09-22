@extends('layouts.app')

@section('title', 'Operarios | KANG Sistema de Inventarios')

@section('content')
    <div class="mb-8">
        <p class="mb-2 text-sm font-bold uppercase tracking-[0.18em] text-blue-600">Equipo</p>
        <h1 class="text-3xl font-black tracking-tight text-slate-950">Gestión de operarios</h1>
        <p class="mt-2 text-slate-500">Crea y administra los operarios de {{ auth()->user()->company->name }}.</p>
    </div>

    <div class="grid gap-6 xl:grid-cols-[minmax(0,0.85fr)_minmax(0,1.15fr)]">
        <section class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm sm:p-8">
            <div class="mb-6 flex items-start gap-4">
                <span class="flex size-11 items-center justify-center rounded-xl bg-blue-50 text-blue-700"><svg aria-hidden="true" class="size-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8"><path stroke-linecap="round" stroke-linejoin="round" d="M18 9a3 3 0 1 1-6 0 3 3 0 0 1 6 0Zm-9 6a3 3 0 1 1-6 0 3 3 0 0 1 6 0Zm7-2a3 3 0 0 1 3 3" /></svg></span>
                <div>
                    <h2 class="text-lg font-black text-slate-950">Nuevo operario</h2>
                    <p class="mt-1 text-sm text-slate-500">El operario podrá registrar movimientos.</p>
                </div>
            </div>

            @if ($errors->any())
                <div class="mb-6 rounded-xl border border-red-200 bg-red-50 px-4 py-3 text-sm font-semibold text-red-700">
                    Revisa los campos marcados antes de continuar.
                </div>
            @endif

            <form method="POST" action="{{ route('operators.store') }}" class="space-y-5">
                @csrf
                <div>
                    <label for="name" class="mb-2 block text-sm font-bold text-slate-700">Nombre completo</label>
                    <input id="name" type="text" name="name" value="{{ old('name') }}" required class="w-full rounded-xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm outline-none transition focus:border-blue-500 focus:bg-white focus:ring-4 focus:ring-blue-100">
                    @error('name') <p class="mt-2 text-xs font-semibold text-red-600">{{ $message }}</p> @enderror
                </div>
                <div>
                    <label for="email" class="mb-2 block text-sm font-bold text-slate-700">Correo electrónico</label>
                    <input id="email" type="email" name="email" value="{{ old('email') }}" required autocomplete="off" class="w-full rounded-xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm outline-none transition focus:border-blue-500 focus:bg-white focus:ring-4 focus:ring-blue-100">
                    @error('email') <p class="mt-2 text-xs font-semibold text-red-600">{{ $message }}</p> @enderror
                </div>
                <div>
                    <label for="password" class="mb-2 block text-sm font-bold text-slate-700">Contraseña</label>
                    <input id="password" type="password" name="password" required autocomplete="new-password" class="w-full rounded-xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm outline-none transition focus:border-blue-500 focus:bg-white focus:ring-4 focus:ring-blue-100">
                    @error('password') <p class="mt-2 text-xs font-semibold text-red-600">{{ $message }}</p> @enderror
                </div>
                <button type="submit" class="w-full rounded-xl bg-blue-600 px-5 py-3.5 text-sm font-bold text-white shadow-lg shadow-blue-600/20 transition hover:bg-blue-700 focus:outline-none focus:ring-4 focus:ring-blue-200">Crear operario</button>
            </form>
        </section>

        <section class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm sm:p-8">
            <div class="mb-6">
                <h2 class="text-lg font-black text-slate-950">Operarios de la empresa</h2>
                <p class="mt-1 text-sm text-slate-500">Cuentas con acceso al módulo de movimientos.</p>
            </div>
            <div class="space-y-3">
                @forelse ($operators as $operator)
                    <div class="flex items-center justify-between gap-4 rounded-xl border border-slate-100 bg-slate-50/70 p-4">
                        <div class="flex min-w-0 items-center gap-3">
                            <span class="flex size-10 shrink-0 items-center justify-center rounded-full bg-blue-500/20 text-sm font-bold text-blue-600">{{ str($operator->name)->substr(0, 1)->upper() }}</span>
                            <div class="min-w-0">
                                <p class="truncate text-sm font-bold text-slate-800">{{ $operator->name }}</p>
                                <p class="mt-1 truncate text-xs text-slate-500">{{ $operator->email }}</p>
                            </div>
                        </div>
                        <form method="POST" action="{{ route('operators.destroy', $operator) }}" onsubmit="return confirm('¿Eliminar a {{ $operator->name }}?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="shrink-0 rounded-lg border border-red-200 px-3 py-2 text-xs font-bold text-red-600 transition hover:bg-red-50">Eliminar</button>
                        </form>
                    </div>
                @empty
                    <div class="rounded-xl border border-dashed border-slate-200 px-5 py-14 text-center">
                        <p class="font-bold text-slate-700">Sin operarios todavía</p>
                        <p class="mt-1 text-sm text-slate-500">Los operarios que crees aparecerán aquí.</p>
                    </div>
                @endforelse
            </div>
            @if ($operators->hasPages())
                <div class="mt-5 border-t border-slate-100 pt-4">{{ $operators->links() }}</div>
            @endif
        </section>
    </div>
@endsection