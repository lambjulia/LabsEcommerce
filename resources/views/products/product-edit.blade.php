@extends('layout.master')
@section('content')
    @if (session('product-update'))
        <script>
            Swal.fire({
                position: 'top-end',
                icon: 'success',
                title: 'Product updated successfully!',
                showConfirmButton: false,
                timer: 1500
            })
        </script>
    @endif
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        Edit this product
                    </div>
                    <div class="card-body">
                        <form action="{{ route('product.update', $products->id) }}" method="POST"
                            enctype="multipart/form-data">
                            @csrf
                            <div class="row g-3">
                                <div class="col-6">
                                    <input type="text" id="name" name="name"
                                        class="form-control @error('name') is-invalid @enderror" placeholder="Product Name"
                                        value="{{ $products->name }}">
                                    @error('name')
                                        <div class="alert-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-6">
                                    <input type="text" id="description" name="description"
                                        class="form-control @error('description') is-invalid @enderror"
                                        placeholder="Description" value="{{ $products->description }}">
                                    @error('description')
                                        <div class="alert-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-6">
                                    <input type="number" id="price" name="price"
                                        class="form-control @error('price') is-invalid @enderror" placeholder="Price"
                                        value="{{ $products->price }}">
                                    @error('price')
                                        <div class="alert-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-6">
                                    <input type="text" id="category" name="category"
                                        class="form-control @error('category') is-invalid @enderror" placeholder="Category"
                                        value="{{ $products->category }}">
                                    @error('category')
                                        <div class="alert-danger">{{ $message }}</div>
                                    @enderror
                                </div>

                                @if (count($products->images) < 3)
                                    <input type="file" id="image" name="image[]" accept="image/*"
                                        class="form-control">
                                @else
                                    <p>Limite máximo de 3 imagens atingido.</p>
                                @endif

                            </div>
                            <br>
                            <div class="card-footer">
                                <button type="submit" class="btn btn-primary">Submit</button>
                            </div>
                        </form>
                        <div class="row">
                            @foreach ($products->images as $image)
                                <div class="col-md-4 d-flex ">
                                    <div class="card" style="width: 18rem;">
                                        <img src="{{ asset($image->path) }}" alt="Imagem do produto"
                                            class="mx-auto d-block w-100 card-img-top">
                                        <form action="{{ route('image.delete', $image->id) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <div class="card-footer text-center">
                                                <button type="submit" class="btn btn-primary mx-auto">Excluir</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
