@extends('layout.master')
@section('content')
    @if (session('purchase'))
        <script>
            Swal.fire({
                icon: 'success',
                title: 'Product purchased successfully!',
                showConfirmButton: false,
                timer: 1500
            })
        </script>
    @endif
    @if (session('review-store'))
        <script>
            Swal.fire({
                icon: 'success',
                title: 'Review sent successfully!',
                showConfirmButton: false,
                timer: 1500
            })
        </script>
    @endif
    @if (session('buy-error'))
        <script>
            Swal.fire({
                icon: 'error',
                title: 'You do not have enough credit!',
                showConfirmButton: false,
                timer: 1500
            })
        </script>
    @endif
    @if (session('favorite'))
        <script>
            Swal.fire({
                icon: 'success',
                title: 'Product added to favorites!',
                showConfirmButton: false,
                timer: 1500
            })
        </script>
    @endif
    @if (session('favorite-delete'))
    <script>
        Swal.fire({
            icon: 'success',
            title: 'Product deleted from favorites successfully!',
            showConfirmButton: false,
            timer: 1500
        })
    </script>
@endif
    <div class="container">
        <div class="row">
            <div class="col">
                <div class="card">
                    <div class="card-body">
                        <div id="productcarousel" class="carousel slide" data-bs-ride="carousel">
                            <div class="carousel-indicators">
                                <button type="button" data-bs-target="#productcarousel" data-bs-slide-to="0" class="active"
                                    aria-current="true" aria-label="Slide 1"></button>
                                <button type="button" data-bs-target="#productcarousel" data-bs-slide-to="1"
                                    aria-label="Slide 2"></button>
                                <button type="button" data-bs-target="#productcarousel" data-bs-slide-to="2"
                                    aria-label="Slide 3"></button>
                            </div>

                            <div class="carousel-inner">
                                @foreach ($images as $key => $i)
                                    <div class="carousel-item {{ $key == 0 ? 'active' : '' }}">
                                        <img src="{{ asset($i->path) }}" class="mx-auto d-block w-100 card-img"
                                            alt="...">
                                    </div>
                                @endforeach
                            </div>

                            <button class="carousel-control-prev" type="button" data-bs-target="#productcarousel"
                                data-bs-slide="prev">
                                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                <span class="visually-hidden">Previous</span>
                            </button>
                            <button class="carousel-control-next" type="button" data-bs-target="#productcarousel"
                                data-bs-slide="next">
                                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                <span class="visually-hidden">Next</span>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col">
                <div class="card">
                    <div class="card-body">
                        @if (auth()->check() &&
                                (auth()->user()->role === 'client' && Auth::user()->client->favorite->contains('products_id', $products->id)))
                            <form action="{{ route('favorite.delete', ['id' => $products->id]) }}" method="POST">
                                @method('DELETE')
                                @csrf
                                <div class="d-md-flex justify-content-md-end">
                                    <button type="submit" class="btn"><i class="bi bi-x-lg text-danger"></i> Delete
                                        from Favorites</button>
                                </div>
                            </form>
                        @elseif (auth()->check() && auth()->user()->role === 'client')
                            <form action="{{ route('favorite', ['id' => $products->id]) }}" method="POST">
                                @csrf
                                <div class="d-md-flex justify-content-md-end">
                                    <button type="submit" class="btn"><i class="bi bi-star-fill text-warning"></i> Add
                                        to Favorites</button>
                                </div>
                            </form>
                        @endif
                        <h5 class="card-title">{{ $products->name }}</h5>
                        <h6 class="card-title">US$ {{ $products->price }}</h5>
                            <p class="card-text">{{ $products->description }}</p>
                            <p class="card-text">Category: {{ $products->category }}</p>
                            <p class="card-text">Views: {{ $products->views }}</p>
                            <form action="{{ route('purchase', ['product' => $products->id]) }}" method="POST">
                                @csrf
                                <button type="submit" class="btn btn-primary mt-auto btn-lg">Comprar</button>
                            </form>
                            <p class="card-text">Sold by: {{ $products->seller->user->name }}</p>

                            @if (auth()->check() && auth()->user()->role === 'client')
                                <hr>
                                <form action="{{ route('review', ['id' => $products->id]) }}" method="GET">
                                    @csrf
                                    <button type="submit" class="btn btn-primary mt-auto btn-lg">Avaliar</button>
                                </form>
                            @endif
                    </div>
                </div>
            </div>

            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Avaliações</h5>
                        @foreach ($review as $key => $r)
                            <hr>
                            <p class="card-text"><i class="bi bi-person"></i> {{ $r->client->user->name }}</p>
                            <p class="card-text">{{ $r->comment }}</p>
                            @for ($i = 1; $i <= $r->note; $i++)
                                <i class="bi bi-star-fill text-warning"></i>
                            @endfor
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
