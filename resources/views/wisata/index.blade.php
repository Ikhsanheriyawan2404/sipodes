@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <a href="{{ route('wisata.create') }}" class="btn btn-sm btn-primary my-3">Tambah</a>
            @include('components.alerts')
            <div class="card">
                <div class="card-header">{{ __('Data Wisata') }}</div>

                <div class="card-body table-responsive">
                    <table class="table table-striped table-bordered">
                        <thead>
                            <tr>
                                <td>No</td>
                                <td>Nama Wisata</td>
                                <td>Lokasi</td>
                                <td>Harga Tiket</td>
                                <td>Latitude</td>
                                <td>Longtitude</td>
                                <td>Action</td>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($wisata as $data)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $data->name }}</td>
                                <td>{{ $data->location }}</td>
                                <td>{{ $data->price }}</td>
                                <td>{{ $data->latitude }}</td>
                                <td>{{ $data->longtitude }}</td>
                                <td>
                                    <form action="{{ route('wisata.destroy', $data->id) }}" method="post">
                                    <a class="btn btn-sm btn-primary" href="javascript:void(0)" data-id="{{ $data->id }}" id="btnDetails">Detail</a>
                                    <a class="btn btn-sm btn-primary" href="{{ route('wisata.gambar', $data->id) }}">Tambah Gambar</a>
                                    <a class="btn btn-sm btn-success" href="{{ route('wisata.edit', $data->id) }}">Edit</a>
                                    @csrf
                                    @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Yakin ingin menghapus?')">Hapus</button>
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

<!-- Modal -->
<div class="modal fade" id="detailsModal" tabindex="-1" role="dialog" aria-labelledby="detailsModal" style="display: none;"
aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="detailsModal">Wisata Detail</h5>
                <button type="button" class="btn close" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                <ul class="list-group" id="kontol">
                    <button class="list-group-item-action list-group-item">Nama : <i id="name"></i></button>
                    <button class="list-group-item-action list-group-item">Lokasi : <i id="location"></i></button>
                    <button class="list-group-item-action list-group-item">Harga Tiket : <i id="price"></i></button>
                    <button class="list-group-item-action list-group-item">Latitude : <i id="latitude"></i></button>
                    <button class="list-group-item-action list-group-item">Longtitude : <i id="longtitude"></i></button>
                    <button class="list-group-item-action list-group-item"><img id="thumbnail" width="200"></button>
                    <button class="list-group-item-action list-group-item"><i id="description"></i></button>
                    <button class="list-group-item-action list-group-item">Dibuat : <i id="createdAt"></i></button>
                    <button class="list-group-item-action list-group-item"><i id="images"></i></button>
                </ul>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
    <script src="https://code.jquery.com/jquery-3.6.1.min.js" integrity="sha256-o88AwQnZB+VDvE9tvIXrMQaPlFFSUTR+nldQm1LuPXQ=" crossorigin="anonymous"></script>
    <script>
        $(function () {
            $('body').on('click', '#btnDetails', function () {
                var wisata_id = $(this).data('id');
                $.get("{{ route('wisata.index') }}" + '/' + wisata_id, function(data) {
                    $('#detailsModal').modal('show');
                    $('#wisata_id').val(data.id);
                    $('#name').html(data.name);
                    $('#location').html(data.location);
                    $('#price').html(data.price);
                    $('#latitude').html(data.latitude);
                    $('#longtitude').html(data.longtitude);
                    $('#description').html(data.description);
                    $('#createdAt').html(data.created_at);
                    $('#thumbnail').attr('src', '/storage/' + data.thumbnail);
                    $.each(data.images, function (key, value) {
                        $('i#images').append('<img src="/storage/'+ value.image +'" width="200" class="images">');
                    })
                })
                $('img.images').remove();
            })
        });
    </script>
@endpush
