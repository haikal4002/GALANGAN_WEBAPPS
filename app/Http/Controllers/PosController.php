<?php

namespace App\Http\Controllers;

use App\Models\ProductUnit;
use Illuminate\Http\Request;

class PosController extends Controller
{
    public function index()
    {
        // Ambil data produk yang stoknya > 0 dan memiliki harga jual
        // Kita format datanya agar mudah dibaca oleh Javascript (Alpine.js)
        $products = ProductUnit::with(['masterProduct', 'masterUnit'])
            ->where('stok', '>', 0)
            ->where('harga_jual', '>', 0)
            ->orderBy('updated_at', 'desc')
            ->get()
            ->map(function ($item) {
                return [
                    'id' => $item->id,
                    'name' => $item->masterProduct->nama,
                    'unit' => $item->masterUnit->nama,
                    'price' => $item->harga_jual,
                    'stock' => $item->stok,
                    // Gambar placeholder (bisa diganti nanti jika ada fitur upload gambar)
                    'image' => 'https://ui-avatars.com/api/?name=' . urlencode($item->masterProduct->nama) . '&background=random&size=128'
                ];
            });

        return view('pos.index', compact('products'));
    }
}