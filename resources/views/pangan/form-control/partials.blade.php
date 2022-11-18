<div class="row">
    <div class="col-md-6">
        <div class="form-group">
            <label for="name">Nama Produksi Pangan <span class="text-danger">*</span></label>
            <input type="text" name="name" id="name" class="form-control form-control-sm" value="{{ $produksiPangan->name ?? old('name') }}">
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
            <textarea name="description" id="description" class="form-control form-control-sm">{{ $produksiPangan->description ?? old('description') }}</textarea>
            @error('description')
                <small class="text-danger">
                    {{ $message }}
                </small>
            @enderror
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group">
            <label for="location">Lokasi Produksi Pangan <span class="text-danger">*</span></label>
            <input type="text" name="location" id="location" class="form-control form-control-sm" value="{{ $produksiPangan->location ?? old('location') }}"
                placeholder="cth: Jl. raya abadi blok M">
            @error('location')
                <small class="text-danger">
                    {{ $message }}
                </small>
            @enderror
        </div>
        <div class="form-group">
            <label for="type_produksi_pangan">Tipe Produksi Pangan <span class="text-danger"></span></label>
            <input type="text" name="type_produksi_pangan" id="type_produksi_pangan" class="form-control form-control-sm" value="{{ $produksiPangan->type_produksi_pangan ?? old('type_produksi_pangan') }}"
            placeholder="pertanian/perkebunan/peternakan/perikanan">
            @error('type_produksi_pangan')
                <small class="text-danger">
                    {{ $message }}
                </small>
            @enderror
        </div>
        <div class="form-group">
            <label for="contact">Kontak <span class="text-danger">* <small>(format harus diawali 62)</small></span></label>
            <input type="number" name="contact" id="contact" class="form-control form-control-sm" value="{{ $produksiPangan->contact ?? old('contact') }}" placeholder="6281234567890">
            @error('contact')
                <small class="text-danger">
                    {{ $message }}
                </small>
            @enderror
        </div>
        <div class="form-group">
            <label for="meta_description">Meta Description <small>tidak wajib diisi</small></label>
            <input type="text" name="meta_description" id="meta_description" class="form-control form-control-sm" value="{{ $produksiPangan->meta_description ?? old('meta_description') }}">
            @error('meta_description')
                <small class="text-danger">
                    {{ $message }}
                </small>
            @enderror
        </div>
        <div class="form-group">
            <label for="meta_keyword">Meta Keyword <small>tidak wajib diisi</small></label>
            <input type="text" name="meta_keyword" id="meta_keyword" class="form-control form-control-sm" value="{{ $produksiPangan->meta_keyword ?? old('meta_keyword') }}">
            @error('meta_keyword')
                <small class="text-danger">
                    {{ $message }}
                </small>
            @enderror
        </div>
    </div>
</div>
<button type="submit" class="btn btn-sm btn-primary my-3 float-right">Simpan</button>
