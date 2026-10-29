<?php

namespace App\Exports;

use App\Models\SubCategory;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class SubcategoryExport implements FromCollection, WithHeadings
{
    /**
     * Fetch the data for export
     */
    public function collection()
    {
        return SubCategory::with('category:id,name') // relation load
            ->select('id', 'category_id', 'name', 'image', 'status', 'display_order')
            ->get()
            ->map(function ($subcategory) {
                return [
                    'ID'            => $subcategory->id,
                    'Category'      => $subcategory->category ? $subcategory->category->name : '',
                    'Name'          => $subcategory->name,
                    'Image'         => basename($subcategory->image),
                    'Status'        => $subcategory->status == 1 ? 'active' : 'inactive',
                    'Display Order' => $subcategory->display_order,
                ];
            });
    }

    /**
     * Define the Excel headings
     */
    public function headings(): array
    {
        return ['ID', 'Category', 'Name', 'Image', 'Status', 'Display Order'];
    }
}
