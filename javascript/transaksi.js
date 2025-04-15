document.addEventListener("DOMContentLoaded", function () {
    // Elemen untuk pencarian pelanggan
    const btnCariPelanggan = document.getElementById("btnCariPelanggan");
    const inputSearchPelanggan = document.getElementById("searchPelanggan");
    const listPelanggan = document.getElementById("listPelanggan");
    const namaPelanggan = document.getElementById("NamaPelanggan");
    const alamat = document.getElementById("Alamat");
    const telepon = document.getElementById("NomorTelepon");

    // Fungsi untuk mencari pelanggan berdasarkan ID
    btnCariPelanggan.addEventListener("click", function () {
        const pelangganID = inputSearchPelanggan.value.trim();

        if (pelangganID === "") {
            alert("Masukkan ID Pelanggan terlebih dahulu.");
            return;
        }

        // Mengirim permintaan ke server untuk mencari pelanggan berdasarkan ID
        fetch(`../config/proses-transaksi.php?id=${pelangganID}`)
            .then(response => response.json())
            .then(data => {
                if (data) {
                    // Isi form dengan data pelanggan yang ditemukan
                    inputSearchPelanggan.value = data.PelangganID;
                    namaPelanggan.value = data.NamaPelanggan;
                    alamat.value = data.Alamat;
                    telepon.value = data.NomorTelepon;

                    // Menampilkan hasil pencarian di bawah
                    listPelanggan.innerHTML = `<li class="list-group-item">Pelanggan ditemukan: ${data.NamaPelanggan}</li>`;
                } else {
                    // Jika pelanggan tidak ditemukan
                    listPelanggan.innerHTML = '<li class="list-group-item text-danger">Pelanggan tidak ditemukan</li>';
                    alert("Pelanggan tidak ditemukan");
                }
            })
            .catch(error => {
                console.error("Error fetching pelanggan:", error);
                listPelanggan.innerHTML = '<li class="list-group-item text-danger">Terjadi kesalahan, coba lagi</li>';
            });
    });

    // Elemen untuk perhitungan kembalian
    const totalInput = document.getElementById('total-pembelian');
    const bayarInput = document.getElementById('bayar');
    const kembalianInput = document.getElementById('kembalian');

    // Fungsi untuk menghitung kembalian
    function hitungKembalian() {
        const total = parseInt(totalInput.value);
        const bayar = parseInt(bayarInput.value);

        if (!isNaN(bayar)) {
            const kembalian = bayar - total;

            if (kembalian >= 0) {
                kembalianInput.value = 'Rp ' + kembalian.toLocaleString('id-ID');
            } else {
                kembalianInput.value = 'Uang kurang!';
            }
        } else {
            kembalianInput.value = '';
        }
    }

    // Event listener untuk input pembayaran
    bayarInput.addEventListener('input', hitungKembalian);
});