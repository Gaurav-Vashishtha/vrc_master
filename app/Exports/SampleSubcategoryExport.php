<?php

namespace App\Exports;

use App\Models\SubCategory;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;

class SampleSubcategoryExport implements FromArray, WithHeadings
{
    public function array(): array
    {
        return [
            ['category name','Sample SubCategory', 1, 1],
        ];
    }

    public function headings(): array
    {
        return ['category','name','status', 'display_order'];
    }
}
