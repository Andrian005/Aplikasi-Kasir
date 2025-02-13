<div class="form-group">
    <label for="kode">Kode <span class="text-danger">*</span></label>
    <input type="text" name="kode_kategori" id="kode" value="{{ $data->kode_kategori ?? '' }}" class="form-control kode">
</div>
<div class="form-group">
    <label for="kategori">Kategori <span class="text-danger">*</span></label>
    <input type="text" name="nama_kategori" id="kategori" value="{{ $data->nama_kategori ?? '' }}" class="form-control">
</div>
