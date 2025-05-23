<script>
    const getMultiplier = () => {
        const pelangganType = parseInt($('#pelanggan option:selected').data('type')) || 0;
        const $barang = $('#barang option:selected');
        if (!$barang.val()) return 1;

        const hargaBeli = parseFloat($barang.data('harga')) || 0;
        if (!hargaBeli) return 1;

        let multiplier = 1;
        if (pelangganType === 1) {
            const hargaJual1 = parseFloat($barang.data('harga_jual_1')) || 0;
            multiplier = hargaJual1 > 0 ? hargaJual1 / hargaBeli : 1;
        } else if (pelangganType === 2) {
            const hargaJual2 = parseFloat($barang.data('harga_jual_2')) || 0;
            multiplier = hargaJual2 > 0 ? hargaJual2 / hargaBeli : 1;
        } else {
            const hargaJual3 = parseFloat($barang.data('harga_jual_3')) || 0;
            multiplier = hargaJual3 > 0 ? hargaJual3 / hargaBeli : 1;
        }
        return multiplier;
    };

    const updateTotalBelanja = () => {
        let total = 0;
        $('#data-pembelanjaan tr').each(function () {
            const totalHarga = parseInt($(this).find('.total-harga').text().replace(/[^\d.-]/g, '')) || 0;
            total += totalHarga;
        });
        $('#total-belanja').text(`Rp ${total.toLocaleString()}`);
    };

    const updateCleaveField = (fieldName, value) => {
        if (cleaveInstances[fieldName]) {
            cleaveInstances[fieldName].setRawValue(value);
        }
    };

    const hitungTotalBelanja = () => {
        let totalSebelumDiskon = 0;
        $('.total-harga').each(function () {
            totalSebelumDiskon += parseInt($(this).text().replace(/[^\d]/g, '')) || 0;
        });

        $('#diskon option').each(function () {
            const min = parseInt($(this).data('min')) || 0;
            const max = parseInt($(this).data('max')) || Infinity;
            if (totalSebelumDiskon >= min && totalSebelumDiskon <= max) {
                $(this).prop('disabled', false).data('status', 'Memenuhi syarat');
            } else {
                $(this).prop('disabled', true).data(
                    'status',
                    `Belum memenuhi syarat (Min: Rp${min.toLocaleString()} - Max: Rp${max.toLocaleString()})`
                );
            }
        });
        $('#diskon').select2({ templateResult: formatDiskonOption, templateSelection: formatSelection });
        if ($('#diskon option:not(:disabled)').length === 1) {
            $('#diskon').val("").trigger('change.select2');
        }

        const tipe = parseInt($('#pelanggan option:selected').data('type')) || 0;
        const poinMember = (tipe === 1 || tipe === 2) ? totalSebelumDiskon * 0.02 : 0;
        const persenDiskon = parseInt($('#diskon option:selected').val()) || 0;
        const nilaiDiskon = (totalSebelumDiskon * persenDiskon) / 100;
        let totalSetelahDiskon = totalSebelumDiskon - nilaiDiskon;

        const gunakanPoin = $('#poin').is(':checked');
        const poinMaks = parseInt($('#pelanggan option:selected').data('poin')) || 0;
        let poinDigunakan = 0;

        if (gunakanPoin) {
            if (poinMaks >= totalSebelumDiskon) {
                poinDigunakan = Math.floor(poinMaks * 0.5);
            } else {
                poinDigunakan = Math.min(poinMaks, totalSetelahDiskon);
            }
        }

        totalSetelahDiskon -= poinDigunakan;

        const nilaiPPN = parseInt(totalSetelahDiskon * 0.12);
        const totalAkhir = parseInt(totalSetelahDiskon + nilaiPPN);

        updateCleaveField('totalHarga', totalSebelumDiskon);
        updateCleaveField('poinDidapat', poinMember);
        updateCleaveField('poinDigunakan', poinDigunakan);
        updateCleaveField('diskonText', nilaiDiskon);
        updateCleaveField('ppnText', nilaiPPN);
        updateCleaveField('totalFinal', totalAkhir);
    };

    const formatOptionFunction = getExtraText => option => {
        if (!option.id || !option.element) return option.text;
        const extra = getExtraText(option);
        return $(`<span>${option.text}${extra ? '<br><small>' + extra + '</small>' : ''}</span>`);
    };

    const formatSelection = option => option.text;
    const formatDiskonOption = formatOptionFunction(option => $(option.element).data('status') || "Memenuhi syarat");
    const formatBarangOption = formatOptionFunction(option => {
        const totalStok = parseInt($(option.element).data('stok')) || 0;
        const stokMin = parseInt($(option.element).data('stok_minimal')) || 0;
        if (totalStok === 0) {
            return "Stok Habis";
        }
        return "Stok " + totalStok + (totalStok < stokMin ? " (Stok Menipis)" : "");
    });

    const populatePelanggan = () => {
        $.ajax({
            url: "{{ route('kasir.getPelanggan') }}",
            type: "GET",
            success: data => {
                const options = ['<option value="">Pilih Pelanggan</option>']
                    .concat(data.map(item => `
                        <option value="${item.id}"
                        data-type="${item.type_pelanggan_id}"
                        data-nama="${item.nama_pelanggan}"
                        data-poin="${item.poin_member}">
                        ${item.nama_pelanggan} - ${item.type_pelanggan?.type || 'Tanpa Tipe'}
                        </option>
                    `));
                $('#pelanggan').html(options.join('')).val("").trigger('change');
            }
        });
    };

    const populateBarang = () => {
        $.ajax({
            url: "{{ route('kasir.getBarang') }}",
            type: "GET",
            success: data => {
                const options = ['<option value="">Pilih Barang</option>']
                    .concat(data.map(item => `
                        <option value="${item.id}"
                        data-kode="${item.kode_barang}"
                        data-harga="${item.harga_beli}"
                        data-harga_jual_1="${item.harga_jual_1}"
                        data-harga_jual_2="${item.harga_jual_2}"
                        data-harga_jual_3="${item.harga_jual_3}"
                        data-stok="${item.totalStok}"
                        data-stok_minimal="${item.stok_minimal}">
                        ${item.kode_barang} -
                        ${item.nama_barang}
                        </option>
                    `));
                $('#barang').html(options.join('')).val("").trigger('change');
                $('#barang').select2({ templateResult: formatBarangOption, templateSelection: formatSelection });
            }
        });
    };

    const updatePelangganInfo = () => {
        const $selected = $('#pelanggan option:selected');
        if ($selected.val()) {
            const nama = $selected.data('nama');
            const poin = $selected.data('poin') || 0;
            const html = `
                <div class="card p-3 mb-3 shadow-sm">
                <div class="row">
                    <div class="col-6">
                    <p class="mb-1 fw-bold">Nama</p>
                    <p class="mb-0">${nama}</p>
                    </div>
                    <div class="col-6">
                    <p class="mb-1 fw-bold">Poin Member</p>
                    <p class="mb-0">${poin}</p>
                    </div>
                </div>
                <div class="mt-3 d-flex align-items-center">
                    <label class="custom-switch mt-2">
                    <input type="checkbox" id="poin" class="custom-switch-input">
                    <span class="custom-switch-indicator"></span>
                    <span class="custom-switch-description">Pakai Poin Member</span>
                    </label>
                </div>
                </div>
            `;
            $('#infoPelanggan').html(html).fadeIn();
        } else {
            $('#infoPelanggan').fadeOut();
        }
        $.ajax({
            url: "{{ route('kasir.getDiskon') }}/" + ($selected.data('type') || 0),
            type: "GET",
            success: data => {
                const options = ['<option value="">Pilih Diskon</option>']
                    .concat(data.map(item => `
                        <option value="${item.diskon}"
                        data-min="${item.min_diskon}"
                        data-max="${item.max_diskon}">
                        ${item.kode_diskon} - ${item.nama_diskon} - ${item.diskon}%
                        </option>
                    `));
                $('#diskon').html(options.join('')).val("");
                $('#diskon').select2({ templateResult: formatDiskonOption, templateSelection: formatSelection });
                hitungTotalBelanja();
            }
        });
    };

    const updateHargaPembelanjaan = () => {
        const multiplier = getMultiplier();
        $('#data-pembelanjaan .data-row').each(function () {
            const $row = $(this);
            const hargaAsli = parseInt($row.data('harga-asli')) || 0;
            const jumlah = parseInt($row.find('.jumlah-barang input').val()) || 1;
            const hargaBaru = Math.round(hargaAsli * multiplier);
            const totalHarga = hargaBaru * jumlah;

            $row.find('.harga-satuan')
                .contents()
                .filter((_, node) => node.nodeType === Node.TEXT_NODE)
                .remove();
            $row.find('.harga-satuan').prepend(`Rp ${hargaBaru.toLocaleString()}`);
            $row.find('.harga-satuan input').val(hargaBaru);

            $row.find('.total-harga')
                .contents()
                .filter((_, node) => node.nodeType === Node.TEXT_NODE)
                .remove();
            $row.find('.total-harga').prepend(`Rp ${totalHarga.toLocaleString()}`);
            $row.find('.total-harga input').val(totalHarga);
        });
    };

    const updateRowQuantity = ($row, newQuantity, hargaBaru) => {
        const total = hargaBaru * newQuantity;
        const index = $row.data('index');

        $row.find('.jumlah-barang input').val(newQuantity);
        $row.find('.total-harga input').val(total);

        $row.find('.jumlah-barang').contents().filter((_, node) => node.nodeType === Node.TEXT_NODE).remove();
        $row.find('.jumlah-barang').prepend(newQuantity);

        $row.find('.total-harga').contents().filter((_, node) => node.nodeType === Node.TEXT_NODE).remove();
        $row.find('.total-harga').prepend(`Rp ${total.toLocaleString()}`);

        $row.find(`input[name="detail_transaksi[${index}][jumlah]"]`).val(newQuantity);
        $row.find(`input[name="detail_transaksi[${index}][sub_total]"]`).val(total);
    };

    $(document).ready(() => {
        populatePelanggan();
        populateBarang();

        $('#pelanggan').change(() => {
            updatePelangganInfo();
            updateHargaPembelanjaan();
            hitungTotalBelanja();
            updateTotalBelanja();
        });

        $('#diskon').change(() => hitungTotalBelanja());

        const updateTotalBelanja = () => {
            let total = 0;
            $('#data-pembelanjaan .data-row').each(function () {
                const totalHarga = parseInt(
                    $(this)
                        .find('.total-harga')
                        .text()
                        .replace(/[^\d.-]/g, '')
                ) || 0;
                total += totalHarga;
            });
            $('#total-belanja').text(`Rp ${total.toLocaleString()}`);
        };

        const updateRowQuantity = ($row, newQuantity, hargaBaru) => {
            const total = hargaBaru * newQuantity;
            const index = $row.data('index');

            $row.find('.jumlah-barang input').val(newQuantity);
            $row.find('.total-harga input').val(total);

            $row.find('.jumlah-barang').html(
                `${newQuantity}<input type="hidden" name="detail_transaksi[${index}][jumlah]" value="${newQuantity}">`
            );
            $row.find('.total-harga').html(
                `Rp ${total.toLocaleString()}<input type="hidden" name="detail_transaksi[${index}][sub_total]" value="${total}">`
            );
        };

        let detailIndex = 0;
        $('#tambah, #kurang').click(function (e) {
            e.preventDefault();
            const isAddition = $(this).attr('id') === 'tambah';
            const $barang = $('#barang option:selected');
            const barangId = $barang.val();

            if (!barangId) {
                alertCustom("Silakan pilih barang terlebih dahulu!");
                return;
            }

            const jumlahInput = parseInt($('#jumlah').val()) || 1;
            const multiplier = getMultiplier();
            const hargaAsli = parseInt($barang.data('harga')) || 0;
            const hargaBaru = Math.round(hargaAsli * multiplier);

            if (isAddition) {
                const barangNama = $barang.text();
                const stok = parseInt($barang.data('stok')) || 0;
                const $row = $(`#data-pembelanjaan .data-row[data-id="${barangId}"]`);

                if ($row.length) {
                    let currentQuantity = parseInt($row.find('.jumlah-barang input').val()) || 0;
                    const newQuantity = currentQuantity + jumlahInput;
                    if (stok === 0) {
                        alertCustom("Stok barang habis!");
                        return;
                    }

                    if (newQuantity > stok) {
                        alertCustom("Jumlah pembelian melebihi stok!");
                        return;
                    }
                    updateRowQuantity($row, newQuantity, hargaBaru);
                } else {
                    if (stok === 0) {
                        alertCustom("Stok barang habis!");
                        return;
                    }

                    if (jumlahInput > stok) {
                        alertCustom("Jumlah pembelian melebihi stok!");
                        return;
                    }
                    $('#data-pembelanjaan').find('.data-kosong').hide();

                    const newRow = $(`
                        <div class="row text-center py-2 border-bottom data-row" data-index="${detailIndex}" data-id="${barangId}" data-harga-asli="${hargaAsli}">
                            <div class="col produk">
                                ${barangNama}
                                <input type="hidden" name="detail_transaksi[${detailIndex}][barang_id]" value="${barangId}">
                            </div>
                            <div class="col harga-satuan">
                                Rp ${hargaBaru.toLocaleString()}
                                <input type="hidden" name="detail_transaksi[${detailIndex}][harga_satuan]" value="${hargaBaru}">
                            </div>
                            <div class="col jumlah-barang">
                                ${jumlahInput}
                                <input type="hidden" name="detail_transaksi[${detailIndex}][jumlah]" value="${jumlahInput}">
                            </div>
                            <div class="col total-harga">
                                Rp ${(hargaBaru * jumlahInput).toLocaleString()}
                                <input type="hidden" name="detail_transaksi[${detailIndex}][sub_total]" value="${hargaBaru * jumlahInput}">
                            </div>
                            <div class="col aksi">
                                <button class="btn btn-danger btn-sm hapus-barang">Hapus</button>
                            </div>
                        </div>
                    `);
                    $('#data-pembelanjaan').append(newRow);
                    detailIndex++;
                }
            } else {
                const $row = $(`#data-pembelanjaan .data-row[data-id="${barangId}"]`);
                if ($row.length) {
                    let currentQuantity = parseInt($row.find('.jumlah-barang input').val()) || 0;
                    const originalHarga = parseInt($row.data('harga-asli')) || 0;
                    const hargaBaruUpdated = Math.round(originalHarga * multiplier);
                    if (currentQuantity > jumlahInput) {
                        const newQuantity = currentQuantity - jumlahInput;
                        updateRowQuantity($row, newQuantity, hargaBaruUpdated);
                    } else {
                        const index = $row.data('index');
                        $(`#data-pembelanjaan input[name^="detail_transaksi[${index}]"]`).remove();
                        $row.remove();
                        if ($('#data-pembelanjaan .data-row').length === 0) {
                            $('#data-pembelanjaan').find('.data-kosong').show();
                        }
                    }
                } else {
                    alertCustom("Barang belum ditambahkan ke daftar pembelanjaan!");
                }
            }
            hitungTotalBelanja();
            updateTotalBelanja();
            $('#jumlah').val('');
        });

        $(document).on('click', '.hapus-barang', function () {
            const $row = $(this).closest('.data-row');
            const index = $row.data('index');
            $row.remove();
            $(`#data-pembelanjaan input[name^="detail_transaksi[${index}]"]`).remove();
            if ($('#data-pembelanjaan .data-row').length === 0) {
                $('#data-pembelanjaan').find('.data-kosong').show();
            }
            hitungTotalBelanja();
        });

        $('#infoPelanggan').on('change', '#poin', hitungTotalBelanja);

        $('#reset').click(e => {
            e.preventDefault();
            $('#data-pembelanjaan').find('.data-row').remove();
            $('#data-pembelanjaan').find('.data-kosong').show();
            populateBarang();
            populatePelanggan();
            hitungTotalBelanja();
            $('#bayar').val('');
            cleaveBayar.setRawValue(0);
            cleaveKembalian.setRawValue(0);
        });

        const updateKembalian = kembalian => {
            kembalian = isNaN(kembalian) ? 0 : kembalian;
            const hasil = Math.max(kembalian, 0);
            cleaveKembalian.setRawValue(hasil);
            if (hasil === 0) {
                $('#kembalian').val('0');
            }
        };
        updateKembalian(0);

        $('#bayar').keyup(function () {
            const inputVal = $(this).val().trim();
            const totalAkhir = parseInt($('#total-final').val().replace(/[^\d]/g, '')) || 0;
            const bayar = parseInt(inputVal.replace(/[^\d]/g, '')) || 0;
            updateKembalian(bayar - totalAkhir);
        });

        $('#prosesBayar').click(() => {
            if ($('#data-pembelanjaan').find('.data-row').length === 0) {
                alertCustom("Belum ada barang!");
                cleaveBayar.setRawValue(0);
                updateKembalian(0);
            }
        });
    });

</script>
