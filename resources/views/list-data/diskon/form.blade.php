<div class="row">
    <div class="col-md-6">
        <div class="form-group">
            <label for="kode_diskon">Kode <span class="text-danger">*</span></label>
            <input type="text" name="kode_diskon" id="kode_diskon" value="{{ $data->kode_diskon ?? '' }}"
                class="form-control kode">
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group">
            <label for="nama_diskon">Nama Diskon <span class="text-danger">*</span></label>
            <input type="text" name="nama_diskon" id="nama_diskon" value="{{ $data->nama_diskon ?? '' }}"
                class="form-control">
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-4">
        <div class="form-group">
            <label for="diskon">Diskon <span class="text-danger">*</span></label>
            <div class="input-group">
                <div class="input-group-prepend">
                    <div class="input-group-text">
                        %
                    </div>
                </div>
                <input type="text" name="diskon" id="diskon" value="{{ $data->diskon ?? '' }}"
                    class="form-control number">
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="form-group">
            <label for="min_diskon">Minimal Diskon <span class="text-danger">*</span></label>
            <div class="input-group">
                <div class="input-group-prepend">
                    <div class="input-group-text">
                        Rp.
                    </div>
                </div>
                <input type="text" name="min_diskon" id="min_diskon" value="{{ $data->min_diskon ?? '' }}"
                    class="form-control currency">
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="form-group">
            <label for="max_diskon">Maximal Diskon <span class="text-danger">*</span></label>
            <div class="input-group">
                <div class="input-group-prepend">
                    <div class="input-group-text">
                        Rp.
                    </div>
                </div>
                <input type="text" name="max_diskon" id="max_diskon" value="{{ $data->max_diskon ?? '' }}"
                    class="form-control currency">
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-4">
        <div class="form-group">
            <label for="type_pelanggan_id">Type Pelanggan <span class="text-danger">*</span></label>
            <select name="type_pelanggan_id" id="type_pelanggan_id" class="form-control select2">
                <option value="">Pilih Type Pelanggan</option>
                @foreach ($type as $pelanggan)
                    <option value="{{ $pelanggan->id }}" @selected(old('type_pelanggan_id', $data->type_pelanggan_id ?? '') == $pelanggan->id)>
                        {{ $pelanggan->type }}
                    </option>
                @endforeach
            </select>
        </div>
    </div>

    <div class="col-md-4">
        <div class="form-group">
            <label>Tanggal Mulai</label>
            <div class="input-group">
                <div class="input-group-prepend">
                    <span class="input-group-text"><i class="fas fa-calendar"></i></span>
                </div>
                <input type="text" name="tgl_mulai" value="{{ $data->tgl_mulai ?? '' }}"
                    class="form-control datepicker">
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="form-group">
            <label>Tanggal Berakhir</label>
            <div class="input-group">
                <div class="input-group-prepend">
                    <span class="input-group-text"><i class="fas fa-calendar"></i></span>
                </div>
                <input type="text" name="tgl_berakhir" value="{{ $data->tgl_berakhir ?? '' }}"
                    class="form-control datepicker">
            </div>
        </div>
    </div>
</div>
