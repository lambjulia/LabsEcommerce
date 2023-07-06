@extends('layout.login')
@section('content')
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        Register now to became a client
                    </div>
                    <div class="card-body">
                        <form action="{{ route('client.store') }}" method="post" role="form">
                            @csrf
                            <div class="row g-3">
                                <div class="col-6">
                                    <input type="text" id="name" name="name"
                                        class="form-control @error('name') is-invalid @enderror"
                                        value="{{ old('name') }}" placeholder="Full Name">
                                    @error('name')
                                        <div class="alert-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-6">
                                    <input type="text" id="cpf" name="cpf"
                                        class="form-control @error('cpf') is-invalid @enderror"
                                        value="{{ old('cpf') }}" placeholder="CPF">
                                    @error('cpf')
                                        <div class="alert-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-6">
                                    <label for="birth" class="form-label">Date of Birth</label>
                                    <input type="date" id="birth" name="birth"
                                        class="form-control @error('birth') is-invalid @enderror"
                                        value="{{ old('birth') }}" placeholder="Birth">
                                    @error('birth')
                                        <div class="alert-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                                <hr>
                                <div class="form-group">
                                    <label for="endereco" class="control-label">Address:</label>
                                </div>
                                <div class="col-6">
                                    <input type="text" id="state" name="state"
                                        class="form-control @error('state') is-invalid @enderror"
                                        value="{{ old('state') }}" placeholder="State">
                                    @error('state')
                                        <div class="alert-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-6">
                                    <input type="text" id="city" name="city"
                                        class="form-control @error('city') is-invalid @enderror"
                                        value="{{ old('city') }}" placeholder="City">
                                    @error('city')
                                        <div class="alert-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                                <hr>
                                <div class="form-group">
                                    <label for="endereco" class="control-label">Login Data:</label>
                                </div>
                                <div class="col-6">
                                    <input type="text" id="email" name="email"
                                        class="form-control @error('email') is-invalid @enderror"
                                        value="{{ old('email') }}" placeholder="Email">
                                    @error('email')
                                        <div class="alert-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-6">
                                    <input type="password" id="password" name="password"
                                        class="form-control @error('password') is-invalid @enderror" placeholder="Password">
                                    @error('password')
                                        <div class="alert-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <br>
                            <div class="card-footer">
                                <button type="submit" class="btn btn-primary">Save</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
