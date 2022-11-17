@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <a href="{{ route('umkm.index') }}" class="btn btn-sm btn-primary my-3">Kembali</a>
            @include('components.alerts')
            <div class="card">
                <div class="card-header">Data Gambar {{ $umkm->name }}</div>

                <div class="card-body table-responsive">
                    <form action="{{ route('umkm.upload', $umkm->id) }}" method="post" enctype="multipart/form-data">
                    @csrf
                        <div class="row my-3">
                            <div class="col-md-5">
                                <input type="file" name="image" id="image" class="form-control form-control-sm">
                                @error('image')
                                    <small class="text-danger">{{$message}}</small>
                                @enderror
                            </div>
                            <div class="col-md-5">
                                <input type="text" name="alt" id="alt" class="form-control form-control-sm" placeholder="judul gambar">
                            </div>
                            <div class="col-md-2">
                                <button type="submit" class="btn btn-sm btn-primary">Tambah Gambar</button>
                            </div>
                        </div>
                    </form>

                    <table class="table table-striped table-bordered">
                        <thead>
                            <tr>
                                <td>No</td>
                                <td>Nama Gambar</td>
                                <td>Gambar</td>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($umkm->images as $data)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $data->alt }}</td>
                                <td><img src="{{ $data->imagePath }}" alt="{{ $data->alt }}" width="100"></td>
                                <td>
                                    <form action="{{ route('umkm.deleteImage', $data->id) }}" method="post">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-sm btn-danger" type="submit">Hapus</button>
                                    </form>
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
