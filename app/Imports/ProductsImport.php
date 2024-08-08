<?php

namespace App\Imports;

use App\Models\Import;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class ProductsImport implements ToModel, WithHeadingRow
{
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        return new Import([
            'unique_code' => $row['unique_code'],
            'name' => $row['name'],
            'contact_number' => $row['contact_number'],
            'address' => $row['address'],
            'location_1' => $row['location_1'],
            'location_2' => $row['location_2'],
            'location_3' => $row['location_3'],
            'pin_code' => $row['pin_code'],
            'status' => $row['status'],

        ]);
    }
}
