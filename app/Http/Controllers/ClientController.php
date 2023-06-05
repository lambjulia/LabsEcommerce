<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Client;
use App\Models\User;
use App\Models\Products;
use App\Models\ProductImages;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use App\Mail\EmailVerification;
use App\Http\Controllers\Controller;
use App\Models\ClientFavorites;
use App\Models\ClientPurchases;
use Carbon\Carbon;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rules\Password;
use Illuminate\Support\Facades\Validator;

class ClientController extends Controller
{

    public function create()
    {
        return view('clients.client-create');
    }

    public function store(Request $request)
    {
        $request->validate(
            [
                'name' => 'required',
                'email' => 'required|unique:users|email',
                'password' => [Password::min(8)
                    ->letters()
                    ->numbers()],
                'cpf' => 'required|cpf|unique:clients',
                'birth' => 'required|before:' . now()->subYears(18)->toDateString(),
                'state' => 'required',
                'city' => 'required',
            ],
            [
                'required' => 'This field is required.',
                'email.unique' => 'The email has already been taken.',
                'email' => 'This email is not valid.',
                'cpf' => 'This CPF is not valid.',
                'cpf.unique' => 'This CPF has already been registered.',
                'birth.before' => 'You must be at least 18 years old.',
            ]
        );

        $user = User::create([
            'name' => $request->get('name'),
            'email' => $request->get('email'),
            'role' => 'client',
            'password' => Hash::make($request->password),
        ]);

        $user->generateEmailVerificationToken();

        Mail::to($user->email)->send(new EmailVerification($user));

        Client::create([
            'user_id' => $user->id,
            'cpf' => $request->get('cpf'),
            'birth' => $request->get('birth'),
            'state' => $request->get('state'),
            'city' => $request->get('city'),
            'credit' => 0,
        ]);

        return redirect()->route('login')->with('client-store', '402');
    }

    public function verify($token)
    {
        $user = User::where('email_verification_token', $token)->first();

        if (!$user) {
            return redirect()->route('home')->with('error', 'Token inválido.');
        }

        if ($user->role === 'client') {
            $client = Client::where('user_id', $user->id)->first();

            $client->credit += 10000;
            $client->save();
        }

        $user->email_verified = true;
        $user->email_verification_token = null;
        $user->save();

        return redirect()->route('home')->with('client-verification', '402');
    }

    public function edit()
    {
        $user = Auth::user();
        $userId = auth()->user()->id;
        $client = Client::where('user_id', $userId)->first();

        return view('clients.client-edit', compact('client', 'user'));
    }

    public function update(Request $request)
    {
        $userId = auth()->user()->id;

        $user = User::find($userId);

        $validator = Validator::make(
            $request->all(),
            [
                'name' => 'required',
                'email' => 'required|email|unique:users,email,' . $user->id,
                'password' => ['required', Password::min(8)
                    ->letters()
                    ->numbers()],
                'cpf' => 'required|cpf|unique:clients,cpf,' . $user->id,
                'birth' => 'required|before:' . now()->subYears(18)->toDateString(),
                'state' => 'required',
                'city' => 'required',
            ],
            [
                'required' => 'This field is required.',
                'email.unique' => 'The email has already been taken.',
                'email' => 'This email is not valid.',
                'cpf' => 'This CPF is not valid.',
                'cpf.unique' => 'This CPF has already been registered.',
                'birth.before' => 'You must be at least 18 years old.',
            ],
        );

        $user->name = $request->input('name');
        $user->email = $request->input('email');
        $user->password = $request->input('password');
        $user->save();

        $client = Client::where('user_id', $userId)->first();
        $client->cpf = $request->input('cpf');
        $client->birth = $request->input('birth');
        $client->state = $request->input('state');
        $client->city = $request->input('city');
        $client->save();

        return redirect()->back()->with('client-update', '402');
    }

    public function showForgetPasswordForm()
    {
        return view('clients.forgot-password');
    }

    public function submitForgetPasswordForm(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:users',
        ]);

        $token = Str::random(64);

        DB::table('password_reset_tokens')->insert([
            'email' => $request->email,
            'token' => $token,
            'created_at' => Carbon::now()
        ]);

        Mail::send('clients.email-password', ['token' => $token], function ($message) use ($request) {
            $message->to($request->email);
            $message->subject('Reset Password');
        });

        return back()->with('message', 'We have e-mailed your password reset link!');
    }

    public function showResetPasswordForm($token)
    {
        return view('clients.reset-password', ['token' => $token]);
    }


    public function submitResetPasswordForm(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:users',
            'password' => ['required', Password::min(8)
                ->letters()
                ->numbers()],
            'token' => 'required'
        ]);

        $resetPassword = DB::table('password_reset_tokens')
            ->where('email', $request->email)
            ->where('token', $request->token)
            ->get();

        if (!$resetPassword) {
            return back()->with('error', 'Invalid token!');
        }

        $user = User::where('email', $request->email)->first();
        $user->password = Hash::make($request->password);
        $user->save();

        DB::table('password_reset_tokens')
            ->where('email', $request->email)
            ->delete();

        return redirect('/login')->with('password-update', '402');
    }

    public function buy(Request $request, Products $product)
    {
        $userId = auth()->user()->id;
        $client = Client::where('user_id', $userId)->first();

        $seller = $product->seller;

        if ($client->credit < $product->price) {
            return redirect()->back()->with('buy-error', '402');
        }

        $client->credit -= $product->price;
        $client->save();

        $seller->credit += $product->price;
        $seller->save();

        $purchase = new ClientPurchases();
        $purchase->client()->associate($client);
        $purchase->seller()->associate($seller);
        $purchase->product()->associate($product);
        $purchase->save();

        return redirect()->back()->with('purchase', '402');
    }

    public function purchases()
    {
        $userId = Auth::id();
        $user = User::find($userId);

        $client_id = $user->client->id;
        $products = ClientPurchases::where('client_id', '=', $client_id)->get();
        $images = ProductImages::all();

        return view('clients.my-purchases', compact('products', 'images', 'user'));
    }

    public function favorites()
    {
        $userId = Auth::id();
        $user = User::find($userId);

        $client_id = $user->client->id;
        $product = ClientFavorites::where('client_id', '=', $client_id)->get();
        $images = ProductImages::all();

        return view('clients.my-favorites', compact('product', 'images', 'user'));
    }

}
