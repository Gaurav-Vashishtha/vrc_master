<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\V1\Admin\AdminDashboardController;
use App\Http\Controllers\Api\V1\CartController;
use App\Http\Controllers\Api\V1\FrontendController;
use App\Http\Controllers\Api\V1\StoreController;
use App\Http\Controllers\Api\V1\UserAddressController;
use App\Http\Controllers\Api\V1\OrderController;
use App\Http\Controllers\Api\V1\BannerController;
use App\Http\Controllers\Api\V1\ContactController;
use App\Http\Controllers\Api\V1\UserController;
use App\Http\Controllers\Api\V1\ProjectListApiController;
use App\Http\Controllers\Api\V1\UserLeaveApiController;
use App\Http\Controllers\Api\ChatbotControllerV4;
use App\Http\Controllers\Api\ChatbotControllerV5;
use App\Http\Controllers\Api\V1\AdminTestimonialApiController;
use App\Http\Controllers\Api\V1\IPOContactUsController;
use App\Http\Controllers\Api\V1\IPOContactLandingController;


Route::namespace('Api')->group(function () {

    Route::post('v4/chatbot/create-thread', [ChatbotControllerV4::class, 'createThread']);
    Route::post('v4/chatbot/send-message', [ChatbotControllerV4::class, 'sendMessage']);
    Route::post('v4/contact', [ChatbotControllerV4::class, 'sendContact']);

    Route::post('v5/chatbot/create-thread', [ChatbotControllerV5::class, 'createThread']);
    Route::post('v5/chatbot/send-message', [ChatbotControllerV5::class, 'sendMessage']);
    Route::post('v5/contact', [ChatbotControllerV5::class, 'sendContact']);
});



Route::prefix('v1')->group(function () {

    Route::post('forgotPassword', [UserController::class,'forgotPassword'])->name('forgotPassword');

    // Route::post('admin/login', [AdminDashboardController::class, 'adminLogin']);
    // Route::post('admin/change-password', [AdminDashboardController::class, 'adminChangePassword']);

    Route::get('login', [UserController::class, 'Unauthenticated'])->name('login');
    Route::post('user/login', [UserController::class, 'login']);
    Route::post('user/change-password', [UserController::class, 'changePassword']);
    Route::post('user/logout', [UserController::class, 'logout']);

    Route::get('/testimonials', [AdminTestimonialApiController::class, 'index']);
    Route::post('/testimonials', [AdminTestimonialApiController::class, 'store']);

    // IPO
    Route::post('/ipo-contactus', [IPOContactUsController::class, 'store']);
    Route::post('/ipo-contact-landing', [IPOContactLandingController::class, 'store']);

    //Project List


    Route::middleware(['auth:api'])->group(function () {    

        Route::get('user/project-list', [AdminDashboardController::class, 'index']);
        Route::get('user/workReportApiList', [AdminDashboardController::class, 'workReportApiList']);
        Route::get('user/workReportDetailApi/{id}', [AdminDashboardController::class, 'workReportDetailApi']);
        Route::post('user/addWorkReportApi', [AdminDashboardController::class, 'addWorkReportApi']);
        Route::get('user/holidayListApi', [AdminDashboardController::class, 'holidayListApi']);
        Route::post('user/leaveApplyApi', [UserLeaveApiController::class, 'leaveApplyApi']);
        Route::get('user/leaveListApi', [UserLeaveApiController::class, 'leaveListApi']);
        Route::get('user/leaveDetailApi/{id}', [UserLeaveApiController::class, 'leaveDetailApi']);
        Route::get('user/notificationListApi', [AdminDashboardController::class, 'notificationListApi']);
        Route::get('user/newsListApi', [AdminDashboardController::class, 'newsListApi']);



    });
});




