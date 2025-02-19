@extends('layouts.main-transaksi')

@section('content')
    <div class="card p-4">
        <form id="formKasir" method="POST">
            @csrf
            @include('layouts.partial.validate')

            <div class="row">
                @include('kasir.form_input')
                @include('kasir.form_summary')
            </div>
        </form>
    </div>
@endsection


@push('page_script')
    @include('kasir.script_kasir')
    <script>
        $('#formKasir').Form();

        const cleaveInstances = {
            totalHarga: new Cleave("#total-harga", {
                numeral: true,
                numeralThousandsGroupStyle: "thousand",
            }),
            poinDidapat: new Cleave("#poin-didapat", {
                numeral: true,
                numeralThousandsGroupStyle: "thousand",
            }),
            poinDigunakan: new Cleave("#poin-digunakan", {
                numeral: true,
                numeralThousandsGroupStyle: "thousand",
            }),
            diskonText: new Cleave("#diskon-text", {
                numeral: true,
                numeralThousandsGroupStyle: "thousand",
            }),
            ppnText: new Cleave("#ppn-text", {
                numeral: true,
                numeralThousandsGroupStyle: "thousand",
            }),
            totalFinal: new Cleave("#total-final", {
                numeral: true,
                numeralThousandsGroupStyle: "thousand",
            })
        };

        const cleaveBayar = new Cleave("#bayar", {
            numeral: true,
            numeralThousandsGroupStyle: "thousand"
        });
        const cleaveKembalian = new Cleave("#kembalian", {
            numeral: true,
            numeralThousandsGroupStyle: "thousand"
        });

        function updateAllFields() {
            const fields = {
                "#total-harga": cleaveInstances.totalHarga,
                "#poin-didapat": cleaveInstances.poinDidapat,
                "#poin-digunakan": cleaveInstances.poinDigunakan,
                "#diskon-text": cleaveInstances.diskonText,
                "#ppn-text": cleaveInstances.ppnText,
                "#total-final": cleaveInstances.totalFinal,
                "#bayar": cleaveBayar,
                "#kembalian": cleaveKembalian
            };

            $.each(fields, (selector, instance) => {
                $(selector).val(instance.getRawValue());
            });
        }

        function transaksi() {
            const totalAkhir = parseInt($('#total-final').val().replace(/[^\d]/g, '')) || 0;
            const bayar = parseInt($('#bayar').val().replace(/[^\d]/g, '')) || 0;
            if (bayar < totalAkhir) {
                alertCustom("Pembayaran tidak mencukupi!");
                return;
            }
            updateAllFields();

            confirmTransaction().then((result) => {
                if (result) {
                    $.ajax({
                        url: '{{ route('kasir.transaksi') }}',
                        type: 'POST',
                        dataType: 'JSON',
                        data: $('#formKasir').serialize(),
                        success: function (response) {
                            if (response.success) {
                                iziToast.success({
                                    title: 'Sukses',
                                    message: 'Transaksi berhasil diproses',
                                    position: 'topRight',
                                    timeout: 3000,
                                    transitionIn: 'fadeInUp',
                                    transitionOut: 'fadeOutDown'
                                });

                                $('#formKasir').trigger('reset');

                                $.each(cleaveInstances, function (key, instance) {
                                    instance.setRawValue(0);
                                });
                                cleaveBayar.setRawValue(0);
                                cleaveKembalian.setRawValue(0);

                                $('#data-pembelanjaan').find('.data-row').remove();
                                $('#data-pembelanjaan').find('.data-kosong').show();
                                $('#formKasir').find('input[name^="detail_transaksi"]').remove();
                                detailIndex = 0;

                                populatePelanggan();
                                populateBarang();

                                bootbox.dialog({
                                    message: '<div id="invoiceContent" style="min-height: 300px;">Loading invoice...</div>',
                                    onShown: function () {
                                        $("#invoiceContent").load("{{ route('kasir.invoice') }}/" + response.transaksiId);
                                    },
                                    size: 'large',
                                    className: 'modal-custom'
                                });
                                $('.bootbox').addClass('custom-dialog-size');
                            } else {
                                iziToast.error({
                                    title: 'Error',
                                    message: response.message,
                                    position: 'topRight',
                                    timeout: 3000,
                                    transitionIn: 'fadeInUp',
                                    transitionOut: 'fadeOutDown'
                                });
                            }
                        },
                        error: function (error) {
                            var response = JSON.parse(error.responseText);
                        }
                    });
                }
            });
        }
    </script>
@endpush
