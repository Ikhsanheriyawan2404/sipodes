@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            @include('components.alerts')
            <div class="card">
                <div class="card-header">Data Galeri </div>

                <div class="card-body table-responsive">
                    <form action="{{ route('galeri.store') }}" method="post" enctype="multipart/form-data">
                    @csrf
                        <div class="row my-3">
                            <div class="col-md-3">
                                <input type="file" name="image" id="image" class="form-control form-control-sm">
                                @error('image')
                                    <small class="text-danger">{{$message}}</small>
                                @enderror
                            </div>
                            <div class="col-md-3">
                                <input type="text" name="title" id="title" class="form-control form-control-sm" placeholder="judul gambar">
                                @error('title')
                                    <small class="text-danger">{{$message}}</small>
                                @enderror
                            </div>
                            <div class="col-md-4">
                                <textarea type="text" name="description" id="description" class="form-control form-control-sm" placeholder="deskripsi gambar"></textarea>
                                @error('description')
                                    <small class="text-danger">{{$message}}</small>
                                @enderror
                            </div>
                            <div class="col-md-2">
                                <button type="submit" class="btn btn-sm btn-primary">Tambah Galeri</button>
                            </div>
                        </div>
                    </form>

                    <table class="table table-striped table-bordered">
                        <thead>
                            <tr>
                                <td>No</td>
                                <td>Judul Gambar</td>
                                <td>Deskripsi Gambar</td>
                                <td>Gambar</td>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($galeri as $data)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $data->title }}</td>
                                <td>{{ $data->description }}</td>
                                <td><img src="{{ $data->imagePath }}" alt="{{ $data->alt }}" width="100"></td>
                                <td>
                                    <form action="{{ route('galeri.destroy', $data->id) }}" method="post">
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
