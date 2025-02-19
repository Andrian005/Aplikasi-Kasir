<div class="row">
    <div class="col-md-6">
        <div class="form-group">
            <label for="kode_barang">Kode <span class="text-danger">*</span></label>
            <input type="text" name="kode_barang" id="kode_barang" value="{{ $data->kode_barang ?? '' }}"
                class="form-control kode" placeholder="Masukkan kode barang">
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group">
            <label for="nama_barang">Nama Barang <span class="text-danger">*</span></label>
            <input type="text" name="nama_barang" id="nama_barang" value="{{ $data->nama_barang ?? '' }}"
                class="form-control" placeholder="Masukkan nama barang">
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-6">
        <div class="form-group">
            <label>Tanggal Pembelian</label>
            <div class="input-group">
                <div class="input-group-prepend">
                    <span class="input-group-text"><i class="fas fa-calendar"></i></span>
                </div>
                <input type="text" name="tgl_pembelian" value="{{ $data->tgl_pembelian ?? '' }}"
                    class="form-control custom-datepicker" placeholder="yyyy-mm-dd" {{ $data->tgl_pembelian ? 'disabled' : '' }}>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group">
            <label>Tanggal Kadaluarsa</label>
            <div class="input-group">
                <div class="input-group-prepend">
                    <span class="input-group-text"><i class="fas fa-calendar"></i></span>
                </div>
                <input type="text" name="tgl_kadaluarsa" value="{{ $data->tgl_kadaluarsa ?? '' }}"
                    class="form-control datepicker" placeholder="yyyy-mm-dd" {{ $data->tgl_kadaluarsa ? 'disabled' : '' }}>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-4">
        <div class="form-group">
            <label for="harga_beli">HPP <span class="text-danger">*</span></label>
            <div class="input-group">
                <div class="input-group-prepend">
                    <span class="input-group-text">Rp.</span>
                </div>
                <input type="text" name="harga_beli" id="harga_beli" value="{{ $data->harga_beli ?? '' }}"
                    class="form-control currency" placeholder="Masukkan harga beli" oninput="hitungHargaJual()">
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="form-group">
            <label for="stok">Stok Barang <span class="text-danger">*</span></label>
            <input type="text" name="stok" id="stok" value="{{ $data->stok ?? '' }}" class="form-control number"
                placeholder="Masukkan stok" {{ $data->stok ? 'disabled' : '' }}>
        </div>
    </div>
    <div class="col-md-4">
        <div class="form-group">
            <label for="stok_minimal">Minimal Stok Barang <span class="text-danger">*</span></label>
            <input type="text" name="stok_minimal" id="stok_minimal" value="{{ $data->stok_minimal ?? '' }}"
                class="form-control number" placeholder="Masukkan minimal stok">
        </div>
    </div>
</div>

<div class="row mt-3">
    <div class="col-md-4">
        <div class="form-group">
            <label for="harga_jual_1">Harga Jual 1 (+10%)</label>
            <div class="input-group">
                <div class="input-group-prepend">
                    <span class="input-group-text">Rp.</span>
                </div>
                <input type="text" name="harga_jual_1" id="harga_jual_1" value="{{ $data->harga_jual_1 ?? '' }}"
                    class="form-control currency" readonly>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="form-group">
            <label for="harga_jual_2">Harga Jual 2 (+20%)</label>
            <div class="input-group">
                <div class="input-group-prepend">
                    <span class="input-group-text">Rp.</span>
                </div>
                <input type="text" name="harga_jual_2" id="harga_jual_2" value="{{ $data->harga_jual_2 ?? '' }}"
                    class="form-control currency" readonly>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="form-group">
            <label for="harga_jual_3">Harga Jual 3 (+30%)</label>
            <div class="input-group">
                <div class="input-group-prepend">
                    <span class="input-group-text">Rp.</span>
                </div>
                <input type="text" name="harga_jual_3" id="harga_jual_3" value="{{ $data->harga_jual_3 ?? '' }}"
                    class="form-control currency" readonly>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-4">
        <div class="form-group">
            <label for="kategori_id">Kategori Barang <span class="text-danger">*</span></label>
            <select name="kategori_id" id="kategori_id" class="form-control select2">
                <option value="">Pilih Kategori Barang</option>
                @foreach ($model as $kategori)
                    <option value="{{ $kategori->id }}" @selected(old('kategori_id', $data->kategori_id ?? '') == $kategori->id)>
                        {{ $kategori->nama_kategori }}
                    </option>
                @endforeach
            </select>
        </div>
    </div>
</div>
