<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;

class SampleProductExport implements FromArray, WithHeadings
{
    public function array(): array
    {
        return [
            [
                'Organic Rice',          // name
                'SKU-001',               // sku
                'BAR123456',             // barcode
                45.00,                   // cost_price
                60.00,                   // price
                '5 Kg',                  // quantity_details
                10,                      // quantity
                3,                       // low_stock_alert
                'NatureFresh',           // brand
                'NatureFresh ~ ABC Manufacturers', // mnfNameAdd
                'NatureFresh ~ XYZ Marketers',     // mrkNameAdd
                'Veg',                   // food_type
                'FSSAI123456',           // fssai_license
                '6 Months',              // shelf_life
                'India',                 // origin_country
                'Yes',                   // fssai_seller
                '2025-12-31',            // expiry_date
                '2025-08-20',            // restock_date
                'Aroma: Rich, Texture: Soft, Purity: 100%, Shelf Appeal: Excellent', // highlights
                'Premium quality organic rice.', // description
                'Long grain, Chemical-free', // key_features
                'Organic rice grains',       // ingredients
                'active'                     // status
            ],
            [
                'Almond Cookies',        // name
                'SKU-002',               // sku
                'BAR654321',             // barcode
                120.00,                  // cost_price
                150.00,                  // price
                'Box of 12',             // quantity_details
                25,                      // quantity
                5,                       // low_stock_alert
                'BakeHouse',             // brand
                'BakeHouse ~ Cookie Manufacturers',  // mnfNameAdd
                'BakeHouse ~ Sweet World Marketers', // mrkNameAdd
                'Veg',                   // food_type
                'FSSAI987654',           // fssai_license
                '3 months',              // shelf_life
                'India',                 // origin_country
                'Yes',                   // fssai_seller
                '2025-11-15',            // expiry_date
                '2025-09-01',            // restock_date
                'Crunchiness: High, Sweetness: Medium, Nut Content: Rich, Shelf Appeal: Excellent',  // highlights
                'Freshly baked almond cookies.', // description
                'Crispy, Nutty flavor',  // key_features
                'Flour, Almonds, Sugar', // ingredients
                'inactive'               // status
            ],
        ];
    }

    public function headings(): array
    {
        return [
            'name',
            'sku',
            'barcode',
            'cost_price',
            'price',
            'quantity_details',
            'quantity',
            'low_stock_alert',
            'brand',
            'mnfNameAdd',
            'mrkNameAdd',
            'food_type',
            'fssai_license',
            'shelf_life',
            'origin_country',
            'fssai_seller',
            'expiry_date',
            'restock_date',
            'highlights',
            'description',
            'key_features',
            'ingredients',
            'status',
        ];
    }
}