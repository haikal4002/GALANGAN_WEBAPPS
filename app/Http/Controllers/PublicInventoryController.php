<?php

namespace App\Http\Controllers;

use App\Models\ProductUnit;
use Illuminate\Http\Request;

class PublicInventoryController extends Controller
{
    public function index()
    {
        $units = ProductUnit::with(['masterProduct', 'masterUnit'])
            ->orderBy('updated_at', 'desc')
            ->get();

        return view('public.inventory', compact('units'));
    }
}
