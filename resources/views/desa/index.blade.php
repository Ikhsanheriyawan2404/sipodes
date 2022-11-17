@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
        @include('components.alerts')
            @if (!$desa)
            <a href="{{ route('desa.create', []) }}" class="btn btn-sm btn-primary my-3">Tambah Desa</a>
            @endif
            <div class="card">
                <div class="card-header">{{ __('Data Desa') }}</div>

                <div class="card-body table-responsive">
                    <table class="table table-striped table-bordered">
                        <thead>
                            <tr>
                                <td>No</td>
                                <td>Code Desa</td>
                                <td>Nama Desa</td>
                                <td>Url Website</td>
                                <td>Kontak</td>
                                <td>Facebook</td>
                                <td>Instagram</td>
                                <td>Logo</td>
                                <td>Struktur Organisasi</td>
                                <td>Deskripsi</td>
                                <td>Action</td>
                            </tr>
                        </thead>
                        <tbody>
                            @if ($desa)
                            <tr>
                                <td>{{ 1 }}</td>
                                <td>{{ $desa->code }}</td>
                                <td>{{ $desa->desa->name }}</td>
                                <td>{{ $desa->url }}</td>
                                <td>{{ $desa->facebook }}</td>
                                <td>{{ $desa->instagram }}</td>
                                <td>{{ $desa->phone_number }}</td>
                                <td><img src="{{ $desa->imagePath }}" width="200"></td>
                                <td><img src="{{ $desa->imageStruktur }}" width="200"></td>
                                <td>{{ $desa->description }}</td>
                                <td>
                                    <a class="btn btn-sm btn-primary" href="{{ route('desa.edit') }}">Edit</a>
                            </tr>
                            @else
                            <tr>
                                <td colspan="11" class="text-center">Belum Ada Data Desa</td>
                            </tr>
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
