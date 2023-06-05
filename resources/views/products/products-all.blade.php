@extends('layout.master')
@section('content')
    @if (session('login'))
        <script>
            Swal.fire({
                position: 'top-end',
                icon: 'success',
                title: 'You are logged in',
                showConfirmButton: false,
                timer: 1500
            })
        </script>
    @endif
    @if (session('denied'))
        <script>
            Swal.fire({
                position: 'top-end',
                icon: 'error',
                title: 'You are not allowed in this page',
                showConfirmButton: false,
                timer: 1500
            })
        </script>
    @endif
    @if (session('logout'))
        <script>
            Swal.fire({
                position: 'top-end',
                title: 'You are logged out',
                showConfirmButton: false,
                timer: 1500
            })
        </script>
    @endif
    @if (session('client-verification'))
        <script>
            Swal.fire({
                icon: 'success',
                title: 'Your email has been verified and you have earned 10000 credits!',
                showConfirmButton: false,
                timer: 2500
            })
        </script>
    @endif
    @if (auth()->check() && auth()->user()->role === 'seller' && Auth::user()->seller->status === 'pending')
        <h1 class="text-center">You haven't been approved yet.</h1>
    @elseif (auth()->check() && auth()->user()->role === 'seller' && Auth::user()->seller->status === 'denied')
        <h1 class="text-center">Your request to be a seller was denied.</h1>
    @else
        <div class="container">
            <div class="d-flex mb-4">
                <div class="card mx-auto">
                    <div class="card-body">
                        <form action="{{ route('product.filter') }}" method="GET">
                            <h6>Search</h6>
                            <div class="row">
                                <div class="col">
                                    <select name="sort_by" id="sort_by" class="form-control">
                                        <option value="">Sort By</option>
                                        <option value="highest_price">Highest Price</option>
                                        <option value="lowest_price">Lowest Price</option>
                                    </select>
                                </div>
                                <div class="col">
                                    <input class="form-control" type="text" name="name" id="name"
                                        value="{{ request('name') }}" placeholder="Name">
                                </div>
                                <div class="col">
                                        <input class="form-control" type="text" name="category" id="category"
                                            value="{{ request('category') }}" placeholder="Category">
                                </div>
                                <div class="col">
                                    <button type="submit" class="btn btn-primary mt-auto">Filter</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <div class="container">
            <div class="row justify-content-center">
                @foreach ($products as $p)
                    <div class="col-md-3 d-flex mb-4">
                        <div class="card" style="width: 18rem;">
                            <img src="{{ asset($p->images->first()->path) }}" class="mx-auto d-block w-100 card-img-top"
                                alt="Card Image">
                            <div class="card-body d-flex flex-column">
                                <h5 class="card-title">{{ $p->name }}</h5>
                                <h6 class="card-title">US$ {{ $p->price }}</h5>
                                    <p class="card-text">{{ $p->description }}</p>
                                    <a href="{{ route('product.show', $p->id) }}" class="btn btn-primary mt-auto">See
                                        More</a>

                                    @if (auth()->check() && auth()->user()->role === 'seller')
                                        <hr>
                                        <a href="{{ route('product.edit', $p->id) }}"
                                            class="btn btn-primary mt-auto">Edit</a>
                                    @endif
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    @endif
@endsection
