<div class="col-md-4">
    <!-- Bagian Kanan: Total dan Pembayaran -->
    <div class="card p-3">
        <div class="mb-3" id="infoPelanggan" style="display: none;"></div>
        <div class="mb-3" id="infoBelanja">
            <h5 class="fw-bold">Ringkasan Belanja</h5>
            <hr>
            <div class="row">
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="poin-didapat" class="form-label">Poin Didapatkan</label>
                        <input type="text" id="poin-didapat" name="poin_didapat" class="form-control" readonly>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="poin-digunakan" class="form-label">Poin Digunakan</label>
                        <input type="text" id="poin-digunakan" name="poin_digunakan" class="form-control" readonly>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="total-harga" class="form-label">Total Harga</label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text">Rp.</span>
                            </div>
                            <input type="text" id="total-harga" name="total_harga" class="form-control" readonly>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="diskon-text" class="form-label">Diskon</label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text">Rp.</span>
                            </div>
                            <input type="text" id="diskon-text" name="diskon" class="form-control" readonly>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="ppn-text" class="form-label">PPN 12%</label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text">Rp.</span>
                            </div>
                            <input type="text" id="ppn-text" name="ppn" class="form-control" readonly>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="mb-3">
                        <label for="total-final" class="form-label fw-bold" style="font-size: 1.5rem;">Total Akhir</label>
                        <div class="input-group input-group-lg">
                            <div class="input-group-prepend">
                                <span class="input-group-text">Rp.</span>
                            </div>
                            <input type="text" id="total-final" name="total_final" class="form-control form-control-lg fw-bold text-primary" readonly>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="mb-3">
            <label for="bayar" class="form-label fw-semibold">Jumlah Uang</label>
            <div class="input-group input-group-lg">
                <span class="input-group-text">Rp.</span>
                <input type="text" id="bayar" name="pembayaran" class="form-control currency" placeholder="Masukkan jumlah uang">
            </div>
            <div class="mt-2 p-3 bg-light rounded shadow-sm">
                <h6 class="mb-0 text-primary fw-bold">
                    Kembalian: <span class="text-dark">Rp</span>
                    <input type="text" id="kembalian" name="kembalian" class="form-control currency" readonly style="display: inline-block; width: auto; border: none; background: none; padding: 0;">
                </h6>
            </div>
        </div>

        <div class="row mt-3">
            <div class="col-md-6">
                <button type="button" id="prosesBayar" class="btn btn-success fw-bold rounded-pill w-100" onclick="transaksi()">Bayar</button>
            </div>
            <div class="col-md-6">
                <button id="reset" class="btn btn-outline-dark fw-bold rounded-pill w-100">Reset</button>
            </div>
        </div>
    </div>
</div>
