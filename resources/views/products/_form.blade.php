@csrf
@if ($product->exists)
    @method('PUT')
@endif

<div class="grid gap-5 sm:grid-cols-2">
    <div class="sm:col-span-2">
        <label for="name" class="mb-2 block text-sm font-bold text-slate-700">Nombre del producto</label>
        <input id="name" name="name" value="{{ old('name', $product->name) }}" required class="w-full rounded-xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm outline-none transition placeholder:text-slate-400 focus:border-blue-500 focus:bg-white focus:ring-4 focus:ring-blue-100">
        @error('name') <p class="mt-2 text-xs font-semibold text-red-600">{{ $message }}</p> @enderror
    </div>

    <div>
        <label for="sku" class="mb-2 block text-sm font-bold text-slate-700">SKU</label>
        <input id="sku" name="sku" value="{{ old('sku', $product->sku) }}" required class="w-full rounded-xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm outline-none transition placeholder:text-slate-400 focus:border-blue-500 focus:bg-white focus:ring-4 focus:ring-blue-100">
        @error('sku') <p class="mt-2 text-xs font-semibold text-red-600">{{ $message }}</p> @enderror
    </div>

    <div>
        <label for="category" class="mb-2 block text-sm font-bold text-slate-700">Categoría</label>
        <input id="category" name="category" value="{{ old('category', $product->category) }}" required class="w-full rounded-xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm outline-none transition placeholder:text-slate-400 focus:border-blue-500 focus:bg-white focus:ring-4 focus:ring-blue-100">
        @error('category') <p class="mt-2 text-xs font-semibold text-red-600">{{ $message }}</p> @enderror
    </div>

    <div class="sm:col-span-2">
        <label for="description" class="mb-2 block text-sm font-bold text-slate-700">Descripción <span class="font-normal text-slate-400">(opcional)</span></label>
        <textarea id="description" name="description" rows="4" class="w-full resize-y rounded-xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm outline-none transition placeholder:text-slate-400 focus:border-blue-500 focus:bg-white focus:ring-4 focus:ring-blue-100">{{ old('description', $product->description) }}</textarea>
        @error('description') <p class="mt-2 text-xs font-semibold text-red-600">{{ $message }}</p> @enderror
    </div>
</div>

<div class="mt-7 flex flex-col-reverse gap-3 border-t border-slate-100 pt-6 sm:flex-row sm:justify-end">
    <a href="{{ route('products.index') }}" class="rounded-xl border border-slate-200 px-5 py-3 text-center text-sm font-bold text-slate-600 transition hover:bg-slate-50">Cancelar</a>
    <button type="submit" class="rounded-xl bg-blue-600 px-5 py-3 text-sm font-bold text-white shadow-lg shadow-blue-600/20 transition hover:bg-blue-700 focus:outline-none focus:ring-4 focus:ring-blue-200">{{ $product->exists ? 'Guardar cambios' : 'Crear producto' }}</button>
</div>