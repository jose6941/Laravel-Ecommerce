<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $products = Product::active()->when($request->filled('category'), fn ($q) =>
                $q->whereHas('category', fn ($c) => $c->where('slug', $request->category)))
            ->when($request->filled('q'), fn ($q) =>
                $q->where('name', 'like', "%{$request->q}%"))
            ->paginate(12)
            ->withQueryString(); // mantém os filtros ao trocar de página

        return view('products.index', compact('products'));
    }

    // Route Model Binding: o Laravel já busca o Product pelo slug pra você
    public function show(Product $product)
    {
        abort_unless($product->is_active, 404);
        $product->load('images', 'category', 'reviews');
        return view('products.show', compact('product'));
    }

    public function store(StoreProductRequest $request)
    {
        $this->authorize('create', Product::class); // usa a Policy

        $product = Product::create($request->safe()->except('images'));

        foreach ($request->file('images', []) as $index => $file) {
            $path = $file->store('products', 'public'); // salva em storage/app/public/products

            $product->images()->create([
                'path' => $path,
                'is_main' => $index === 0,
            ]);
        }

        return redirect()->route('admin.products.index')->with('success', 'Produto criado.');
    }
}
