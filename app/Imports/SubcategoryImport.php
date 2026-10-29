<?php

namespace App\Imports;

use App\Models\Category;
use App\Models\SubCategory;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Session;
use Maatwebsite\Excel\Row;
use Maatwebsite\Excel\Concerns\OnEachRow;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\SkipsOnFailure;
use Maatwebsite\Excel\Concerns\SkipsFailures;
use Illuminate\Validation\Rule;

class SubcategoryImport implements OnEachRow, WithHeadingRow, SkipsOnFailure
{
    use SkipsFailures;

    public function onRow(Row $row)
    {
        $rowIndex = $row->getIndex();
        $rowData = $row->toArray();

        $user = Session::get('users');
        $user_id = $user['id'] ?? 1;

        $category = Category::where('name', $rowData['category'])->first();
        $category_id = $category->id ?? null;

        $validator = Validator::make($rowData, [
            'category'       => 'required|string|max:255|exists:category,name',
            'name'           => [
                                'required',
                                'string',
                                'max:255', 
                                Rule::unique('sub_categories', 'name')
                                    ->where('created_by', $user_id)
                                    ->where('category_id', $category_id)
                            ],
            'status'         => 'required|in:0,1',
            'display_order'  => 'nullable|integer',
        ]);


        if ($validator->fails()) {
            $this->failures[] = [
                'row'     => $rowIndex,
                'data'    => $rowData,
                'errors'  => $validator->errors()->all(),
            ];
            return false;
        }


        $category_id = Category::where('name', $rowData['category'])->value('id');

        SubCategory::create([
            'created_by'    => $user_id,
            'category_id'   => $category_id,
            'name'          => $rowData['name'],
            // 'image'         => 'uploads/category_images/'.$rowData['image'] ?? null,
            'status'        => $rowData['status'],
            'display_order' => $rowData['display_order'] ?? 0,
        ]);
    }
}
