@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <a href="{{ route('users.create') }}" class="btn btn-sm btn-primary my-3">Tambah</a>
            @include('components.alerts')
            <div class="card">
                <div class="card-header">{{ __('Data Wisata') }}</div>

                <div class="card-body table-responsive">
                    <table class="table table-striped table-bordered">
                        <thead>
                            <tr>
                                <td>No</td>
                                <td>Nama Pengguna</td>
                                <td>Email</td>
                                <td>Action</td>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($users as $data)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $data->name }}</td>
                                <td>{{ $data->email }}</td>
                                <td>
                                    <a class="btn btn-sm btn-success" href="{{ route('users.edit', $data->id) }}">Edit</a>
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
@endsection
