<div class="form-group">
    <label for="name">Username <span class="text-danger">*</span></label>
    <input type="text" name="name" id="name" value="{{ $data->name ?? '' }}" class="form-control" autocomplete>
</div>
<div class="form-group">
    <label for="email">Email <span class="text-danger">*</span></label>
    <input type="email" name="email" id="email" value="{{ $data->email ?? '' }}" class="form-control">
</div>
<div class="form-group">
    <label for="password">Password <span class="text-danger">*</span></label>
    <div class="input-group">
        <input type="password" class="form-control password-input" id="password" name="password"
            value="{{ old('password') }}" placeholder="Masukkan password" autocomplete="new-password">
        <span class="input-group-text password-toggle" style="cursor: pointer;">
            <i class="fas fa-eye-slash"></i>
        </span>
    </div>
</div>
<div class="form-group">
    <label for="confirmed_password">Konfirmasi Password <span class="text-danger">*</span></label>
    <div class="input-group">
        <input type="password" class="form-control password-input" id="confirmed_password" name="confirmed_password"
            value="{{ old('confirmed_password') }}" placeholder="Masukkan konfirmasi password" autocomplete="new-password">
        <span class="input-group-text password-toggle" style="cursor: pointer;">
            <i class="fas fa-eye-slash"></i>
        </span>
    </div>
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
