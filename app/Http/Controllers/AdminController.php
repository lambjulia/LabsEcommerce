<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Products;
use App\Models\Seller;
use App\Models\Client;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    public function products()
    {
        $products = Products::all();
        $user = Auth::user();

        return view('admin.products', compact('products', 'user'));
    }

    public function sellers()
    {
        $sellers = Seller::all();
        $user = Auth::user();

        return view('admin.sellers', compact('sellers', 'user'));
    }

    public function clients()
    {
        $clients = Client::all();
        $user = Auth::user();

        return view('admin.clients', compact('clients', 'user'));
    }

    public function sellerStatus(Request $request)
    {
        $id = $request->input('seller_id');
        $newStatus = $request->input('new_status');

        $seller = Seller::find($id);
        $seller->status = $newStatus;
        $seller->save();

        return response()->json(['success' => true]);
    }
}
