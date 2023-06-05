<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Seller;
use App\Models\ClientPurchases;
use App\Models\ProductImages;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rules\Password;
use Illuminate\Support\Facades\Validator;

class SellerController extends Controller
{
    public function create()
    {
        return view('seller.seller-create');
    }

    public function store(Request $request)
    {
        $request->validate(
            [
                'name' => 'required',
                'email' => 'required|unique:users|email',
                'password' => ['required', Password::min(8)
                    ->letters()
                    ->numbers()],
            ],
            [
                'required' => 'This field is required.',
                'email.unique' => 'The email has already been taken.',
                'email' => 'This email is not valid.',
            ]
        );

        $user = User::create([
            'name' => $request->get('name'),
            'email' => $request->get('email'),
            'role' => 'seller',
            'password' => Hash::make($request->password),
        ]);

        Seller::create([
            'user_id' => $user->id,
            'status' => 'pending',
            'credit' => 0,
        ]);

        return redirect()->route('login')->with('seller-store', '402');
    }

    public function edit()
    {
        $user = Auth::user();
        $userId = auth()->user()->id;
        $seller = Seller::where('user_id', $userId)->first();

        return view('seller.seller-edit', compact('seller', 'user'));
    }

    public function update(Request $request)
    {
        $userId = auth()->user()->id;

        $user = User::find($userId);

        $validator = Validator::make($request->all(),
            [
                'name' => 'required',
                'email' => 'required|email|unique:users,email,' . $user->id,
                'password' => [Password::min(8)
                    ->letters()
                    ->numbers()],
            ],
            [
                'required' => 'This field is required.',
                'email.unique' => 'The email has already been taken.',
                'email' => 'This email is not valid.',
            ]
        );

        $user->name = $request->input('name');
        $user->email = $request->input('email');
        $user->password = $request->input('password');
        $user->save();

        return redirect()->back()->with('seller-update', '402');
    }

    public function sold()
    {

        $userId = Auth::id();
        $user = User::find($userId);

        $seller_id = $user->seller->id;
        $products = ClientPurchases::where('seller_id', '=', $seller_id)->get();
        $images = ProductImages::all();

        return view('seller.sold', compact('products', 'images', 'user'));
    }
}
