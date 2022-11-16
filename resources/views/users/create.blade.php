@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <a href="{{ route('users.index', []) }}" class="btn btn-sm btn-primary my-3">Kembali</a>
            @include('components.alerts')
            <div class="card">
                <div class="card-header">{{ __('Data Wisata') }}</div>

                <div class="card-body table-responsive">
                    <form action="{{ route('users.store') }}" method="post" enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="name">Nama<span class="text-danger">*</span></label>
                                    <input type="text" name="name" id="name" class="form-control form-control-sm" value="{{ old('name') }}">
                                    @error('name')
                                        <small class="text-danger">
                                            {{ $message }}
                                        </small>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="email">Email <span class="text-danger">*</span></label>
                                    <input type="email" name="email" id="email" class="form-control form-control-sm" value="{{ old('email') }}">
                                    @error('email')
                                        <small class="text-danger">
                                            {{ $message }}
                                        </small>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="password">Password <span class="text-danger">*</span></label>
                                    <input type="password" name="password" id="password" class="form-control form-control-sm" value="{{ old('password') }}">
                                    @error('password')
                                        <small class="text-danger">
                                            {{ $message }}
                                        </small>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="password_confirmation">Konfirmasi Password <span class="text-danger">*</span></label>
                                    <input type="password" name="password_confirmation" id="password_confirmation" class="form-control form-control-sm" value="{{ old('password_confirmation') }}">
                                    @error('password_confirmation')
                                        <small class="text-danger">
                                            {{ $message }}
                                        </small>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-sm btn-primary my-3 float-right">Simpan</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
