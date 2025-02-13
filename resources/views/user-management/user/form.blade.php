<div class="form-group">
    <label for="name">Username <span class="text-danger">*</span></label>
    <input type="text" name="name" id="name" value="{{ $data->name ?? '' }}" class="form-control">
</div>
<div class="form-group">
    <label for="email">Email <span class="text-danger">*</span></label>
    <input type="email" name="email" id="email" value="{{ $data->email ?? '' }}" class="form-control">
</div>
<div class="form-group">
    <label for="password">Password <span class="text-danger">*</span></label>
    <input type="password" name="password" id="password" class="form-control">
</div>
<div class="form-group">
    <label for="confirmed_password">Confirmasi Password <span class="text-danger">*</span></label>
    <input type="password" name="confirmed_password" id="confirmed_password" class="form-control">
</div>
<div class="form-group">
    <label for="role">Hak Akses <span class="text-danger">*</span></label>
    <select name="role" id="role" class="form-control select2">
        <option value="">Pilih Hak Akses</option>
        @foreach ($model as $role)
            <option value="{{ $role->id }}" @selected(old('role', $data->role_id ?? '') == $role->id)>
                {{ $role->role }}
            </option>
        @endforeach
    </select>
</div>
