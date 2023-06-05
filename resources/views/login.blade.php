@extends('layout.login')
@section('content')
    @if (session('client-store'))
        <script>
            Swal.fire({
                position: 'top-end',
                icon: 'success',
                title: 'User created successfully!',
                showConfirmButton: false,
                timer: 1500
            })
        </script>
    @endif
    @if (session('seller-store'))
        <script>
            Swal.fire({
                position: 'top-end',
                icon: 'success',
                title: 'Seller created successfully!',
                showConfirmButton: false,
                timer: 1500
            })
        </script>
    @endif
    @if (session('password-update'))
        <script>
            Swal.fire({
                icon: 'success',
                title: 'Successfully updated password!',
                showConfirmButton: false,
                timer: 1500
            })
        </script>
    @endif

    <body style="background-color: #dae9ea;">
        <div class="container py-5">
            <div class="row justify-content-center">
                <div class="col-12 col-md-8 col-lg-6 col-xl-5">
                    <div class="card shadow-2-strong" style="border-radius: 1rem;">
                        <div class="card-body p-5 text-center">
                            @if ($errors->any())
                                <div class="alert alert-danger">
                                    <ul>
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif
                            <form action="{{ route('authenticate') }}" method="post" role="form">
                                @csrf
                                <h3 class="mb-5">Sign in</h3>

                                <div class="form-outline mb-4">
                                    <input type="email" id="email" name="email"
                                        class="form-control form-control-lg" />
                                    <label class="form-label" for="email">Email</label>
                                </div>

                                <div class="form-outline mb-4">
                                    <input type="password" id="password" name="password"
                                        class="form-control form-control-lg" />
                                    <label class="form-label" for="password-2">Password</label>
                                </div>

                                <button class="btn btn-primary btn-lg btn-block" type="submit">Login</button>

                                <hr class="my-4">

                                <a class="btn btn-primary" href="{{ route('client.create') }}" role="button">Sign Up as
                                    Client</a>
                                <a class="btn btn-primary" href="{{ route('seller.create') }}" role="button">Sign Up as
                                    Seller</a>
                                <div class="form-group">
                                    <label>
                                        <a href="{{ route('forget.password.get') }}">Reset Password</a>
                                    </label>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </body>
@endsection
