<div class="form-group">
    <label for="jumlah_stok">Jumlah Stok <span class="text-danger">*</span></label>
    <input type="text" name="jumlah_stok" id="jumlah_stok" value="{{ $data->jumlah_stok ?? '' }}" class="form-control number">
</div>

<div class="form-group">
    <label>Tanggal Pembelian</label>
    <div class="input-group">
        <div class="input-group-prepend">
            <span class="input-group-text"><i class="fas fa-calendar"></i></span>
        </div>
        <input type="text" name="tgl_pembelian" value="{{ $data->tgl_pembelian ?? '' }}"
            class="form-control custom-datepicker" placeholder="yyyy-mm-dd">
    </div>
</div>

<div class="form-group">
    <label>Tanggal Kadaluarsa</label>
    <div class="input-group">
        <div class="input-group-prepend">
            <span class="input-group-text"><i class="fas fa-calendar"></i></span>
        </div>
        <input type="text" name="tgl_kadaluarsa" value="{{ $data->tgl_kadaluarsa ?? '' }}"
            class="form-control datepicker" placeholder="yyyy-mm-dd">
    </div>
</div>
