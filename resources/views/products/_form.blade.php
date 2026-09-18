@csrf
@if ($product->exists)
    @method('PUT')
@endif

<label>Nombre
    <input name="name" value="{{ old('name', $product->name) }}" required>
</label>
@error('name')
    <p class="error">{{ $message }}</p>
@enderror

<label>SKU
    <input name="sku" value="{{ old('sku', $product->sku) }}" required>
</label>
@error('sku')
    <p class="error">{{ $message }}</p>
@enderror

<label>Categoría
    <input name="category" value="{{ old('category', $product->category) }}" required>
</label>
@error('category')
    <p class="error">{{ $message }}</p>
@enderror

<label>Descripción
    <textarea name="description">{{ old('description', $product->description) }}</textarea>
</label>
@error('description')
    <p class="error">{{ $message }}</p>
@enderror

<button type="submit">{{ $product->exists ? 'Actualizar' : 'Guardar' }}</button>