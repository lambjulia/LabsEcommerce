@extends('layout.master')
@section('content')
    @if (session('product-store'))
        <script>
            Swal.fire({
                position: 'top-end',
                icon: 'success',
                title: 'Product created successfully!',
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
                        Register new product
                    </div>
                    <div class="card-body">
                        <form action="{{ route('product.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="row g-3">
                                <div class="col-6">
                                    <input type="text" id="name" name="name"
                                        class="form-control @error('name') is-invalid @enderror" placeholder="Product Name">
                                    @error('name')
                                        <div class="alert-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-6">
                                    <input type="text" id="description" name="description"
                                        class="form-control @error('description') is-invalid @enderror"
                                        placeholder="Description">
                                    @error('description')
                                        <div class="alert-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-6">
                                    <input type="number" id="price" name="price"
                                        class="form-control @error('price') is-invalid @enderror" placeholder="Price">
                                    @error('price')
                                        <div class="alert-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-6">
                                    <input type="text" id="category" name="category"
                                        class="form-control @error('category') is-invalid @enderror" placeholder="Category">
                                    @error('category')
                                        <div class="alert-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-6">
                                    <label for="images" class="form-label">Images</label>
                                    <input type="file" id="image" name="image[]" multiple accept="image/*"
                                        class="form-control @error('image') is-invalid @enderror">
                                    @error('image')
                                        <div class="alert-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <br>
                            <div class="card-footer">
                                <button type="submit" class="btn btn-primary">Submit</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
