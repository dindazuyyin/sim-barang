// Pencarian barang
const cari = document.getElementById("cari");

cari.addEventListener("input", function () {
    const kata = cari.value.toLowerCase();

    document.querySelectorAll("#daftarBarang tr").forEach(row => {
        row.style.display = row.textContent.toLowerCase().includes(kata)
            ? ""
            : "none";
    });
});

// Validasi formulir
const form = document.getElementById("barangForm");
const toast = document.getElementById("toast");

form.addEventListener("submit", function (event) {
    event.preventDefault();

    const kode = document.getElementById("kode").value.trim();
    const jumlah = Number(document.getElementById("jumlah").value);

    if (!/^BRG-\d+$/.test(kode)) {
        alert("Kode barang harus berformat BRG-001!");
        return;
    }

    if (jumlah <= 0 || !Number.isFinite(jumlah)) {
        alert("Jumlah barang harus lebih dari 0!");
        return;
    }

    toast.textContent = "Data barang berhasil divalidasi!";
    toast.style.display = "block";

    setTimeout(() => {
        toast.style.display = "none";
    }, 3000);

    form.reset();
});
