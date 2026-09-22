@extends('layouts.app')

@section('title', 'Iniciar sesión')

@section('content')
    <section class="rounded-3xl border border-slate-200 bg-white p-7 shadow-xl shadow-slate-200/60 sm:p-9">
        <div class="mb-8">
            <p class="mb-2 text-sm font-bold uppercase tracking-[0.18em] text-blue-600">Bienvenido de nuevo</p>
            <h1 class="text-3xl font-black tracking-tight text-slate-950">Iniciar sesión</h1>
            <p class="mt-2 text-sm leading-6 text-slate-500">Accede a tu panel de control de inventario.</p>
        </div>

        <livewire:login />
    </section>
@endsection