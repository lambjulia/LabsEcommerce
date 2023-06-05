@extends('layout.master')
@section('content')
<div class="container">
  <div class="row justify-content-center">
    @foreach ($products as $p)
        <div class="col-md-3 d-flex mb-4">
                <div class="card" style="width: 18rem;">
                    <img src="{{ asset($p->images->first()->path) }}"  class="card-img-top" alt="Card Image">
                    <div class="card-body d-flex flex-column">
                        <h5 class="card-title">{{ $p->name }}</h5>
                        <h6 class="card-title">US$ {{ $p->price }}</h5>
                        <p class="card-text">{{ $p->description }}</p>
                        <a href="{{ route('product.show', $p->id) }}" class="btn btn-primary mt-auto">See More</a>
                    </div>
                </div>
            </div>
    @endforeach 
  </div>
</div>
@endsection
