<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use App\Models\Import;
use App\Models\User;

class ExportUser implements FromCollection, WithHeadings
{
    protected $imports;

    public function __construct($imports)
    {
        $this->imports = $imports;
    }

    public function collection()
    {
        return $this->imports->map(function ($import) {
            return [
                'id' => $import->id,
                'unique_code' => $import->unique_code,
                'name' => $import->name,
                'contact_number' => $import->contact_number,
                'address' => $import->address,
                'location_1' => $import->location_1,
                'location_2' => $import->location_2,
                'location_3' => $import->location_3,
                'pin_code' => $import->pin_code,
                'status' => $import->status ? 'Active' : 'Inactive',
                'status_change_name' => $import->user->name ?? 'N/A',
            ];
        });
    }

    public function headings(): array
    {
        return [
            '#',
            'Unique Code',
            'Name',
            'Contact Number',
            'Address',
            'Location 1',
            'Location 2',
            'Location 3',
            'Pin Code',
            'Status',
            'Status Change Name',
        ];
    }
}
