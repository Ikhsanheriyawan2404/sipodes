<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Tambah Desa</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://code.jquery.com/jquery-3.6.1.js" integrity="sha256-3zlB5s2uwoUzrXK3BT7AX3FyvojsraNFxCc2vC/7pNI=" crossorigin="anonymous"></script>
</head>
<body>

    <div class="container my-3">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Register</h3>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('desa.store') }}" method="post">
                            @csrf
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="email">Email</label>
                                        <input name="email" id="email"
                                            class="form-control form-control-sm @error('email') is-invalid @enderror"
                                            value="{{ old('email') }}">
                                        @error('email')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label for="password">Password</label>
                                        <input name="password" id="password" class="form-control form-control-sm">
                                    </div>
                                    @error('password')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                    <div class="form-group">
                                        <label for="password_confirmation">Konfirmasi Password</label>
                                        <input name="password_confirmation" id="password_confirmation" class="form-control form-control-sm">
                                        @error('password_confirmation')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label for="name">Nama Lengkap</label>
                                        <input name="name" id="name" class="form-control form-control-sm">
                                        @error('name')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label for="nik">NIK KTP</label>
                                        <input name="nik" id="nik" class="form-control form-control-sm">
                                        @error('nik')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label for="telepon">Telepon</label>
                                        <input type="number" name="telepon" id="telepon" class="form-control form-control-sm">
                                        @error('telepon')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label for="pekerjaan">Pekerjaan</label>
                                        <input type="text" name="pekerjaan" id="pekerjaan" class="form-control form-control-sm">
                                        @error('pekerjaan')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="provinsi">Provinsi <span class="text-danger">*</span></label>
                                        <select name="provinsi" id="provinsi"
                                            class="form-control form-control-sm @error('provinsi') is-invalid @enderror">
                                            <option selected disabled>Pilih Provinsi</option>
                                            @foreach ($provinsi as $data)
                                                <option value="{{ $data->code }}">{{ $data->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    @error('provinsi')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                    <div class="form-group">
                                        <label for="kota">Kabupaten/Kota <span class="text-danger">*</span></label>
                                        <select name="kota" id="kota"
                                            class="form-control form-control-sm @error('kota') is-invalid @enderror">
                                            <option selected disabled>Pilih Kabuptaen/Kota</option>
                                        </select>
                                        @error('kota')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label for="kecamatan">Kecamatan <span class="text-danger">*</span></label>
                                        <select name="kecamatan" id="kecamatan"
                                            class="form-control form-control-sm @error('kecamatan') is-invalid @enderror">
                                            <option selected disabled>Pilih Kecamatan</option>
                                        </select>
                                        @error('kecamatan')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label for="desa">Desa <span class="text-danger">*</span></label>
                                        <select name="desa" id="desa"
                                            class="form-control form-control-sm @error('desa') is-invalid @enderror">
                                            <option selected disabled>Pilih Desa</option>
                                        </select>
                                        @error('desa')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label for="alamat">Alamat</label>
                                        <textarea name="alamat" id="alamat" class="form-control form-control-sm"></textarea>
                                        @error('alamat')
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

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script>
        $(document).ready(function() {
            let provinceId = $('#provinsi').val();
            let kotaId = $('#kota').val();
            let kecamatanId = $('#kecamatan').val();
            $('#provinsi').select2();
            $('#provinsi').change(function() {
                $('#kota').empty();
                $('#kecamatan').empty();
                $("#desa").empty();
                let provinceId = $(this).val();
                if (provinceId) {
                    $('#kota').select2({
                        placeholder: 'Pilih Kota/Kabupaten',
                        allowClear: true,
                        ajax: {
                            url: "{{ route('dropdown.kota') }}?provinceId=" + provinceId,
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
                }
            });

            $('#kota').select2();
            $('#kota').change(function() {
                $('#kecamatan').empty();
                $("#desa").empty();
                let kotaId = $(this).val();
                if (kotaId) {
                    $('#kecamatan').select2({
                        placeholder: 'Pilih Kecamatan',
                        allowClear: true,
                        ajax: {
                            url: "{{ route('dropdown.kecamatan') }}?kotaId=" + kotaId,
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
                    $("#kota").empty();
                    $('#kecamatan').empty();
                    $("#desa").empty();
                }
            });

            $('#kecamatan').select2();
            $('#desa').select2();
            $('#kecamatan').change(function() {
                $("#desa").empty();
                let kecamatanId = $(this).val();
                if (kecamatanId) {
                    $('#desa').select2({
                        placeholder: 'Pilih Desa',
                        allowClear: true,
                        ajax: {
                            url: "{{ route('dropdown.desa') }}?kecamatanId=" + kecamatanId,
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
                    $('#kecamatan').empty();
                    $("#desa").empty();
                }
            });

            $('#provinsi').on('select2:clear', function(e) {
                $("#kota").select2();
                $("#kecamatan").select2();
                $("#desa").select2();
            });

            $('#kota').on('select2:clear', function(e) {
                $("#kecamatan").select2();
                $("#desa").select2();
            });

            $('#kecamatan').on('select2:clear', function(e) {
                $("#desa").select2();
            });
        });
    </script>
</body>
</html>
