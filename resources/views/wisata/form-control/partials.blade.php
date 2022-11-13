<div class="row">
    <div class="col-md-6">
        <div class="form-group">
            <label for="name">Nama Wisata <span class="text-danger">*</span></label>
            <input type="text" name="name" id="name" class="form-control form-control-sm" value="{{ $wisata->name ?? old('name') }}">
            @error('name')
                <small class="text-danger">
                    {{ $message }}
                </small>
            @enderror
        </div>
        <div class="form-group">
            <label for="thumbnail">Thumbnail <span class="text-danger">*</span></label>
            <input type="file" name="thumbnail" id="thumbnail" class="form-control form-control-sm">
            @error('thumbnail')
                <small class="text-danger">
                    {{ $message }}
                </small>
            @enderror
        </div>
        <div class="form-group">
            <label for="description">Deskripsi <span class="text-danger">*</span></label>
            <textarea name="description" id="description" class="form-control form-control-sm">{{ $wisata->description ?? old('description') }}</textarea>
            @error('description')
                <small class="text-danger">
                    {{ $message }}
                </small>
            @enderror
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group">
            <label for="location">Lokasi Wisata <span class="text-danger">*</span></label>
            <input type="text" name="location" id="location" class="form-control form-control-sm" value="{{ $wisata->location ?? old('location') }}"
                placeholder="cth: Jl. raya abadi blok M">
            @error('location')
                <small class="text-danger">
                    {{ $message }}
                </small>
            @enderror
        </div>
        <div class="form-group">
            <label for="price">Harga <span class="text-danger">*</span></label>
            <input type="number" name="price" id="price" class="form-control form-control-sm" value="{{ $wisata->price ?? old('price') }}">
            @error('price')
                <small class="text-danger">
                    {{ $message }}
                </small>
            @enderror
        </div>
        <div class="form-group">
            <label for="longtitude">Longtitude <span class="text-danger">*</span> <small>Koordinat Lokasi maps
                    longtitude maksimal 9 digit.</small></label>
            <input type="text" name="longtitude" id="longtitude" class="form-control form-control-sm" value="{{ $wisata->longtitude ?? old('longtitude') }}"
                placeholder="cth: 123.456789">
            @error('longtitude')
                <small class="text-danger">
                    {{ $message }}
                </small>
            @enderror
        </div>
        <div class="form-group">
            <label for="latitude">Latitude <span class="text-danger">*</span><small>Koordinat maps latitude maksimal 9
                    digit.</small></label>
            <input type="text" name="latitude" id="latitude" class="form-control form-control-sm" value="{{ $wisata->latitude ?? old('latitude') }}"
                placeholder="cth: 123.456789">
            @error('latitude')
                <small class="text-danger">
                    {{ $message }}
                </small>
            @enderror
        </div>
        <div class="form-group">
            <label for="meta_description">Meta Description <small>tidak wajib diisi</small></label>
            <input type="text" name="meta_description" id="meta_description" class="form-control form-control-sm" value="{{ $wisata->meta_description ?? old('meta_description') }}">
            @error('meta_description')
                <small class="text-danger">
                    {{ $message }}
                </small>
            @enderror
        </div>
        <div class="form-group">
            <label for="meta_keyword">Meta Keyword <small>tidak wajib diisi</small></label>
            <input type="text" name="meta_keyword" id="meta_keyword" class="form-control form-control-sm" value="{{ $wisata->meta_keyword ?? old('meta_keyword') }}">
            @error('meta_keyword')
                <small class="text-danger">
                    {{ $message }}
                </small>
            @enderror
        </div>
    </div>
</div>
<button type="submit" class="btn btn-sm btn-primary my-3 float-right">Simpan</button>
