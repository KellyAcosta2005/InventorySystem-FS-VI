@extends('layouts.app')

@section('title', 'Dashboard | Depósito KANG')

@section('content')
    <div class="mb-8 flex flex-col justify-between gap-4 sm:flex-row sm:items-end">
        <div>
            <p class="mb-2 text-sm font-bold uppercase tracking-[0.18em] text-blue-600">Resumen general</p>
            <h1 class="text-3xl font-black tracking-tight text-slate-950 sm:text-4xl">Buenos días, {{ auth()->user()->name }}</h1>
            <p class="mt-2 text-slate-500">Aquí tienes el estado actual de tu inventario.</p>
        </div>
        @if (auth()->user()->can('manage products'))
            <a href="{{ route('products.create') }}" class="inline-flex items-center justify-center gap-2 rounded-xl bg-blue-600 px-5 py-3 text-sm font-bold text-white shadow-lg shadow-blue-600/20 transition hover:bg-blue-700 focus:outline-none focus:ring-4 focus:ring-blue-200">+ Nuevo producto</a>
        @endif
    </div>

    <div class="grid gap-4 sm:grid-cols-2 xl:grid-cols-3">
        <article class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">
            <div class="mb-5 flex items-center justify-between">
                <span class="flex size-11 items-center justify-center rounded-xl bg-blue-50 text-blue-700"><svg aria-hidden="true" class="size-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8"><path stroke-linecap="round" stroke-linejoin="round" d="m4 7 8-4 8 4-8 4-8-4Zm0 0v10l8 4 8-4V7M12 11v10" /></svg></span>
                <span class="rounded-full bg-blue-50 px-3 py-1 text-xs font-bold text-blue-700">Catálogo</span>
            </div>
            <p class="text-sm font-semibold text-slate-500">Productos registrados</p>
            <p class="mt-1 text-3xl font-black tracking-tight text-slate-950">{{ number_format($productCount) }}</p>
        </article>
        <article class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">
            <div class="mb-5 flex items-center justify-between">
                <span class="flex size-11 items-center justify-center rounded-xl bg-sky-50 text-sky-700"><svg aria-hidden="true" class="size-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8"><path stroke-linecap="round" stroke-linejoin="round" d="M8 5v14m0 0-3-3m3 3 3-3M16 19V5m0 0 3 3m-3-3-3 3" /></svg></span>
                <span class="rounded-full bg-sky-50 px-3 py-1 text-xs font-bold text-sky-700">Disponible</span>
            </div>
            <p class="text-sm font-semibold text-slate-500">Unidades en stock</p>
            <p class="mt-1 text-3xl font-black tracking-tight text-slate-950">{{ number_format($totalStock) }}</p>
        </article>
        <article class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">
            <div class="mb-5 flex items-center justify-between">
                <span class="flex size-11 items-center justify-center rounded-xl bg-amber-50 text-xl text-amber-700">!</span>
                <span class="rounded-full {{ $lowStockCount > 0 ? 'bg-amber-50 text-amber-700' : 'bg-emerald-50 text-emerald-700' }} px-3 py-1 text-xs font-bold">{{ $lowStockCount > 0 ? 'Revisar' : 'En orden' }}</span>
            </div>
            <p class="text-sm font-semibold text-slate-500">Productos con stock bajo</p>
            <p class="mt-1 text-3xl font-black tracking-tight text-slate-950">{{ number_format($lowStockCount) }}</p>
        </article>
    </div>

    <div class="mt-8 grid gap-6 xl:grid-cols-[1fr_1.4fr]">
        <section class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">
            <div class="mb-5 flex items-center justify-between">
                <div>
                    <h2 class="text-lg font-black text-slate-950">Stock por categoría</h2>
                    <p class="mt-1 text-sm text-slate-500">Distribución de unidades disponibles</p>
                </div>
                <span class="rounded-lg bg-slate-100 px-2.5 py-1 text-xs font-bold text-slate-500">{{ $stockByCategory->count() }} categorías</span>
            </div>
            <div class="space-y-4">
                @forelse ($stockByCategory as $row)
                    <div>
                        <div class="mb-2 flex justify-between text-sm">
                            <span class="font-semibold text-slate-700">{{ $row->category }}</span>
                            <span class="font-bold text-slate-950">{{ number_format($row->total_stock) }}</span>
                        </div>
                        <div class="h-2 overflow-hidden rounded-full bg-slate-100">
                            <div class="h-full rounded-full bg-blue-600" style="width: {{ $totalStock > 0 ? min(100, ($row->total_stock / $totalStock) * 100) : 0 }}%"></div>
                        </div>
                    </div>
                @empty
                    <p class="rounded-xl bg-slate-50 px-4 py-8 text-center text-sm text-slate-500">Todavía no hay categorías registradas.</p>
                @endforelse
            </div>
        </section>

        <section class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">
            <div class="mb-5 flex items-center justify-between">
                <div>
                    <h2 class="text-lg font-black text-slate-950">Últimos movimientos</h2>
                    <p class="mt-1 text-sm text-slate-500">Actividad reciente del depósito</p>
                </div>
                <a href="{{ route('movements.index') }}" class="text-sm font-bold text-blue-700 hover:text-blue-800">Ver todos →</a>
            </div>
            <div class="divide-y divide-slate-100">
                @forelse ($recentMovements as $movement)
                    <div class="flex items-center justify-between gap-4 py-3 first:pt-0">
                        <div class="flex min-w-0 items-center gap-3">
                            <span class="flex size-10 shrink-0 items-center justify-center rounded-xl {{ $movement->type === 'entrada' ? 'bg-emerald-50 text-emerald-700' : 'bg-orange-50 text-orange-700' }} font-bold">{{ $movement->type === 'entrada' ? '+' : '-' }}</span>
                            <div class="min-w-0">
                                <p class="truncate text-sm font-bold text-slate-800">{{ $movement->product->name }}</p>
                                <p class="text-xs text-slate-500">{{ $movement->moved_at->format('d/m/Y H:i') }}</p>
                            </div>
                        </div>
                        <span class="shrink-0 text-sm font-black {{ $movement->type === 'entrada' ? 'text-emerald-700' : 'text-orange-700' }}">{{ $movement->type === 'entrada' ? '+' : '-' }}{{ $movement->quantity }}</span>
                    </div>
                @empty
                    <p class="rounded-xl bg-slate-50 px-4 py-8 text-center text-sm text-slate-500">Aún no hay movimientos registrados.</p>
                @endforelse
            </div>
        </section>
    </div>
@endsection