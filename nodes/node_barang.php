<?php
class Barang
{
    public $idBarang;
    public $nameBarang;
    public $hargaBarang;
    public $banyakBarang;

    public function __construct($idBarang, $namaBarang, $harga, $banyakBarang)
    {
        $this->idBarang = $idBarang;
        $this->nameBarang = $namaBarang;
        $this->hargaBarang = $harga;
        $this->banyakBarang = $banyakBarang;
    }
}
