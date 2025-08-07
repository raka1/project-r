<?php
namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::all();
        return Inertia::render('Produksi', [
            'products' => $products
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'stock' => 'required|integer',
            'price' => 'required|numeric',
        ]);
        if (!isset($validated['stock'])) {
            $validated['stock'] = 0;
        }
        Product::create($validated);
        return redirect()->route('products.index');
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'stock' => 'required|integer',
            'price' => 'required|numeric',
        ]);
        $product = Product::findOrFail($id);
        $product->update($validated);
        return redirect()->route('products.index');
    }

    public function destroy(Request $request)
    {
        $ids = $request->input('ids');
        Product::whereIn('id', $ids)->delete();
        return redirect()->route('products.index');
    }
}
