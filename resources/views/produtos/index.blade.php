@extends('layouts.app')

@section('content')
    @foreach ($produtos as $produto)
        <a href="{{ route('produtos.show', $produto) }}">
            {{ $produto->nome }} — R$ {{ number_format($produto->preco_final, 2, ',', '.') }}
        </a>
    @endforeach

    {{ $produtos->links() }} 
@endsection