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
                                    <p>Maximum limit of 3 images reached.</p>
                                @endif

                            </div>
                            <br>
                            <div class="card-footer">
                                <button type="submit" class="btn btn-primary">Submit</button>
                            </div>
                        </form>
                        <div class="row">
                            @foreach ($products->images as $image)
                            <div class="col-md-4 d-flex mb-3">
                                <div class="card" style="width: 18rem;">
                                    <img src="{{ asset($image->path) }}"
                                        class="mx-auto card-img-top">
                                    <div class="card-footer text-center">
                                        <button type="button" class="btn btn-primary delete-item  mx-auto"
                                            data-item-id="{{ $image->id }}">
                                            Delete
                                        </button>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        // Event listener para o botão de exclusão
        document.querySelectorAll('.delete-item').forEach(function(button) {
            button.addEventListener('click', function() {
                var itemId = this.getAttribute('data-item-id');

                Swal.fire({
                    title: 'Confirm delete',
                    text: 'Are you sure you want to delete this image?',
                    icon : 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Delete',
                    cancelButtonText: 'Cancel'
                }).then((result) => {
                    if (result.isConfirmed) {
                        var form = document.createElement('form');
                        form.action = '{{ route('image.delete', ':id') }}'.replace(':id', itemId);
                        form.method = 'POST';
                        form.innerHTML = '@csrf @method('DELETE')';

                        document.body.appendChild(form);
                        form.submit();
                    }
                });
            });
        });
    </script>
@endsection
