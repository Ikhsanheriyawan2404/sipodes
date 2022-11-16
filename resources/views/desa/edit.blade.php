@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
        @include('components.alerts')
            <div class="card">
                <div class="card-header">{{ __('Tambah Desa') }}</div>

                <div class="card-body">
                    <form action="{{ route('desa.update') }}" method="post" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="url">Url Website <span class="text-danger">*</span></label>
                                    <input name="url" id="url"
                                        class="form-control form-control-sm @error('url') is-invalid @enderror"
                                        value="{{ $desa->url ?? old('url') }}">
                                    @error('url')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="logo">logo <span class="text-danger">*</span></label>
                                    <input type="file" name="logo" id="logo" class="form-control form-control-sm">
                                    @error('logo')
                                        <small class="text-danger">
                                            {{ $message }}
                                        </small>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="struktur">Struktur Organisasi <span class="text-danger">*</span></label>
                                    <input type="file" name="struktur" id="struktur" class="form-control form-control-sm">
                                    @error('struktur')
                                        <small class="text-danger">
                                            {{ $message }}
                                        </small>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                            <div class="form-group">
                                    <label for="facebook">Facebook <small>(Jika ada)</small></label>
                                    <input type="text" name="facebook" id="facebook"
                                        class="form-control form-control-sm @error('facebook') is-invalid @enderror"
                                        value="{{ $desa->facebook ?? old('facebook') }}">
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
                                        value="{{ $desa->instagram ?? old('instagram') }}">
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
                                        value="{{ $desa->phone_number ?? old('phone_number') }}">
                                    @error('phone_number')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="description">Deskripsi <span class="text-danger">*</span></label>
                                    <textarea name="description" id="description" class="form-control form-control-sm">{{ $desa->url ?? old('description') }}</textarea>
                                    @error('description')
                                        <small class="text-danger">
                                            {{ $message }}
                                        </small>
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
</script>
@endpush
