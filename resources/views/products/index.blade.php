@extends('layouts.app')

@section('title', 'Productos | KANG Sistema de Inventarios')

@section('content')
    <div class="mb-8 flex flex-col justify-between gap-4 sm:flex-row sm:items-end">
        <div>
            <p class="mb-2 text-sm font-bold uppercase tracking-[0.18em] text-blue-600">Catálogo</p>
            <h1 class="text-3xl font-black tracking-tight text-slate-950">Productos</h1>
            <p class="mt-2 text-slate-500">Administra los productos y consulta sus existencias.</p>
        </div>
        <a href="{{ route('products.create') }}" class="inline-flex items-center justify-center gap-2 rounded-xl bg-blue-600 px-5 py-3 text-sm font-bold text-white shadow-lg shadow-blue-600/20 transition hover:bg-blue-700 focus:outline-none focus:ring-4 focus:ring-blue-200">+ Nuevo producto</a>
    </div>

    <section class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm">
        <div class="border-b border-slate-100 p-5 sm:p-6">
            <form method="GET" class="flex flex-col gap-3 sm:flex-row">
                <label for="search" class="sr-only">Buscar productos</label>
                <input id="search" name="search" value="{{ request('search') }}" placeholder="Buscar por nombre, SKU o categoría" class="min-w-0 flex-1 rounded-xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm text-slate-900 outline-none transition placeholder:text-slate-400 focus:border-blue-500 focus:bg-white focus:ring-4 focus:ring-blue-100">
                <button type="submit" class="rounded-xl bg-slate-900 px-5 py-3 text-sm font-bold text-white transition hover:bg-blue-700 focus:outline-none focus:ring-4 focus:ring-blue-200">Buscar</button>
            </form>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full min-w-170 text-left text-sm">
                <thead class="bg-slate-50 text-xs uppercase tracking-wider text-slate-500">
                    <tr>
                        <th class="px-6 py-4 font-bold">SKU</th>
                        <th class="px-6 py-4 font-bold">Producto</th>
                        <th class="px-6 py-4 font-bold">Categoría</th>
                        <th class="px-6 py-4 font-bold">Stock</th>
                        <th class="px-6 py-4 text-right font-bold">Acciones</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse ($products as $product)
                        <tr class="transition hover:bg-blue-50/40">
                            <td class="px-6 py-4 font-mono text-xs font-bold text-blue-700">{{ $product->sku }}</td>
                            <td class="px-6 py-4 font-bold text-slate-800">{{ $product->name }}</td>
                            <td class="px-6 py-4 text-slate-500">{{ $product->category }}</td>
                            <td class="px-6 py-4"><span class="rounded-full {{ $product->stock <= 5 ? 'bg-amber-50 text-amber-700' : 'bg-emerald-50 text-emerald-700' }} px-3 py-1 text-xs font-bold">{{ $product->stock }} unidades</span></td>
                            <td class="px-6 py-4">
                                <div class="flex justify-end gap-2">
                                    <a href="{{ route('products.edit', $product) }}" class="rounded-lg border border-slate-200 px-3 py-2 text-xs font-bold text-slate-600 transition hover:border-blue-200 hover:bg-blue-50 hover:text-blue-700">Editar</a>
                                    <form method="POST" action="{{ route('products.destroy', $product) }}">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="rounded-lg border border-red-100 px-3 py-2 text-xs font-bold text-red-600 transition hover:bg-red-50">Eliminar</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-14 text-center">
                                <p class="font-bold text-slate-700">No hay productos registrados</p>
                                <p class="mt-1 text-sm text-slate-500">Crea el primer producto para comenzar.</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if ($products->hasPages())
            <div class="border-t border-slate-100 px-6 py-4">{{ $products->links() }}</div>
        @endif
    </section>
@endsection