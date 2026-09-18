@extends('layouts.app')

@section('title', 'Movimientos | Depósito KANG')

@section('content')
    <div class="mb-8">
        <p class="mb-2 text-sm font-bold uppercase tracking-[0.18em] text-blue-600">Operación</p>
        <h1 class="text-3xl font-black tracking-tight text-slate-950">Movimientos</h1>
        <p class="mt-2 text-slate-500">Registra entradas y salidas para mantener actualizado el stock.</p>
    </div>

    <div class="grid gap-6 xl:grid-cols-[minmax(0,0.85fr)_minmax(0,1.15fr)]">
        <section class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm sm:p-8">
            <div class="mb-6 flex items-start gap-4">
                <span class="flex size-11 items-center justify-center rounded-xl bg-blue-50 text-blue-700"><svg aria-hidden="true" class="size-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8"><path stroke-linecap="round" stroke-linejoin="round" d="M8 5v14m0 0-3-3m3 3 3-3M16 19V5m0 0 3 3m-3-3-3 3" /></svg></span>
                <div>
                    <h2 class="text-lg font-black text-slate-950">Registrar movimiento</h2>
                    <p class="mt-1 text-sm text-slate-500">Los cambios se aplican al stock al guardar.</p>
                </div>
            </div>

            @if ($errors->any())
                <div class="mb-6 rounded-xl border border-red-200 bg-red-50 px-4 py-3 text-sm font-semibold text-red-700">
                    Revisa los campos marcados antes de continuar.
                </div>
            @endif

            <form method="POST" action="{{ route('movements.store') }}" class="space-y-5">
                @csrf
                <div>
                    <label for="product_id" class="mb-2 block text-sm font-bold text-slate-700">Producto</label>
                    <select id="product_id" name="product_id" required class="w-full rounded-xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm outline-none transition focus:border-blue-500 focus:bg-white focus:ring-4 focus:ring-blue-100">
                        @foreach ($products as $product)
                            <option value="{{ $product->id }}" @selected(old('product_id') == $product->id)>{{ $product->name }} · {{ $product->stock }} disponibles</option>
                        @endforeach
                    </select>
                    @error('product_id') <p class="mt-2 text-xs font-semibold text-red-600">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label for="type" class="mb-2 block text-sm font-bold text-slate-700">Tipo de movimiento</label>
                    <select id="type" name="type" required class="w-full rounded-xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm outline-none transition focus:border-blue-500 focus:bg-white focus:ring-4 focus:ring-blue-100">
                        <option value="entrada" @selected(old('type', 'entrada') === 'entrada')>Entrada de stock</option>
                        <option value="salida" @selected(old('type') === 'salida')>Salida de stock</option>
                    </select>
                    @error('type') <p class="mt-2 text-xs font-semibold text-red-600">{{ $message }}</p> @enderror
                </div>

                <div class="grid gap-5 sm:grid-cols-2">
                    <div>
                        <label for="quantity" class="mb-2 block text-sm font-bold text-slate-700">Cantidad</label>
                        <input id="quantity" type="number" name="quantity" value="{{ old('quantity') }}" min="1" required class="w-full rounded-xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm outline-none transition focus:border-blue-500 focus:bg-white focus:ring-4 focus:ring-blue-100">
                        @error('quantity') <p class="mt-2 text-xs font-semibold text-red-600">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label for="moved_at" class="mb-2 block text-sm font-bold text-slate-700">Fecha y hora</label>
                        <input id="moved_at" type="datetime-local" name="moved_at" value="{{ old('moved_at', now()->format('Y-m-d\TH:i')) }}" required class="w-full rounded-xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm outline-none transition focus:border-blue-500 focus:bg-white focus:ring-4 focus:ring-blue-100">
                        @error('moved_at') <p class="mt-2 text-xs font-semibold text-red-600">{{ $message }}</p> @enderror
                    </div>
                </div>

                <div>
                    <label for="supplier" class="mb-2 block text-sm font-bold text-slate-700">Proveedor <span class="font-normal text-slate-400">(para entradas)</span></label>
                    <input id="supplier" name="supplier" value="{{ old('supplier') }}" placeholder="Nombre del proveedor" class="w-full rounded-xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm outline-none transition placeholder:text-slate-400 focus:border-blue-500 focus:bg-white focus:ring-4 focus:ring-blue-100">
                    @error('supplier') <p class="mt-2 text-xs font-semibold text-red-600">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label for="reason" class="mb-2 block text-sm font-bold text-slate-700">Motivo <span class="font-normal text-slate-400">(para salidas)</span></label>
                    <input id="reason" name="reason" value="{{ old('reason') }}" placeholder="Ej. Venta, ajuste o traslado" class="w-full rounded-xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm outline-none transition placeholder:text-slate-400 focus:border-blue-500 focus:bg-white focus:ring-4 focus:ring-blue-100">
                    @error('reason') <p class="mt-2 text-xs font-semibold text-red-600">{{ $message }}</p> @enderror
                </div>

                <button type="submit" class="w-full rounded-xl bg-blue-600 px-5 py-3.5 text-sm font-bold text-white shadow-lg shadow-blue-600/20 transition hover:bg-blue-700 focus:outline-none focus:ring-4 focus:ring-blue-200">Registrar movimiento</button>
            </form>
        </section>

        <section class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm sm:p-8">
            <div class="mb-6">
                <h2 class="text-lg font-black text-slate-950">Historial reciente</h2>
                <p class="mt-1 text-sm text-slate-500">Últimas operaciones registradas.</p>
            </div>
            <div class="space-y-3">
                @forelse ($movements as $movement)
                    <div class="flex items-center justify-between gap-4 rounded-xl border border-slate-100 bg-slate-50/70 p-4">
                        <div class="flex min-w-0 items-center gap-3">
                            <span class="flex size-10 shrink-0 items-center justify-center rounded-xl {{ $movement->type === 'entrada' ? 'bg-emerald-100 text-emerald-700' : 'bg-orange-100 text-orange-700' }} text-lg font-black">{{ $movement->type === 'entrada' ? '+' : '-' }}</span>
                            <div class="min-w-0">
                                <p class="truncate text-sm font-bold text-slate-800">{{ $movement->product->name }}</p>
                                <p class="mt-1 text-xs text-slate-500">{{ ucfirst($movement->type) }} · {{ $movement->moved_at->format('d/m/Y H:i') }}</p>
                            </div>
                        </div>
                        <span class="shrink-0 text-sm font-black {{ $movement->type === 'entrada' ? 'text-emerald-700' : 'text-orange-700' }}">{{ $movement->quantity }} uds.</span>
                    </div>
                @empty
                    <div class="rounded-xl border border-dashed border-slate-200 px-5 py-14 text-center">
                        <p class="font-bold text-slate-700">Sin movimientos todavía</p>
                        <p class="mt-1 text-sm text-slate-500">Las operaciones que registres aparecerán aquí.</p>
                    </div>
                @endforelse
            </div>
            @if ($movements->hasPages())
                <div class="mt-5 border-t border-slate-100 pt-4">{{ $movements->links() }}</div>
            @endif
        </section>
    </div>
@endsection