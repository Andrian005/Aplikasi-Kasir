function alertDestroy() {
    return swal({
        title: "Apakah Anda Yakin?",
        text: "Proses ini tidak bisa di batalkan",
        icon: "warning",
        buttons: true,
        dangerMode: true,
    }).then((result) => result);
}

function alertCustom(message) {
    return swal({
        title: "Peringatan!",
        text: message,
        icon: "warning",
        button: "OK",
    });
}

$.fn.Form = function () {
    $.each(this, function (key, elem) {
        $(".select2", elem).each(function (key, elem) {
            var containerCssClass = "";

            if ($(elem).hasClass("form-control-sm")) {
                containerCssClass = "select2-sm";
            }

            if ($(elem).parents(".dataTables_filter").length == 0) {
                $(elem).css("width", "100%");
            }

            if ($(elem).parents(".bootbox.modal").length == 1) {
                $(elem).select2({
                    dropdownParent: $(".bootbox.modal"),
                    containerCssClass: containerCssClass,
                    dropdownAutoWidth: true,
                });
            } else if ($(elem).parents(".modal").length == 1) {
                $(elem).select2({
                    dropdownParent: $(".modal"),
                    containerCssClass: containerCssClass,
                    dropdownAutoWidth: true,
                });
            } else {
                $(elem).select2({
                    containerCssClass: containerCssClass,
                    dropdownAutoWidth: true,
                });
            }
        });
        $(".phone-number", elem).each(function () {
            let cleave = new Cleave(this, {
                phone: true,
                phoneRegionCode: "ID",
                delimiter: "",
                blocks: [13],
                numericOnly: true,
            });

            $(this).on("input", function () {
                let value = $(this).val();
                if (!value.startsWith("8")) {
                    $(this).val("");
                }
            });
        });

        $(".kode", elem).each(function () {
            new Cleave(this, {
                delimiter: "-",
                blocks: [10]
            });
            $(this).on("keydown", function (e) {
                if (e.keyCode === 32) {
                    e.preventDefault();
                }
            });
            $(this).on("input", function () {
                $(this).val($(this).val().replace(/\s/g, '').toUpperCase());
            });
        });
    });

    $(document).ready(function () {
        document.querySelectorAll(".currency").forEach(function (field) {
            new Cleave(field, {
                numeral: true,
                numeralThousandsGroupStyle: "thousand",
            });
        });

        document.querySelectorAll(".number").forEach(function (field) {
            new Cleave(field, {
                numeral: true,
                numeralThousandsGroupStyle: "none",
                numeralDecimalScale: 0,
            });
        });

        new Cleave(".kode", {
            delimiter: "-",
            blocks: [10],
            uppercase: true,
        });

        new Cleave(".phone-number", {
            phone: true,
            phoneRegionCode: "ID",
        });

        $(".datepicker1").datepicker({
            format: "yyyy-mm-dd",
            drops: "down",
            opens: "right",
        });
    });
};
