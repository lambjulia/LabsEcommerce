@extends('layout.master')
@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        Review this project
                    </div>
                    <div class="card-body">
                        <form action="{{ route('review.store', ['id' => $products->id]) }}" method="POST">
                            @csrf
                            <div class="row justify-content-center">
                                <div class="col-8">
                                    <div class="mb-3">
                                        <label for="comment" class="form-label">Comment</label>
                                        <textarea class="form-control  @error('comment') is-invalid @enderror" id="comment" name="comment" rows="3"></textarea>
                                    @error('comment')
                                        <div class="alert-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                                </div>
                                <div class="col-8">
                                    <label for="note" class="form-label">Note Review</label>
                                    <select name="note" id="note" class="form-select  @error('note') is-invalid @enderror">
                                        <option value="">Choose a note</option>
                                    </select>
                                    @error('note')
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
    <script type="text/javascript">
        var select = document.getElementById('note');
        for (var i = 1; i <= 5; i++) {
            var option = document.createElement('option');
            option.value = i;
            option.text = '⭐'.repeat(i);
            select.appendChild(option);
        }
    </script>
@endsection
