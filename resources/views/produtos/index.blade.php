@extends('layouts.app')

@section('content')
    @foreach ($products as $product)
        <a href="{{ route('products.show', $product) }}">
            {{ $product->name }} — R$ {{ number_format($product->final_price, 2, ',', '.') }}
        </a>
    @endforeach

    {{ $products->links() }} 
@endsection