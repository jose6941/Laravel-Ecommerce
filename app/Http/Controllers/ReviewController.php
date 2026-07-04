<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ReviewController extends Controller
{
    public function store(StoreReviewRequest $request, Product $product)
    {
        $product->reviews()->create([
            'user_id' => Auth::id(),
            'rating' => $request->rating,
            'comment' => $request->comment,
        ]);

        return back()->with('success', 'Avaliação enviada! Ela aparecerá após moderação.');
    }
}

Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/', [AdminDashboardController::class, 'index'])->name('dashboard');
    Route::resource('produtos', AdminProductController::class)->names('products');
    Route::resource('categorias', AdminCategoryController::class)->names('categories');
    Route::get('pedidos', [AdminOrderController::class, 'index'])->name('orders.index');
    Route::patch('pedidos/{order}/status', [AdminOrderController::class, 'updateStatus'])->name('orders.update-status');
});
