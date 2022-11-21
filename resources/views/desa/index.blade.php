@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
        <h1>DESA</h1>
        @include('components.alerts')
            @if (!$desa)
            <a href="{{ route('desa.create', []) }}" class="btn btn-sm btn-primary my-3">Daftarkan Desa</a>
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
                                <td>
                                    <a class="btn btn-sm btn-primary" href="javascript:void(0)" data-id="{{ $desa->id }}" id="btnDetails">Detail</a>
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

<!-- Modal -->
<div class="modal fade" id="detailsModal" tabindex="-1" role="dialog" aria-labelledby="detailsModal" style="display: none;"
aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="detailsModal">desa Detail</h5>
                <button type="button" class="btn close" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                <ul class="list-group">
                    <button class="list-group-item-action list-group-item">Lokasi : <i id="code"></i></button>
                    <button class="list-group-item-action list-group-item">Nama : <i id="name"></i></button>
                    <button class="list-group-item-action list-group-item"><img id="logo" width="200"></button>
                    <button class="list-group-item-action list-group-item"><img id="struktur" width="200"></button>
                    <button class="list-group-item-action list-group-item"><i id="description"></i></button>
                    <button class="list-group-item-action list-group-item">Dibuat : <i id="createdAt"></i></button>
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
                var desa_id = $(this).data('id');
                $.get("{{ route('desa.index') }}" + '/' + desa_id, function(data) {
                    $('#detailsModal').modal('show');
                    $('#desa_id').val(data.id);
                    $('#code').html(data.code);
                    $('#name').html(data.desa.name);
                    $('#description').html(data.description);
                    $('#createdAt').html(data.created_at);
                    $('#logo').attr('src', '/storage/' + data.logo);
                    $('#struktur').attr('src', '/storage/' + data.struktur);
                })
            })
        });
    </script>
@endpush
