<?php
namespace App\Http\Controllers;

use App\Models\Invoice;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class InvoiceController extends Controller
{
    public function index()
    {
        $invoices = \App\Models\Invoice::all();
        return \Inertia\Inertia::render('Invoice', [
            'invoices' => $invoices
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'product_name' => 'required|exists:products,name',
        ]);
        $product = Product::where('name', $validated['product_name'])->firstOrFail();
        if ($product->stock < 1) {
            return redirect()->back()->withErrors(['stock' => 'Stock empty!']);
        }
        $product->decrement('stock', 1);
        $invoice = Invoice::create([
            'invoice_number' => 'INV-' . strtoupper(Str::random(8)),
            'product_name' => $product->name,
            'quantity' => 1,
            'total_price' => $product->price,
        ]);
        return redirect()->route('invoice.index');
    }

    public function total()
    {
        $totalInvoices = \App\Models\Invoice::count();
        $totalQuantity = \App\Models\Invoice::sum('quantity');
        return response()->json([
            'total' => $totalInvoices,
            'quantity' => $totalQuantity
        ]);
    }
}
