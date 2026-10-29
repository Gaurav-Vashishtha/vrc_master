<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;

class SampleCategoryExport implements FromArray, WithHeadings
{
    public function array(): array
    {
        return [
            ['Sample Category', 1, 1],
        ];
    }

    public function headings(): array
    {
        return ['name', 'status', 'display_order'];
    }
}
