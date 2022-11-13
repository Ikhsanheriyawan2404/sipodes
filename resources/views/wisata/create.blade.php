@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <a href="{{ route('wisata.index', []) }}" class="btn btn-sm btn-primary my-3">Kembali</a>
            @include('components.alerts')
            <div class="card">
                <div class="card-header">{{ __('Data Wisata') }}</div>

                <div class="card-body table-responsive">
                    <form action="{{ route('wisata.store') }}" method="post" enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="name">Nama Wisata <span class="text-danger">*</span></label>
                                    <input type="text" name="name" id="name" class="form-control form-control-sm">
                                    @error('name')
                                        <small class="text-danger">
                                            {{$message}}
                                        </small>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="thumbnail">Thumbnail <span class="text-danger">*</span></label>
                                    <input type="file" name="thumbnail" id="thumbnail" class="form-control form-control-sm">
                                    @error('thumbnail')
                                        <small class="text-danger">
                                            {{$message}}
                                        </small>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="description">Deskripsi <span class="text-danger">*</span></label>
                                    <textarea name="description" id="description" class="form-control form-control-sm"></textarea>
                                    @error('description')
                                        <small class="text-danger">
                                            {{$message}}
                                        </small>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="location">Lokasi Wisata <span class="text-danger">*</span></label>
                                    <input type="text" name="location" id="location" class="form-control form-control-sm" placeholder="cth: Jl. raya abadi blok M">
                                    @error('location')
                                        <small class="text-danger">
                                            {{$message}}
                                        </small>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="price">Harga <span class="text-danger">*</span></label>
                                    <input type="number" name="price" id="price" class="form-control form-control-sm">
                                    @error('price')
                                        <small class="text-danger">
                                            {{$message}}
                                        </small>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="longtitude">Longtitude <span class="text-danger">*</span> <small>Lokasi maps longtitude</small></label>
                                    <input type="text" name="longtitude" id="longtitude" class="form-control form-control-sm">
                                    @error('longtitude')
                                        <small class="text-danger">
                                            {{$message}}
                                        </small>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="latitude">Latitude <span class="text-danger">*</span><small>Lokasi maps latitude</small></label>
                                    <input type="text" name="latitude" id="latitude" class="form-control form-control-sm">
                                    @error('latitude')
                                        <small class="text-danger">
                                            {{$message}}
                                        </small>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="meta_description">Meta Description <small>tidak wajib diisi</small></label>
                                    <input type="text" name="meta_description" id="meta_description" class="form-control form-control-sm">
                                    @error('meta_description')
                                        <small class="text-danger">
                                            {{$message}}
                                        </small>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="meta_keyword">Meta Keyword <small>tidak wajib diisi</small></label>
                                    <input type="text" name="meta_keyword" id="meta_keyword" class="form-control form-control-sm">
                                    @error('meta_keyword')
                                        <small class="text-danger">
                                            {{$message}}
                                        </small>
                                    @enderror
                                </div>
                            </div>
                        <button type="submit" class="btn btn-sm btn-primary my-3">Simpan</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
    <script src="https://cdn.ckeditor.com/ckeditor5/35.2.1/classic/ckeditor.js"></script>
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
