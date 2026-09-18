@extends('layouts.app')

@section('content')
    <form method="POST" action="{{ route('movements.store') }}">
        @csrf
        <select name="product_id" required>
            @foreach ($products as $product)
                <option value="{{ $product->id }}">
                    {{ $product->name }} - Stock: {{ $product->stock }}
                </option>
            @endforeach
        </select>

        <select name="type" required>
            <option value="entrada">Entrada</option>
            <option value="salida">Salida</option>
        </select>

        <input type="number" name="quantity" min="1" required>
        <input name="supplier" placeholder="Proveedor para entradas">
        <input name="reason" placeholder="Motivo para salidas">
        
        <!-- Aquí agregamos el valor por defecto con la fecha y hora actual -->
        <input type="datetime-local" name="moved_at" value="{{ now()->format('Y-m-d\TH:i') }}" required>
        
        <button type="submit">Registrar movimiento</button>
    </form>

    @error('quantity')
        <p class="error">{{ $message }}</p>
    @enderror

    @foreach ($movements as $movement)
        <p>
            {{ $movement->moved_at->format('d/m/Y H:i') }} -
            {{ ucfirst($movement->type) }} de {{ $movement->quantity }} -
            {{ $movement->product->name }}
        </p>
    @endforeach
@endsection