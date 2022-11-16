@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            @include('components.alerts')
            <div class="card">
                <div class="card-header">Data Slider </div>

                <div class="card-body table-responsive">
                    <form action="{{ route('slider.store') }}" method="post" enctype="multipart/form-data">
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
                                @error('alt')
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
                            @foreach ($slider as $data)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $data->title }}</td>
                                <td><img src="{{ $data->imagePath }}" alt="{{ $data->alt }}" width="100"></td>
                                <td>
                                    <form action="{{ route('slider.destroy', $data->id) }}" method="post">
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
