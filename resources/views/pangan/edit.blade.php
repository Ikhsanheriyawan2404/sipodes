@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <a href="{{ route('produksi-pangan.index', []) }}" class="btn btn-sm btn-primary my-3">Kembali</a>
            @include('components.alerts')
            <div class="card">
                <div class="card-header">{{ __('Edit Data Pangan') }}</div>

                <div class="card-body table-responsive">
                    <form action="{{ route('produksi-pangan.update', $produksiPangan->id) }}" method="post" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <input type="hidden" value="{{ $produksiPangan->id }}">
                        @include('pangan.form-control.partials')
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
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
