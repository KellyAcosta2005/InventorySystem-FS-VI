@extends('layouts.app')

@section('title', 'Nuevo producto | Depósito KANG')

@section('content')
    <div class="mb-8">
        <a href="{{ route('products.index') }}" class="text-sm font-bold text-blue-700 hover:text-blue-800">← Volver a productos</a>
        <p class="mt-6 text-sm font-bold uppercase tracking-[0.18em] text-blue-600">Catálogo</p>
        <h1 class="mt-2 text-3xl font-black tracking-tight text-slate-950">Nuevo producto</h1>
        <p class="mt-2 text-slate-500">Completa la información para agregar un producto al inventario.</p>
    </div>

    <section class="max-w-3xl rounded-2xl border border-slate-200 bg-white p-6 shadow-sm sm:p-8">
        <form method="POST" action="{{ route('products.store') }}">
            @include('products._form')
        </form>
    </section>
@endsection