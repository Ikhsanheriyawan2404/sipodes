@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
        @include('components.alerts')
            <div class="card">
                <div class="card-header">{{ __('Tambah Desa') }}</div>

                <div class="card-body">
                    <form action="{{ route('desa.store') }}" method="post" enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="url">Url Website <span class="text-danger">*</span></label>
                                    <input name="url" id="url"
                                        class="form-control form-control-sm @error('url') is-invalid @enderror"
                                        value="{{ old('url') }}">
                                    @error('url')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="logo">Logo Desa <span class="text-danger">*</span></label>
                                    <input type="file" name="logo" id="logo" class="form-control form-control-sm">
                                    @error('logo')
                                        <small class="text-danger">
                                            {{ $message }}
                                        </small>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="struktur">Strukur Organisasi <span class="text-danger">*</span></label>
                                    <input type="file" name="struktur" id="struktur" class="form-control form-control-sm">
                                    @error('struktur')
                                        <small class="text-danger">
                                            {{ $message }}
                                        </small>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="description">Deskripsi <span class="text-danger">*</span></label>
                                    <textarea name="description" id="description" class="form-control form-control-sm"></textarea>
                                    @error('description')
                                        <small class="text-danger">
                                            {{ $message }}
                                        </small>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="provinsi">Provinsi <span class="text-danger">*</span></label>
                                    <select name="provinsi" id="provinsi"
                                        class="form-control form-control-sm @error('provinsi') is-invalid @enderror">
                                        <option value="{{ $provinsi->code }}" selected disabled>{{ $provinsi->name }}</option>
                                    </select>
                                </div>
                                @error('provinsi')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                                <div class="form-group">
                                    <label for="city_code">Kabupaten/Kota <span class="text-danger">*</span></label>
                                    <select name="city_code" id="city_code"
                                        class="form-control form-control-sm @error('city_code') is-invalid @enderror">
                                        <option selected disabled>Pilih Kabuptaen/Kota</option>
                                        @foreach($kota as $data)
                                            <option value="{{ $data->code }}">{{ $data->name }}</option>
                                        @endforeach
                                    </select>
                                    @error('city_code')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="district_code">Kecamatan <span class="text-danger">*</span></label>
                                    <select name="district_code" id="district_code"
                                        class="form-control form-control-sm @error('district_code') is-invalid @enderror">
                                        <option selected disabled>Pilih Kecamatan</option>
                                    </select>
                                    @error('district_code')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="village_code">Desa <span class="text-danger">*</span></label>
                                    <select name="village_code" id="village_code"
                                        class="form-control form-control-sm @error('village_code') is-invalid @enderror">
                                        <option selected disabled>Pilih Desa</option>
                                    </select>
                                    @error('village_code')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="facebook">Facebook <small>(Jika ada)</small></label>
                                    <input type="text" name="facebook" id="facebook"
                                        class="form-control form-control-sm @error('facebook') is-invalid @enderror"
                                        value="{{ old('facebook') }}">
                                    @error('facebook')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="instagram">Instagram <small>(Jika ada)</small></label>
                                    <input type="text" name="instagram" id="instagram"
                                        class="form-control form-control-sm @error('instagram') is-invalid @enderror"
                                        value="{{ old('instagram') }}">
                                    @error('instagram')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="phone_number">Kontak/No HP <small>(Jika ada)</small></label>
                                    <input type="text" name="phone_number" id="phone_number"
                                        class="form-control form-control-sm @error('phone_number') is-invalid @enderror"
                                        value="{{ old('phone_number') }}">
                                    @error('phone_number')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-sm btn-primary my-3 float-right">Submit</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')

<link href="{{ asset('plugins') }}/select2/dist/css/select2.min.css" rel="stylesheet" />

@endpush

@push('scripts')

<script src="{{ asset('plugins') }}/select2/dist/js/select2.min.js"></script>
<script src="{{ asset('plugins') }}/ckeditor/ckeditor.js"></script>
<script>
     ClassicEditor
        .create( document.querySelector( '#description' ) )
        .then( editor => {
                console.log( editor );
        } )
        .catch( error => {
                console.error( error );
        } )
        ;
    $(document).ready(function() {
        let provinceId = $('#provinsi').val();
        let city_codeId = $('#city_code').val();
        let district_codeId = $('#district_code').val();

        $('#city_code').select2();
        $('#city_code').change(function() {
            $('#district_code').empty();
            $("#village_code").empty();
            let city_codeId = $(this).val();
            if (city_codeId) {
                $('#district_code').select2({
                    placeholder: 'Pilih Kecamatan',
                    allowClear: true,
                    ajax: {
                        url: "{{ route('dropdown.district') }}?city_codeId=" + city_codeId,
                        dataType: 'json',
                        delay: 250,
                        processResults: function(data) {
                            console.log(data);
                            return {
                                results: $.map(data, function(item) {
                                    return {
                                        text: item.name,
                                        id: item.code
                                    }
                                })
                            };
                        }
                    }
                });
            } else {
                $("#city_code").empty();
                $('#district_code').empty();
                $("#village_code").empty();
            }
        });

        $('#district_code').select2();
        $('#village_code').select2();
        $('#district_code').change(function() {
            $("#village_code").empty();
            let district_codeId = $(this).val();
            if (district_codeId) {
                $('#village_code').select2({
                    placeholder: 'Pilih Desa',
                    allowClear: true,
                    ajax: {
                        url: "{{ route('dropdown.village') }}?district_codeId=" + district_codeId,
                        dataType: 'json',
                        delay: 250,
                        processResults: function(data) {
                            console.log(data);
                            return {
                                results: $.map(data, function(item) {
                                    return {
                                        text: item.name,
                                        id: item.code
                                    }
                                })
                            };
                        }
                    }
                });
            } else {
                $('#district_code').empty();
                $("#village_code").empty();
            }
        });

        $('#city_code').on('select2:clear', function(e) {
            $("#district_code").select2();
            $("#village_code").select2();
        });

        $('#district_code').on('select2:clear', function(e) {
            $("#village_code").select2();
        });
    });
</script>
@endpush
