function alertDestroy() {
    return swal({
        title: "Apakah Anda Yakin?",
        text: "Proses ini tidak bisa di batalkan",
        icon: "warning",
        buttons: true,
        dangerMode: true,
    }).then((result) => result);
}


