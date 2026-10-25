
"use strict";

// Pencarian barang
const cari = document.getElementById("cari");

if (cari) {
    cari.addEventListener("input", function () {
        const kata = cari.value.toLowerCase();

        document.querySelectorAll("#daftarBarang tr").forEach(row => {
            row.style.display = row.textContent.toLowerCase().includes(kata)
                ? ""
                : "none";
        });
    });
}

// Validasi sebelum formulir dikirim ke PHP
const form = document.getElementById("barangForm");

if (form) {
    form.addEventListener("submit", function (event) {
        const kode = document.getElementById("kode").value.trim();
        const jumlah = Number(document.getElementById("jumlah").value);

        if (!/^BRG-\d+$/.test(kode)) {
            event.preventDefault();
            alert("Kode barang harus berformat BRG-001!");
            return;
        }

        if (jumlah <= 0 || !Number.isFinite(jumlah)) {
            event.preventDefault();
            alert("Jumlah barang harus lebih dari 0!");
        }
    });
}
