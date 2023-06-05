<?php

namespace App\Http\Controllers;

use App\Models\ProductImages;
use Illuminate\Http\Request;
use App\Models\Products;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use GuzzleHttp\Client;
use App\Models\User;
use Illuminate\Http\RedirectResponse;

class ProductsController extends Controller
{
    public function productsAll()
    {
        $userId = Auth::id();
        $user = User::find($userId);

        $products = Products::all();
        $images = ProductImages::all();

        if ($user = Auth::user()) {
            if ($user->role == 'seller') {
                $sellerId = $user->seller->id;
                $products = Products::where('seller_id', '=', $sellerId)->get();
                $images = ProductImages::all();
            }
        }

        return view('products.products-all', compact('products', 'images', 'user'));
    }

    public function product($category)
    {
        $products = Products::where('category', '=', $category)->get();
        $user = Auth::user();

        return view('products.product', compact('products', 'user'));
    }

    public function productShow($id)
    {
        $products = Products::find($id);
        $images = ProductImages::where('products_id', '=', $id)->get();
        $user = Auth::user();

        return view('products.product-show', compact('products', 'images', 'user'));
    }

    public function create()
    {
        $user = Auth::user();
        return view('products.product-create', compact('user'));
    }

    public function store(Request $request)
    {
        $userId = Auth::id();
        $user = User::find($userId);
        $sellerId = $user->seller->id;

        $request->validate(
            [
                'name' => 'required',
                'description' => 'required',
                'price' => 'required',
                'category' => 'required',
                'image' => 'required|array|max:3',
                'image.*' => 'mimes:jpeg,png,jpg',
            ],
            [
                'required' => 'This field is required.',
                'image.max' => 'You can include a maximum of 3 images.',
            ],
        );

        $product = Products::create([
            'seller_id' => $sellerId,
            'name' => $request->get('name'),
            'description' => $request->get('description'),
            'price' => $request->get('price'),
            'category' => $request->get('category'),
        ]);

        if ($request->hasFile('image')) {
            $images = $request->file('image');

            foreach ($images as $image) {
                $fileName = uniqid() . '.jpg';
                $path = $image->storeAs('public/images',  $fileName);
                $path = 'storage/images/' . $fileName;
                $image = new ProductImages();
                $image->image = $fileName;
                $image->path = $path;
                $image->products_id = $product->id;
                $image->save();
            }
        }



        return redirect()->back()->with('product-store', '402');
    }

    public function edit($id)

    {
        $products = Products::find($id);
        $images = ProductImages::where('products_id', '=', $id)->get();
        $user = Auth::user();

        return view('products.product-edit', compact('products', 'images', 'user'));
    }

    private function jsonWithRedirectBack(array $response): RedirectResponse
    {
        return redirect()->back()->withInput()->with('jsonResponse', $response)->with('product-update', '402');
    }

    public function update(Request $request, $id)
    {
        $request->validate(
            [
                'name' => 'required',
                'description' => 'required',
                'price' => 'required',
                'category' => 'required',
            ],
            [
                'required' => 'This field is required.',
            ],
        );

        $product = Products::find($id);
        $product->name = $request->input('name');
        $product->description = $request->input('description');
        $product->price = $request->input('price');
        $product->category = $request->input('category');
        $product->save();

        $quantidade = 1;

        if ($quantidade >= 1) {

            if ($request->hasFile('image')) {
                $images = $request->file('image');

                foreach ($images as $image) {
                    $fileName = uniqid() . '.jpg';
                    $path = $image->storeAs('public/images',  $fileName);
                    $path = 'storage/images/' . $fileName;
                    $image = new ProductImages();
                    $image->image = $fileName;
                    $image->path = $path;
                    $image->products_id = $product->id;
                    $image->save();

                    $response = [];
                    return $this->jsonWithRedirectBack($response);
                }
            }
        }

        return redirect()->back()->with('product-update', '402');
    }

    public function destroy($id)
    {
        $imagem = ProductImages::findOrFail($id);

        $imagem->delete();


        return redirect()->back();
    }

    public function filter(Request $request)
    {
        $query = Products::query();

        if ($request->filled('name')) {
            $name = $request->name;
            $query->where('name', 'like', "%$name%");
        }

        if ($request->filled('category')) {
            $category = $request->category;
            $query->where('category', $category);
        }

        $products = $query->get();

        if ($request->sort_by == 'lowest_price') {
            $products = Products::orderBy('price', 'asc')->get();
        }
        if ($request->sort_by == 'highest_price') {
            $products = Products::orderBy('price', 'desc')->get();
        }

        $userId = Auth::id();
        $user = User::find($userId);

        if ($user = Auth::user()) {
            if ($user->role == 'seller') {
                $sellerId = $user->seller->id;

                $query = Products::query();

                if ($request->filled('name')) {
                    $name = $request->name;
                    $query->where('name', 'like', "%$name%")->where('seller_id', '=', $sellerId);
                }

                if ($request->filled('category')) {
                    $category = $request->category;
                    $query->where('category', $category)->where('seller_id', '=', $sellerId);
                }

                $products = $query->get();

                if ($request->sort_by == 'lowest_price') {
                    $products = Products::where('seller_id', '=', $sellerId)->orderBy('price', 'asc')->get();
                }
                if ($request->sort_by == 'highest_price') {
                    $products = Products::where('seller_id', '=', $sellerId)->orderBy('price', 'desc')->get();
                }
            }
        }

        return view('products.products-all', compact('products', 'user'))->render();
    }
}
