function alertDestroy() {
    return swal({
        title: "Apakah Anda Yakin?",
        text: "Proses ini tidak bisa di batalkan",
        icon: "warning",
        buttons: true,
        dangerMode: true,
    }).then((result) => result);
}

$.fn.Form = function() {
    $.each(this, function(key, elem) {
        $('.select2', elem).each(function(key, elem) {
            var containerCssClass = '';

            if ($(elem).hasClass('form-control-sm')) {
                containerCssClass = 'select2-sm';
            }

            if ($(elem).parents('.dataTables_filter').length == 0) {
                $(elem).css('width', '100%');
            }

            if ($(elem).parents('.bootbox.modal').length == 1) {
                $(elem).select2({
                    dropdownParent: $('.bootbox.modal'),
                    containerCssClass: containerCssClass,
                    dropdownAutoWidth: true
                });
            } else if ($(elem).parents('.modal').length == 1) {
                $(elem).select2({
                    dropdownParent: $('.modal'),
                    containerCssClass: containerCssClass,
                    dropdownAutoWidth: true
                });
            } else {
                $(elem).select2({
                    containerCssClass: containerCssClass,
                    dropdownAutoWidth: true
                });
            }
        });
    });
};

