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
                            <table class="table" id="tabela">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Name</th>
                                        <th>Birth</th>
                                        <th>CPF</th>
                                        <th>State</th>
                                        <th>City</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($clients as $c)
                                        <tr>
                                            <td>{{ $c->id }}</td>
                                            <td>{{ $c->user->name }}</td>
                                            <td>{{ $c->birth }}</td>
                                            <td>{{ $c->cpf }}</td>
                                            <td>{{ $c->state }}</td>
                                            <td>{{ $c->city }}</td>
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
@endsection
