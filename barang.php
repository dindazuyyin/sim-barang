
<?php
class Barang {
    public $nama;
    public $jumlah;
    public $harga;

    public function __construct($nama, $jumlah, $harga) {
        $this->nama = $nama;
        $this->jumlah = $jumlah;
        $this->harga = $harga;
    }

    public function hitungTotal() {
        return $this->jumlah * $this->harga;
    }
}
?>
