<?php

namespace App\Import;

use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

use File;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Validator;

use App\Models\Admin\BarangmasukModel;
use App\Models\Admin\BarangModel;
use App\Models\Admin\JenisBarangModel;
use App\Models\Admin\KategoriModel;
use App\Models\Admin\MerkModel;
use App\Models\Admin\SatuanModel;


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


    }
    public function headingRow(): int {
        return 1;
    }


}
