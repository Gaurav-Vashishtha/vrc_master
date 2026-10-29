<?php

namespace App\Exports;

use App\Models\Category;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class CategoryExport implements FromCollection, WithHeadings
{
    public function collection()
    {
        return Category::select('id', 'name', 'image', 'status', 'display_order')
        ->get()
        ->map(function ($category) {
            $category->image = basename($category->image);
            return $category;
        });
    }

    public function headings(): array
    {
        return ['ID', 'Name', 'Image', 'Status', 'Display Order'];
    }
}