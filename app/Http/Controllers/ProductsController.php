<?php

namespace App\Http\Controllers;

use App\Models\ProductImages;
use Illuminate\Http\Request;
use App\Models\Products;
use App\Models\Client;
use App\Models\ClientFavorites;
use App\Models\ProductReview;
use Illuminate\Support\Facades\Auth;
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
        $review = ProductReview::where('products_id', '=', $id)->get();
        $products->increment('views');
        $user = Auth::user();

        return view('products.product-show', compact('products', 'images', 'user', 'review'));
    }

    public function review($id)
    {
        $products = Products::find($id);
        $user = Auth::user();
        return view('products.review', compact('products', 'user'));
    }

    public function reviewStore(Request $request, $id)
    {

        $request->validate([
            'note' => 'required|numeric|min:1|max:5',
            'comment' => 'required|string|max:255',
        ]);

        $productId = $id;
        $userId = Auth::id();
        $user = User::find($userId);
        $clientId = $user->client->id;

        $review = new ProductReview();
        $review->products_id = $productId;
        $review->client_id = $clientId;
        $review->note = $request->note;
        $review->comment = $request->comment;

        $review->save();

        return redirect()->route('product.show', $id)->with('review-store', '402');
    }

    public function favorite($id)
    {
        $produtoId = $id;
        $userId = Auth::id();
        $user = User::find($userId);
        $clientId = $user->client->id;

        $favorite = new ClientFavorites();
        $favorite->products_id = $produtoId;
        $favorite->client_id = $clientId;

        $favorite->save();

        return redirect()->route('product.show', $id)->with('favorite', '402');
    }

    public function deleteFavorite($id)
    {
        $userId = Auth::id();
        $user = User::find($userId);

        $produtoId = $id;

        $favorite = $user->client->favorite()->where('products_id', $produtoId)->first();

        $favorite->delete();

        return redirect()->back()->with('favorite-delete', '402');
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

    public function destroyImage($id)
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

        $userId = Auth::id();
        $user = User::find($userId);

        if ($user = Auth::user()) {
            if ($user->role == 'seller') {
                $sellerId = $user->seller->id;

                $query->where('seller_id', $sellerId);
            }
        }

        $products = $query->get();

        if ($request->sort_by == 'lowest_price') {
            $products = $query->orderBy('price', 'asc')->get();
        }
        if ($request->sort_by == 'highest_price') {
            $products = $query->orderBy('price', 'desc')->get();
        }

        return view('products.products-all', compact('products', 'user'))->render();
    }
}
