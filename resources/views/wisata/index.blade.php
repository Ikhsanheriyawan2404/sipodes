@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <a href="{{ route('wisata.create') }}" class="btn btn-sm btn-primary my-3">Tambah</a>
            <div class="card">
                <div class="card-header">{{ __('Data Wisata') }}</div>

                <div class="card-body table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <td>No</td>
                                <td>Nomor</td>
                                <td>Nomor</td>
                                <td>Nomor</td>
                                <td>Nomor</td>
                                <td>Nomor</td>
                                <td>Nomor</td>
                                <td>Nomor</td>
                                <td>Action</td>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($wisata as $data)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $data->name }}</td>
                                <td>{{ $data->name }}</td>
                                <td>{{ $data->name }}</td>
                                <td>{{ $data->name }}</td>
                                <td>{{ $data->name }}</td>
                                <td>{{ $data->name }}</td>
                                <td>{{ $data->name }}</td>
                                <td>
                                    <a href="{{ route('wisata.edit', $data->id) }}">Edit</a>
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
