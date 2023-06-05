@extends('layout.master')
@section('content')
<div class="container">
    <div class="d-flex mb-4">
        <div class="card mx-auto">
            <div class="card-body flex-column">
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
                        <img src="{{ asset($p->product->images->first()->path) }}" class="mx-auto d-block w-100 card-img-top" alt="Card Image">
                        <div class="card-body d-flex flex-column">
                            <h5 class="card-title">{{ $p->product->name }}</h5>
                            <h6 class="card-title">US$ {{ $p->product->price }}</h5>
                                <p class="card-text">{{ $p->product->description }}</p>
                                <a href="{{ route('product.show', $p->product->id) }}" class="btn btn-primary mt-auto">See More</a>
                                
                                @if (auth()->check() && auth()->user()->role === 'seller')
                                <hr>
                                <a href="{{ route('product.edit', $p->id) }}" class="btn btn-primary mt-auto">Edit</a>
                                @endif
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div> 
@endsection