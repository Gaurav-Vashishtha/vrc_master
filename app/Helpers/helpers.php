<?php

use App\Models\Brands;
use App\Models\BrandManufacturer;
use App\Models\BrandMarketer;
use App\Models\Category;
use App\Models\DeliveryBoy;
use App\Models\SubCategory;
use App\Models\User;
use App\Models\ProductType;
use Carbon\Carbon;
use App\Models\Notification;
use Illuminate\Support\Facades\Session;

if (!function_exists('getActiveSellers')) {
    function getActiveSellers()
    {
        $data = User::where('usertype', 2)
                        ->where('status',1)->get();

        return $data;
    }
}

if (!function_exists('getAdmins')) {
    function getAdmins() {
        return User::where('usertype', 1)
            ->where('status', 1)
            ->pluck('id')
            ->toArray();
    }
}


if (!function_exists('getAllEmployees')) {
    function getAllEmployees()
    {
        $data = User::where('usertype', 3)->where('status', 1)->where('is_deleted', '0')->orderby('first_name', 'asc')->get();
        return $data;
    }
}


if (!function_exists('getUserRoleByID')) {
    function getUserRoleByID($id) {

        $data = '';


        $user = User::where('id', $id)->first();
        if ($user) {
           if ($user->usertype=='1') {
            $data = 'Admin';
           }elseif ($user->usertype=='2'){
            $data = 'Seller';
           }else {
            $data = 'User';
           }
        }

        return $data;
    }
}


if (!function_exists('getAllCategory')) {
    function getAllCategory() {
        $user = Session::get('users');
        $admin_ids = getAdmins();
        $ids = $admin_ids;

        if ($user && isset($user['id'])) {
            $ids[] = $user['id'];
        }

        return Category::whereIn('created_by', $ids)->where('status', '1')->orderBy('created_at', 'desc')->get();
    }
}

if (!function_exists('getAllSubcategory')) {
    function getAllSubcategory($id) {
        $user = Session::get('users');
        $admin_ids = getAdmins();
        $ids = $admin_ids;

        if ($user && isset($user['id'])) {
            $ids[] = $user['id'];
        }

        return SubCategory::whereIn('created_by', $ids)->where('category_id', $id)->where('status', '1')->orderBy('created_at', 'desc')->get();
    }
}


if (!function_exists('getAllProductType')) {
    function getAllProductType($id) {
        $user = Session::get('users');
        $admin_ids = getAdmins();
        $ids = $admin_ids;

        if ($user && isset($user['id'])) {
            $ids[] = $user['id'];
        }

        return ProductType::whereIn('created_by', $ids)->where('subcategory_id', $id)->where('status', '1')->orderBy('created_at', 'desc')->get();
    }
}



if (!function_exists('getUserFullNameByID')) {
    function getUserFullNameByID($id) {

        $data = '';
        $user = User::where('id', $id)->first();
        if ($user) {
           $data = $user->first_name.' '.$user->last_name;
        }

        return $data;
    }
}


if (!function_exists('getUserDeviceTokenByUserID')) {
    function getUserDeviceTokenByUserID($id) {

        $data = '';
        $user = User::where('id', $id)->first();
        if ($user) {
           $data = $user->fcm_token;
        }

        return $data;
    }
}


if (!function_exists('getUserDeviceTokenByDboyID')) {
    function getUserDeviceTokenByDboyID($id) {

        $data = '';
        $user = DeliveryBoy::where('id', $id)->first();
        if ($user) {
           $data = $user->fcm_token;
        }

        return $data;
    }
}


if (!function_exists('getDeliveryBoyNameById')) {
    function getDeliveryBoyNameById($id) {

        $data = '';
        $user = DeliveryBoy::where('id', $id)->first();
        if ($user) {
           $data = $user->first_name.' '.$user->last_name;
        }

        return $data;
    }
}


if (!function_exists('getAllBrands')) {
    function getAllBrands() {
        $user = Session::get('users');
        $admin_ids = getAdmins();
        $ids = $admin_ids;

        if ($user && isset($user['id'])) {
            $ids[] = $user['id'];
        }

        return Brands::whereIn('created_by', $ids)->where('status', '1')->orderBy('created_at', 'desc')->get();
    }
}


if (!function_exists('getAllBrandMnf')) {
    function getAllBrandMnf($id) {
        return BrandManufacturer::where('brand_id', $id)->where('status', '1')->orderBy('created_at', 'desc')->get();
    }
}


if (!function_exists('getAllBrandMrk')) {
    function getAllBrandMrk($id) {
        return BrandMarketer::where('brand_id', $id)->where('status', '1')->orderBy('created_at', 'desc')->get();
    }
}


if (!function_exists('saturdaysOff')) {
    function saturdaysOff(): array
    {
        return [
            '1' => false, // First Saturday: Working
            '2' => false, // Second Saturday: Working
            '3' => true,  // Third Saturday: Off
            '4' => false, // Fourth Saturday: Working
            '5' => false,  // Fifth Saturday: Working
        ];
    }
}

if (!function_exists('isSaturdayOff')) {
    function isSaturdayOff(Carbon $date): bool
    {
        if (!$date->isSaturday()) {
            return false;
        }

        // Determine which Saturday of the month this is.
        $weekNumber = (int) ceil($date->day / 7);
        return saturdaysOff()[(string) $weekNumber] ?? false;
    }
}


if (!function_exists('getUserNotificationByID')) {
    function getUserNotificationByID($id)
    {
        return Notification::where('user_id', $id)->where('status', 'Unseen')->get();
    }
}
