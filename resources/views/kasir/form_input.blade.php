<div class="col-md-8">
    <div class="container">
        <div class="row">
            <!-- Kolom Kiri: Select -->
            <div class="col-md-6">
                <div class="mb-3">
                    <label for="pelanggan" class="form-label">Pilih Pelanggan</label>
                    <select id="pelanggan" name="pelanggan_id" class="form-select select2"></select>
                </div>
                <div class="mb-3">
                    <label for="barang" class="form-label">Pilih Barang</label>
                    <select id="barang" class="form-select select2"></select>
                </div>
                <div class="mb-3">
                    <label for="diskon" class="form-label">Pilih Diskon</label>
                    <select id="diskon" class="form-select select2"></select>
                </div>
            </div>

            <!-- Kolom Kanan: Input dan Tombol -->
            <div class="col-md-6">
                <div class="mb-3">
                    <label for="jumlah" class="form-label">Jumlah</label>
                    <input type="text" id="jumlah" class="form-control number">
                </div>
                <button id="tambah" class="btn btn-primary">Tambah</button>
                <button id="kurang" class="btn btn-success">Kurang</button>
            </div>
        </div>
    </div>

    <div class="container mt-5">
        <hr>
        <div class="row text-center fw-bold bg-light py-2 border-bottom">
            <div class="col">Produk</div>
            <div class="col">Harga</div>
            <div class="col">Jumlah</div>
            <div class="col">Total</div>
            <div class="col">Aksi</div>
        </div>

        <!-- Data pembelanjaan -->
        <div id="data-pembelanjaan">
            <div class="row text-center py-2 border-bottom data-kosong">
                <div class="col">Tidak ada barang</div>
            </div>
        </div>
    </div>

</div>
