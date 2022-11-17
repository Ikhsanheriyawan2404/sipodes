@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <a href="{{ route('budaya.index', []) }}" class="btn btn-sm btn-primary my-3">Kembali</a>
            @include('components.alerts')
            <div class="card">
                <div class="card-header">{{ __('Edit Data Budaya') }}</div>

                <div class="card-body table-responsive">
                    <form action="{{ route('budaya.update', $budaya->id) }}" method="post" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <input type="hidden" value="{{ $budaya->id }}">
                        @include('budaya.form-control.partials')
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
