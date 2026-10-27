"use strict";

// Fungsi menampilkan notifikasi
function tampilkanPesan(pesan, warna) {
    const toast = document.getElementById("toast");

    if (!toast) return;

    toast.textContent = pesan;
    toast.style.background = warna;
    toast.style.display = "block";

    setTimeout(() => {
        toast.style.display = "none";
    }, 3000);
}

// Validasi formulir
const form = document.getElementById("barangForm");

if (form) {
    form.addEventListener("submit", function(event) {
        const kode = document.getElementById("kode").value.trim();
        const jumlah = Number(document.getElementById("jumlah").value);

        if (!/^BRG-\d+$/.test(kode)) {
            event.preventDefault();
            tampilkanPesan("Kode harus berformat BRG-001!", "#dc2626");
        } else if (jumlah <= 0 || !Number.isFinite(jumlah)) {
            event.preventDefault();
            tampilkanPesan("Jumlah harus lebih dari 0!", "#dc2626");
        }
    });
}

// Pencarian barang secara real-time
const cari = document.getElementById("cari");
const tabel = document.getElementById("daftarBarang");

if (cari && tabel) {
    cari.addEventListener("input", function() {
        const kata = cari.value.toLowerCase();
        const baris = tabel.querySelectorAll("tr");

        baris.forEach((tr, index) => {
            if (index === 0) return;

            tr.style.display = tr.textContent.toLowerCase().includes(kata)
                ? ""
                : "none";
        });
    });
}
