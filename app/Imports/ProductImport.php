<?php

namespace App\Imports;

use App\Models\Brands;
use App\Models\BrandMarketer;
use App\Models\BrandManufacturer;
use App\Models\Product;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\SkipsOnFailure;
use Maatwebsite\Excel\Concerns\SkipsFailures;
use Maatwebsite\Excel\Concerns\Importable;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class ProductImport implements ToCollection, WithHeadingRow, SkipsOnFailure
{
    use Importable, SkipsFailures;

    protected $sellerId;
    protected $categoryId;
    protected $subcategoryId;
    protected $typeId;

    public function __construct($sellerId, $categoryId, $subcategoryId, $typeId = null)
    {
        $this->sellerId = $sellerId;
        $this->categoryId = $categoryId;
        $this->subcategoryId = $subcategoryId;
        $this->typeId = $typeId;
    }

    public function collection(Collection $rows)
    {
        $user = Session::get('users');
        $user_id = $user['id'] ?? 1;
        DB::beginTransaction();

        foreach ($rows as $row) {

            $brand      = trim($row['brand'] ?? '');
            $mnfnameadd = trim($row['mnfnameadd'] ?? '');
            $mrknameadd = trim($row['mrknameadd'] ?? '');

            // --- BRAND ---
            $brandData = null;
            if ($brand !== '') {
                $brandData = Brands::whereRaw('LOWER(name) = ?', [strtolower($brand)])->first();
                if (!$brandData) {
                    $brandData = Brands::create([
                        'name'       => $brand,
                        'created_by' => $user_id,
                        'status'     => 1
                    ]);
                }
            }

            // --- MANUFACTURER ---
            $mnfnameaddData = null;
            if ($mnfnameadd !== '') {
                $mnfParts   = explode('~', $mnfnameadd);
                $mnfname    = trim($mnfParts[0] ?? '');
                $mnfaddress = trim($mnfParts[1] ?? '');

                if ($mnfname !== '' && $mnfaddress !== '' && $brandData) {
                    $mnfnameaddData = BrandManufacturer::whereRaw('LOWER(name) = ?', [strtolower($mnfname)])
                        ->whereRaw('LOWER(address) = ?', [strtolower($mnfaddress)])
                        ->first();

                    if (!$mnfnameaddData) {
                        $mnfnameaddData = BrandManufacturer::create([
                            'brand_id' => $brandData->id,
                            'name'     => $mnfname,
                            'address'  => $mnfaddress,
                            'status'   => 1
                        ]);
                    }
                }
            }

            // --- MARKETER ---
            $mrknameaddData = null;
            if ($mrknameadd !== '') {
                $mrkParts   = explode('~', $mrknameadd);
                $mrkname    = trim($mrkParts[0] ?? '');
                $mrkaddress = trim($mrkParts[1] ?? '');

                if ($mrkname !== '' && $mrkaddress !== '' && $brandData) {
                    $mrknameaddData = BrandMarketer::whereRaw('LOWER(name) = ?', [strtolower($mrkname)])
                        ->whereRaw('LOWER(address) = ?', [strtolower($mrkaddress)])
                        ->first();

                    if (!$mrknameaddData) {
                        $mrknameaddData = BrandMarketer::create([
                            'brand_id' => $brandData->id,
                            'name'     => $mrkname,
                            'address'  => $mrkaddress,
                            'status'   => 1
                        ]);
                    }
                }
            }


            $highlights = trim($row['highlights'] ?? '');
            $highlightsArray = [];

            if ($highlights !== '') {
                $pairs = explode(',', $highlights);

                foreach ($pairs as $pair) {
                    $parts = explode(':', $pair, 2); // limit to 2 parts (key and value)
                    if (count($parts) === 2) {
                        $key = trim($parts[0]);
                        $value = trim($parts[1]);
                        $highlightsArray[] = [
                            'key'   => $key,
                            'value' => $value
                        ];
                    }
                }
            }

            $status = 0;
            if($row['status']=='active'){
                $status = 1;
            }

            // --- PRODUCT DATA ---
            $data = [
                'name'              => $row['name'] ?? null,
                'sku'               => $row['sku'] ?? null,
                'barcode'           => $row['barcode'] ?? null,
                'cost_price'        => $row['cost_price'] ?? null,
                'price'             => $row['price'] ?? null,
                'quantity_details'  => $row['quantity_details'] ?? null,
                'quantity'          => $row['quantity'] ?? null,
                'low_stock_alert'   => $row['low_stock_alert'] ?? null,
                'brand_id'          => $brandData->id ?? null,
                'mnfNameAdd_id'        => $mnfnameaddData->id ?? null,
                'mrkNameAdd_id'        => $mrknameaddData->id ?? null,
                'food_type'         => $row['food_type'] ?? 'NA',
                'fssai_license'     => $row['fssai_license'] ?? null,
                'shelf_life'        => $row['shelf_life'] ?? null,
                'origin_country'    => $row['origin_country'] ?? null,
                'fssai_seller'      => $row['fssai_seller'] ?? null,
                'expiry_date'       => $row['expiry_date'] ?? null,
                'restock_date'      => $row['restock_date'] ?? null,
                'highlights'        => !empty($highlightsArray) ? json_encode($highlightsArray) : null,
                'description'       => $row['description'] ?? null,
                'key_features'      => $row['key_features'] ?? null,
                'ingredients'       => $row['ingredients'] ?? null,
                'status'            => $status,
                'seller_id'         => $this->sellerId,
                'category_id'       => $this->categoryId,
                'subcategory_id'    => $this->subcategoryId,
                'type_id'           => $this->typeId,
                'created_by'        => $user_id,
            ];

            // --- VALIDATION ---
            $validator = Validator::make($data, [
                'name'            => 'required|string|max:255',
                'sku'             => 'required|string|max:100|unique:products,sku',
                'brand_id'        => 'required|numeric',
                'cost_price'      => 'required|numeric|min:0',
                'price'           => 'required|numeric|min:0',
                'quantity'        => 'required|integer|min:0',
                'low_stock_alert' => 'nullable|integer|min:0',
                'expiry_date'     => 'nullable|date',
                'restock_date'    => 'nullable|date',
            ]);

            if ($validator->fails()) {
                $this->onFailure(new \Maatwebsite\Excel\Validators\Failure(
                    0,
                    'row',
                    $validator->errors()->all(),
                    $row->toArray()
                ));
                continue;
            }

            Product::create($data);
        }
        DB::commit();
    }
}