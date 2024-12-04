<?php

namespace App\Import;

use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

use File;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Validator;


class BarangImport implements ToCollection ,WithHeadingRow
{
    /**
    * @param Collection $collection
    */
    public function collection(Collection $collection)
    {

        Validator::make($collection->toArray(),
            [
                '*.harga'       => 'required|integer'],
            [
                '*.harga.integer'           => "Harga Harus Angka"]
        )->validate();

        foreach ($collection as $row) {

            $id = $row['name'];
            // Check already exists
            // $search = BarangModel::where('id', $id)->first();


            // if($row['jenis'])
                $slug_jenis = strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-', $row['jenis'])));
                $jenis_data = JenisBarangModel::firstOrCreate(['jenisbarang_nama' => $row['jenis'], 'jenisbarang_slug' => $slug_jenis, 'jenisbarang_ket' => '']);

            // if($row['kategori'])
                $slug_kategori = strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-', $row['kategori'])));
                $kategori       = KategoriModel::firstOrCreate(['kategori_nama' => $row['kategori'], 'kategori_slug' => $slug_kategori, 'kategori_ket' => '']);

            // if($row['merk'])
                $slug_merk = strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-', $row['merk'])));
                $merk       = MerkModel::firstOrCreate(['merk_nama' => $row['merk'], 'merk_slug' => $slug_merk, 'merk_keterangan' => '']);

            // if($row['satuan'])
                $slug_satuan = strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-', $row['satuan'])));
                $satuan_data    = SatuanModel::firstOrCreate(['satuan_nama' => $row['satuan'], 'satuan_slug' => $slug_satuan, 'satuan_keterangan' => '']);

            $product        = BarangModel::firstOrNew([ 'barang_nama'=>$row['name'] ]);

            if($row['image'])
                $product->barang_gambar = $row['image'];
            else
                $product->barang_gambar = 'image.png';


            $random = Str::random(13);

            $codeProduct = 'BRG-'.$random;
            $slug_barang = strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-', $row['name'])));

            $product->barang_kode       = $codeProduct;
            $product->barang_nama       = $row['name'];
            $product->barang_slug       = $slug_barang;
            $product->jenisbarang_id    = $jenis_data->jenisbarang_id;
            $product->kategori_id       = $kategori->kategori_id;
            $product->merk_id           = $merk->merk_id;
            $product->satuan_id         = $satuan_data->satuan_id;
            $product->barang_spek       = $row['spek'];
            $product->barang_stok       = 0;
            $product->barang_harga      = $row['harga'];

            $product->save();

        }

    }
    public function headingRow(): int {
        return 1;
    }


}
