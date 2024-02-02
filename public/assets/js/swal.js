const SUCCESS_ALERT = (text=null) => Swal.fire({
    title: "Berhasil",
    text: text ? text : "Berhasil menyimpan data",
    icon: "success",
    showConfirmButton: false,
    timer: 1500
});

const ERROR_ALERT = (text = null) => Swal.fire({
    title: "Gagal",
    text: text ? text : "Gagal menyimpan data",
    icon: "error",
    showConfirmButton: false,
    timer: 1500
});
