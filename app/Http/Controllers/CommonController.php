<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Brands;
use App\Models\BrandManufacturer;
use App\Models\BrandMarketer;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Password;

class CommonController extends Controller
{
    //

    public function getAllSubcategory($id){
        $subcategories = getAllSubcategory($id);
        return response()->json(['subcategories' => $subcategories]);
    }

    public function getAllProductType($id){
        $types = getAllProductType($id);
        return response()->json(['types' => $types]);
    }


    public function getMnfMktDetails($id)
    {
        $brand = Brands::findOrFail($id);

        // Get related manufacturers
        $manufacturers = getAllBrandMnf($id);

        // Get related marketers
        $marketers = getAllBrandMrk($id);

        return response()->json([
            'manufacturers' => $manufacturers,
            'marketers' => $marketers,
        ]);
    }


    public function runProductQuery()
    {
        die();
        set_time_limit(0);

        $skuid = 301;
        $seller_id = 628;

        $products = DB::table('products')
            ->where('seller_id', 116)
            ->where('status', 1)
            ->orderBy('id', 'ASC')
            ->get();

        foreach ($products as $row) {

            $sku = 'VBR' . $seller_id . $skuid++;

            $newId = DB::table('products')->insertGetId([
                'name' => $row->name,
                'sku' => $sku,
                'barcode' => $row->barcode,
                'cost_price' => $row->cost_price,
                'price' => $row->price,
                'quantity_details' => $row->quantity_details,
                'quantity' => $row->quantity,
                'low_stock_alert' => $row->low_stock_alert,
                'category_id' => $row->category_id,
                'subcategory_id' => $row->subcategory_id,
                'type_id' => $row->type_id,
                'brand_id' => $row->brand_id,
                'mnfNameAdd_id' => $row->mnfNameAdd_id,
                'mrkNameAdd_id' => $row->mrkNameAdd_id,
                'seller_id' => $seller_id,
                'food_type' => $row->food_type,
                'fssai_license' => $row->fssai_license,
                'shelf_life' => $row->shelf_life,
                'origin_country' => $row->origin_country,
                'fssai_seller' => $row->fssai_seller,
                'expiry_date' => $row->expiry_date,
                'restock_date' => $row->restock_date,
                'description' => $row->description,
                'key_features' => $row->key_features,
                'ingredients' => $row->ingredients,
                'highlights' => $row->highlights,
                'status' => $row->status,
                'created_by' => $row->created_by,
                'updated_by' => $row->updated_by,
                'created_at' => $row->created_at,
                'updated_at' => $row->updated_at,
            ]);

            // Copy images
            $images = DB::table('product_images')
                ->where('product_id', $row->id)
                ->get();

            foreach ($images as $img) {
                DB::table('product_images')->insert([
                    'product_id' => $newId,
                    'image' => $img->image,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }

        return response()->json([
            'message' => "Vendor $seller_id updated successfully",
            'last_sku' => $skuid
        ]);
    }


    

    public function reset(Request $request)
    {
        $request->validate([
            'token' => 'required',
            'email' => 'required|email',
            'password' => 'required|confirmed|min:6',
        ]);

        $user = null;

        $status = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function ($u, $password) use (&$user) {
                $u->password = Hash::make($password);
                $u->setRememberToken(Str::random(60));
                $u->save();

                $user = $u;
            }
        );

        if ($status == Password::PASSWORD_RESET && $user) {
            if ($user->role_id == '1') {
                return redirect('admin/login')->with('status', __($status));
            } elseif ($user->role_id == '2') {
                return redirect('company/login')->with('status', __($status));
            } else {
                return redirect('user/login')->with('status', __($status));
            }
        } else {
            return back()->withErrors(['email' => [__($status)]]);
        }
    }
}
