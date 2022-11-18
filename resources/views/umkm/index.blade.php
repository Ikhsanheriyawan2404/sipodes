@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <h1>UMKM</h1>
            <a href="{{ route('umkm.create') }}" class="btn btn-sm btn-primary my-3">Tambah</a>
            @include('components.alerts')
            <div class="card">
                <div class="card-header">{{ __('Data umkm') }}</div>

                <div class="card-body table-responsive">
                    <table class="table table-striped table-bordered">
                        <thead>
                            <tr>
                                <td>No</td>
                                <td>Nama UMKM</td>
                                <td>Lokasi</td>
                                <td>Kontak</td>
                                <td>Type UMKM</td>
                                <td>Action</td>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($umkm as $data)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $data->name }}</td>
                                <td>{{ $data->location }}</td>
                                <td>{{ $data->contact }}</td>
                                <td>{{ $data->type_umkm }}</td>
                                <td>
                                    <form action="{{ route('umkm.destroy', $data->id) }}" method="post">
                                    <a class="btn btn-sm btn-primary" href="javascript:void(0)" data-id="{{ $data->id }}" id="btnDetails">Detail</a>
                                    <a class="btn btn-sm btn-primary" href="{{ route('umkm.gambar', $data->id) }}">Tambah Gambar</a>
                                    <a class="btn btn-sm btn-success" href="{{ route('umkm.edit', $data->id) }}">Edit</a>
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
                <h5 class="modal-title" id="detailsModal">Umkm Detail</h5>
                <button type="button" class="btn close" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                <ul class="list-group">
                    <button class="list-group-item-action list-group-item">Nama : <i id="name"></i></button>
                    <button class="list-group-item-action list-group-item">Lokasi : <i id="location"></i></button>
                    <button class="list-group-item-action list-group-item">Figure : <i id="figure"></i></button>
                    <button class="list-group-item-action list-group-item">Contact : <i id="contact"></i></button>
                    <button class="list-group-item-action list-group-item">Type UMKM : <i id="type_umkm"></i></button>
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
    <script>
        $(function () {
            $('body').on('click', '#btnDetails', function () {
                var umkm_id = $(this).data('id');
                $.get("{{ route('umkm.index') }}" + '/' + umkm_id, function(data) {
                    $('#detailsModal').modal('show');
                    $('#umkm_id').val(data.id);
                    $('#name').html(data.name);
                    $('#location').html(data.location);
                    $('#contact').html(data.contact);
                    $('#type_umkm').html(data.type_umkm);
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
