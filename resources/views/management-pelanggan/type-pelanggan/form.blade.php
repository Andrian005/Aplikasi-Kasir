<div class="form-group">
    <label for="type">Type <span class="text-danger">*</span></label>
    <input type="text" name="type" id="type" value="{{ $data->type ?? '' }}" class="form-control">
</div>
<div class="form-group">
    <label for="keuntungan">Keuntungan <span class="text-danger">*</span></label>
    <input type="number" name="persen_keuntungan" id="keuntungan" min="1" value="{{ $data->persen_keuntungan ?? '' }}" class="form-control">
</div>
