<?php
namespace App\Imports;

use App\Models\Category;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Session;
use Maatwebsite\Excel\Row;
use Maatwebsite\Excel\Concerns\OnEachRow;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class CategoryImport implements OnEachRow, WithHeadingRow
{
    public $failures = [];

    public function onRow(Row $row)
    {
        $rowIndex = $row->getIndex();
        $rowData = $row->toArray();

        $user = Session::get('users');
        $user_id = $user['id'] ?? 1;

        $validator = Validator::make($rowData, [
            'name'           => 'required|string|max:255|unique:category,name,NULL,id,created_by,' . $user_id,
            // 'image'          => 'nullable|string|max:255',
            'status'         => 'required|in:0,1',
            'display_order'  => 'nullable|integer',
        ]);

        if ($validator->fails()) {
            $this->failures[] = [
                'row'     => $rowIndex,
                'data'    => $rowData,
                'errors'  => $validator->errors()->all(),
            ];
            return;
        }

        Category::create([
            'created_by'    => $user_id,
            'name'          => $rowData['name'],
            // 'image'         => 'uploads/category_images/'.$rowData['image'] ?? null,
            'status'        => $rowData['status'],
            'display_order' => $rowData['display_order'] ?? 0,
        ]);
    }
}