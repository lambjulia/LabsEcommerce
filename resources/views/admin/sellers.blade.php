@extends('layout.master')
@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        All of the Sellers
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="display" id="seller-table">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Name</th>
                                        <th>Credit</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($sellers as $s)
                                        <tr>
                                            <td>{{ $s->id }}</td>
                                            <td>{{ $s->user->name }}</td>
                                            <td>{{ $s->credit }}</td>
                                            <td>
                                                <select class="form-select status-select" id="status" name="status"
                                                    data-seller-id="{{ $s->id }}">
                                                    <option selected disabled>{{ $s->status }}</option>
                                                    <option value="pending">Pending</option>
                                                    <option value="approved">Approved</option>
                                                    <option value="denied">Denied</option>
                                                </select>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.1/jquery.min.js"
        integrity="sha512-aVKKRRi/Q/YV+4mjoKBsE4x3H+BkegoM/em46NNlCqNTmUYADjBbeNefNxYV7giUp0VxICtqdrbqU7iVaeZNXA=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>

    <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.js"></script>

    <script type="text/javascript">
        $(document).ready(function() {
            var table = $('#seller-table').DataTable({
                responsive: true,
                "order": [
                    [0, "asc"]
                ],
                language: {
                    url: '//cdn.datatables.net/plug-ins/1.13.4/i18n/pt-BR.json',
                },
            });

            $('#seller-table').on('change', '.status-select', function() {
                var id = $(this).data('seller-id');
                var newStatus = $(this).val();

                $.ajax({
                    url: '{{ route('seller.status') }}',
                    method: 'POST',
                    data: {
                        seller_id: id,
                        new_status: newStatus,
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(response) {
                        Swal.fire({
                            icon: 'success',
                            text: 'Status updated successfully!'
                        });
                    },
                    error: function(xhr, status, error) {
                        Swal.fire({
                            icon: 'error',
                            text: 'Some error happened!'
                        });
                    }
                });
            });
        });
    </script>
@endsection
