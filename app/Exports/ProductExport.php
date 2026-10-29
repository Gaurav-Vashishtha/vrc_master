<?php

namespace App\Exports;

use App\Models\Product;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class ProductExport implements FromCollection, WithHeadings
{
    public function collection()
    {
        return Product::with([
            'category:id,name',
            'subcategory:id,name',
            'productType:id,name',
            'brand:id,name',
            'manufacturer:id,name,address',
            'marketer:id,name,address',
        ])
        ->select(
            'id',
            'name',
            'sku',
            'barcode',
            'category_id',
            'subcategory_id',
            'type_id',
            'brand_id',
            'mnfNameAdd_id',
            'mrkNameAdd_id',
            'food_type',
            'fssai_license',
            'shelf_life',
            'origin_country',
            'quantity_details',
            'cost_price',
            'price',
            'quantity',
            'seller_id',
            'fssai_seller',
            'low_stock_alert',
            'status',
            'expiry_date',
            'restock_date',
            'description',
            'ingredients',
            'highlights',
            'created_at'
        )
        ->get()
        ->map(function ($product) {
            return [
                'ID'               => $product->id,
                'Name'             => $product->name,
                'SKU'              => $product->sku,
                'Barcode'          => $product->barcode,
                'Category'         => optional($product->category)->name,
                'Subcategory'      => optional($product->subcategory)->name,
                'Type'             => optional($product->productType)->name,
                'Brand'            => optional($product->brand)->name,
                'Manufacturer'     => optional($product->manufacturer)->name.', '.optional($product->manufacturer)->address,
                'Marketer'         => optional($product->marketer)->name.', '.optional($product->marketer)->address,
                'Food Type'        => $product->food_type,
                'FSSAI License'    => $product->fssai_license,
                'Shelf Life'       => $product->shelf_life,
                'Origin Country'   => $product->origin_country,
                'Quantity Details' => $product->quantity_details,
                'Cost Price'       => $product->cost_price,
                'Price'            => $product->price,
                'Quantity'         => $product->quantity,
                'Seller'           => getUserFullNameByID($product->seller_id),
                'FSSAI Seller'     => $product->fssai_seller,
                'Low Stock Alert'  => $product->low_stock_alert,
                'Status'           => $product->status ? 'active' : 'inactive',
                'Expiry Date'      => $product->expiry_date,
                'Restock Date'     => $product->restock_date,
                'Description'      => $product->description,
                'Ingredients'      => $product->ingredients,
                'Highlights'       => $product->highlights,
                'Highlights'       => collect(json_decode($product->highlights, true))->map(fn($item) => "{$item['key']}: {$item['value']}")->implode(', '),
                'Created At'       => date('Y-m-d H:i:s', strtotime($product->created_at)),
                'Updated At'       => date('Y-m-d H:i:s', strtotime($product->updated_at)),
            ];
        });
    }

    public function headings(): array
    {
        return [
            'ID',
            'Name',
            'SKU',
            'Barcode',
            'Category',
            'Subcategory',
            'Type',
            'Brand',
            'Manufacturer',
            'Marketer',
            'Food Type',
            'FSSAI License',
            'Shelf Life',
            'Origin Country',
            'Quantity Details',
            'Cost Price',
            'Price',
            'Quantity',
            'Seller',
            'FSSAI Seller',
            'Low Stock Alert',
            'Status',
            'Expiry Date',
            'Restock Date',
            'Description',
            'Ingredients',
            'Highlights',
            'Created At',
        ];
    }
}
