@extends('layout.master')
@section('content')
@if (session('seller-update'))
<script>
    Swal.fire({
        position: 'top-end',
        icon: 'success',
        title: 'Your data has been successfully updated!',
        showConfirmButton: false,
        timer: 1500
    })
</script>
@endif
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        Edit your profile
                    </div>
                    <div class="card-body">
                        <form action="{{ route('seller.update') }}" method="post" role="form">
                            @csrf
                            <div class="row g-3">
                                <div class="col-6">
                                    <input type="text" id="name" name="name"
                                        class="form-control @error('name') is-invalid @enderror" placeholder="Full Name"
                                        value="{{ $seller->user->name }}">
                                    @error('name')
                                        <div class="alert-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-6">
                                    <input type="text" id="email" name="email"
                                        class="form-control @error('email') is-invalid @enderror" placeholder="Email"
                                        value="{{ $seller->user->email }}">
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
                                <button type="submit" class="btn btn-primary">Cadastrar</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
