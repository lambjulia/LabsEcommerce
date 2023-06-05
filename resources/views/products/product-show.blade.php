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
                                    <img src="{{ asset($i->path) }}" class="mx-auto d-block w-100 card-img" alt="...">
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
            <div class="col-sm-6">
              <div class="card">
                <div class="card-body">
                    <h5 class="card-title">{{ $products->name }}</h5>
                    <h6 class="card-title">US$ {{ $products->price }}</h5>
                        <p class="card-text">{{ $products->description }}</p>
                        <p class="card-text">Category: {{ $products->category }}</p>
                        <form action="{{ route('purchase', ['product' => $products->id]) }}" method="POST">
                            @csrf
                            <button type="submit" class="btn btn-primary mt-auto btn-lg">Comprar</button>
                        </form>
                        <p class="card-text">Sold by: {{ $products->seller->user->name }}</p>
                </div>
              </div>
            </div>
          </div>
    </div>
@endsection
