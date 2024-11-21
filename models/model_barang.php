<?php
require_once 'nodes/node_barang.php';
class modelBarang
{
    private $barangs = [];
    private $nextId = 1;
    private $objBarang;


    public function __construct()
    {
        if (isset($_SESSION['barangs'])) {
            $this->barangs = unserialize($_SESSION['barangs']);
            $this->nextId = count($this->barangs) + 1;
        } else {
            $this->initiliazeDefaultBarang();
        }
    }

    public function initiliazeDefaultBarang()
    {
        $this->addBarang("RTX 4060", 400000);
        $this->addBarang("Intel I9 13k", 8000000);
        $this->addBarang("Ryzen 9 9900x", 9000000);
    }

    public function addBarang($barangName, $hargaBarang)
    {
        //        echo $this->nextId;
        $this->objBarang = new Barang($this->nextId++, $barangName, $hargaBarang);
        $this->barangs[] = $this->objBarang;
        $this->saveToSession();
    }

    private function saveToSession()
    {
        $_SESSION['barangs'] = serialize($this->barangs);
    }

    public function getAllBarangs()
    {
        return $this->barangs;
    }

    public function getListBarang()
    {
        $listBarang = [];
        foreach ($this->barangs as $barang) {
            $listBarang[] = $barang->namaBarang;
        }
        return $listBarang;
    }

    public function getBarangById($id)
    {
        foreach ($this->barangs as $barang) {
            if ($barang->idBarang == $id) {
                return $barang;
            }
        }
        return null;
    }

    public function updateBarang($id, $barangName, $hargaBarang)
    {
        foreach ($this->barangs as $barang) {
            if ($barang->idBarang == $id) {
                $barang->nameBarang = $barangName;
                $barang->hargaBarang = $hargaBarang;
                $this->saveToSession();
                return true;
            }
        }
        return false;
    }

    // public function deleteBarang($id)
    // {
    //     foreach ($this->barangs as $key => $barang) {
    //         if ($barang->idBarang == $id) {
    //             unset($this->barangs[$key]);
    //             $this->saveToSession();
    //             return true;
    //         }
    //     }
    //     return false;
    // }
    public function deleteBarang($idBarang)
    {
        foreach ($this->barangs as $key => $barang) {
            if ($barang->idBarang == $idBarang) {
                unset($this->barangs[$key]); // Hapus role dari array
                $this->barangs = array_values($this->barangs); // Reset indeks array
                $this->reorderRoleIds(); // Panggil fungsi untuk mereset ID
                $this->saveToSession();
                return true;
            }
        }
        return false;
    }

    private function reorderRoleIds()
    {
        foreach ($this->barangs as $index => $barang) {
            $barang->idBarang = $index + 1; // Set ulang ID berdasarkan indeks
        }
        $this->nextId = count($this->barangs) + 1; // Perbarui nextId untuk addRole berikutnya
    }
}
