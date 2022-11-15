@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
        @include('components.alerts')
            <div class="card">
                <div class="card-header">{{ __('Data Desa') }}</div>

                <div class="card-body">
                    <table class="table table-striped table-bordered">
                        <thead>
                            <tr>
                                <td>No</td>
                                <td>Code Desa</td>
                                <td>Action</td>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>{{ 1 }}</td>
                                <td>{{ $desa->code }}</td>
                                <td>
                                    <a class="btn btn-sm btn-primary" href="javascript:void(0)" data-id="{{ $desa->id }}" id="btnDetails">Edit</a>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
