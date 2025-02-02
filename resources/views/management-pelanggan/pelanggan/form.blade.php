<div class="form-group">
    <label for="nama_pelanggan">Nama Pelanggan <span class="text-danger">*</span></label>
    <input type="text" name="nama_pelanggan" id="nama_pelanggan" value="{{ $data->nama_pelanggan ?? '' }}" class="form-control">
</div>

<div class="form-group">
    <label for="alamat">Alamat <span class="text-danger">*</span></label>
    <input type="text" name="alamat" id="alamat" value="{{ $data->alamat ?? '' }}" class="form-control">
</div>

<div class="form-group">
    <label for="nomor_telepon">Nomor Telepon <span class="text-danger">*</span></label>
    <input type="number" name="nomor_telepon" id="nomor_telepon" value="{{ $data->nomor_telepon ?? '' }}" class="form-control">
</div>

<div class="form-group">
    <label>Jenis Kelamin <span class="text-danger">*</span></label>
    <div>
        <label class="mr-3">
            <input type="radio" name="jenis_kelamin" value="L" {{ $data->jenis_kelamin == 'L' ? 'checked' : '' }}> Laki-laki
        </label>
        <label>
            <input type="radio" name="jenis_kelamin" value="P" {{ $data->jenis_kelamin == 'P' ? 'checked' : '' }}> Perempuan
        </label>
    </div>
</div>

<div class="form-group">
    <label for="type_pelanggan_id">Type Pelanggan <span class="text-danger">*</span></label>
    <select name="type_pelanggan_id" id="type_pelanggan_id" class="form-control select2">
        <option value="">Pilih Type Pelanggan</option>
        @foreach ($model as $type)
            <option value="{{ $type->id }}" {{ $data->type_pelanggan_id ?? '' == $type->id ? 'selected' : '' }} name="type_pelanggan_id" >{{ $type->type ?? '' }}</option>
        @endforeach
    </select>
</div>

<div class="form-group">
    <label for="poin_member">Poin Member<span class="text-danger">*</span></label>
    <input type="number" name="poin_member" id="poin_member" min="0" value="{{ $data->poin_member ?? 0 }}" class="form-control">
</div>
