<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Artisan;
use App\Http\Middleware\IsLoggedIn;
use App\Http\Middleware\AdminValidation;
use App\Http\Middleware\UserValidation;
use App\Http\Middleware\SellerValidation;


use App\Http\Controllers\CommonController;

// Admin Controllers
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\AdminAttendanceController;
use App\Http\Controllers\Admin\BrandController;
use App\Http\Controllers\Admin\BrandManufacturersController;
use App\Http\Controllers\Admin\BrandMarketersController;
use App\Http\Controllers\Admin\RatingController;
use App\Http\Controllers\Admin\WeeklyRatingController;
use App\Http\Controllers\Admin\ClientController;
use App\Http\Controllers\Admin\NotificationController;
use App\Http\Controllers\Admin\MeetingController;
use App\Http\Controllers\Admin\InvoiceController;
use App\Http\Controllers\Admin\PaymentTransactionController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\SubCategoryController;
use App\Http\Controllers\Admin\CouponController;
use App\Http\Controllers\Admin\StoreController;
use App\Http\Controllers\Admin\AdminProductController;
use App\Http\Controllers\Admin\AdminUsersController;
use App\Http\Controllers\Admin\ProductTypeController;
use App\Http\Controllers\Admin\OrderController;
use App\Http\Controllers\Admin\DeliveryChargeController;
use App\Http\Controllers\Admin\ExtraChargeController;
use App\Http\Controllers\Admin\DeliveryBoyController;
use App\Http\Controllers\Admin\BannerController;
use App\Http\Controllers\Admin\SpecialBannerController;
use App\Http\Controllers\Admin\ReportController;
use App\Http\Controllers\Admin\DeliveryReportController;
use App\Http\Controllers\Admin\AdminContactsController;
use App\Http\Controllers\Admin\AdminPasswordController;
use App\Http\Controllers\Admin\AdminCareerController;
use App\Http\Controllers\Admin\AdminMlmQueriesController;
use App\Http\Controllers\Admin\AdminUsersLogController;
use App\Http\Controllers\Admin\AdminNewsController;
use App\Http\Controllers\Admin\AdminHolidayController;
use App\Http\Controllers\Admin\AdminProjectsController;
use App\Http\Controllers\Admin\AdminWorkReportsController;
use App\Http\Controllers\Admin\AdminLeaveController;
use App\Http\Controllers\Admin\AdminChatBoxController;
use App\Http\Controllers\Admin\AdminCheckIpAddressController;
use App\Http\Controllers\Admin\AdminTestimonialController;
use App\Http\Controllers\Admin\AdminNotesController;
use App\Http\Controllers\Admin\AdminWebsitesController;
use App\Http\Controllers\Admin\AdminServersController;
use App\Http\Controllers\Admin\AdminIPOController;
use App\Http\Controllers\Admin\AdminReminderController;


// User Controllers
use App\Http\Controllers\User\UserLeaveController;
use App\Http\Controllers\User\UserHolidayController;
use App\Http\Controllers\User\UserAttendanceController;
use App\Http\Controllers\User\UserWebsitesController;
use App\Http\Controllers\User\UserServersController;
use App\Http\Controllers\User\UserReminderController;
use App\Http\Controllers\User\UserNotificationController;

// Auth Controllers
use App\Http\Controllers\Auth\loginController;
use App\Http\Controllers\Auth\logOutController;
use App\Http\Controllers\Auth\RegistrationController;
use App\Http\Controllers\User\UserLoginController;
use App\Http\Controllers\User\UserWorkReportsController;
use App\Http\Controllers\User\UserNotesController;


// Welcome & Index
Route::get('/admin/index1', fn() => view('admin.index1'));


Route::any('admin/logout', [logOutController::class, 'logoutAdmin']);
Route::any('admin/login', [loginController::class, 'loginAdmin'])->name('admin.login');
Route::get('admin', function () {
    return redirect('admin/dashboard');
});
Route::get('user', function () {
    return redirect('user/dashboard');
});


Route::get('user/login', [UserLoginController::class, 'showLoginForm'])->name('user.login');
Route::post('user/login', [UserLoginController::class, 'login'])->name('user.login.post');
Route::any('user/logout', [UserLoginController::class, 'logout'])->name('user.logout');
Route::get('user/dashboard', [UserLoginController::class, 'dashboard'])->name('user.dashboard');
Route::get('user/change-password', [UserLoginController::class, 'changePassword'])->name('user.change.password');
Route::post('user/update-password', [UserLoginController::class, 'updatePassword'])->name('user.update.password');

Route::get('/password/reset/{token}', function ($token) {
    return view('user.reset-password', ['token' => $token]);
})->name('password.reset');
Route::post('/password/reset', [CommonController::class, 'reset'])->name('password.update');

Route::middleware([AdminValidation::class])->group(function () {
    Route::get('/admin/dashboard', [AdminController::class, 'dashboard']);


    // Employee Registration
    Route::get('/admin/emp-registration', [RegistrationController::class, 'index']);
    Route::post('/admin/new-emp-registration', [RegistrationController::class, 'store']);
    Route::get('/admin/all-employee', [RegistrationController::class, 'view']);
    Route::get('/admin/edit-employee-{id}', [RegistrationController::class, 'edit']);
    Route::post('/admin/update-employee-{id}', [RegistrationController::class, 'update']);
    Route::get('/admin/delete-employee-{id}', [RegistrationController::class, 'delete']);
});


Route::prefix('admin')->name('admin.')->middleware([AdminValidation::class])->group(function () {

    //Contacts List 
    Route::get('/contacts-list', [AdminContactsController::class, 'index'])->name('contactList');
    Route::get('/contacts-view/{id}', [AdminContactsController::class, 'view'])->name('contact.view');
    Route::delete('/contacts-delete/{id}', [AdminContactsController::class, 'delete'])->name('contact.delete');
    Route::get('/contacts-export', [AdminContactsController::class, 'export'])->name('contacts.export');

    //Check Ip Address
    Route::get('/admin-setting', [AdminCheckIpAddressController::class, 'index']);
    Route::post('/required-ip/update', [AdminCheckIpAddressController::class, 'update'])->name('second-master.update');

    //Password Change
    Route::get('change-password', [AdminPasswordController::class, 'changePasswordForm']);
    Route::post('change-password', [AdminPasswordController::class, 'changePassword']);


    // Settings
    Route::get('setting', [AdminController::class, 'underDevelopmentSeller']);

    //Career
    Route::get('/careers-list', [AdminCareerController::class, 'index'])->name('career.List');
    Route::get('/careers-export', [AdminCareerController::class, 'export'])->name('career.export');

    //MLM Queries
    Route::get('/mlm-queries', [AdminMlmQueriesController::class, 'index'])->name('mlm.queries');
    Route::get('/mlm-queries-export', [AdminMlmQueriesController::class, 'export'])->name('mlm.queries.export');

    //Users
    Route::get('/users-list', [AdminUsersController::class, 'index'])->name('users.index');
    Route::get('/users-create', [AdminUsersController::class, 'create'])->name('users.create');
    Route::post('/users-store', [AdminUsersController::class, 'store'])->name('users.store');
    Route::get('/users-view/{id}', [AdminUsersController::class, 'view'])->name('users.view');
    Route::get('/users-edit/{id}', [AdminUsersController::class, 'edit'])->name('users.edit');
    Route::post('/users-update/{id}', [AdminUsersController::class, 'update'])->name('users.update');
    Route::delete('/users-delete/{id}', [AdminUsersController::class, 'delete'])->name('users.delete');
    Route::get('/users-export', [AdminUsersController::class, 'export'])->name('users.export');

    //user logs
    Route::get('/user-logs', [AdminUsersLogController::class, 'userLogs'])->name('users.logs');
    Route::get('/user-logs-export', [AdminUsersLogController::class, 'export'])->name('users.logs.export');

    //News
    Route::get('/news', [AdminNewsController::class, 'index'])->name('news.index');
    Route::get('/news/create', [AdminNewsController::class, 'create'])->name('news.create');
    Route::post('/news/store', [AdminNewsController::class, 'store'])->name('news.store');
    Route::get('/news/edit/{id}', [AdminNewsController::class, 'edit'])->name('news.edit');
    Route::post('/news/update/{id}', [AdminNewsController::class, 'update'])->name('news.update');
    Route::get('/news/delete/{id}', [AdminNewsController::class, 'delete'])->name('news.delete');

    //Holiday Leave
    Route::get('/holiday-list', [AdminHolidayController::class, 'index'])->name('holiday.list');
    Route::get('/holiday-create', [AdminHolidayController::class, 'create'])->name('holiday.create');
    Route::post('/holiday-store', [AdminHolidayController::class, 'store'])->name('holiday.store');

    //Projects
    Route::get('/projects-list', [AdminProjectsController::class, 'index'])->name('projects.list');
    Route::get('/project-create', [AdminProjectsController::class, 'create'])->name('projects.create');
    Route::post('/project-store', [AdminProjectsController::class, 'store'])->name('projects.store');

    //Websites
    Route::get('/websites-list', [AdminWebsitesController::class, 'index'])->name('websites.index');
    Route::get('/website-create', [AdminWebsitesController::class, 'create'])->name('websites.create');
    Route::post('/website-store', [AdminWebsitesController::class, 'store'])->name('websites.store');
    Route::get('/website-edit/{id}', [AdminWebsitesController::class, 'edit'])->name('websites.edit');
    Route::put('/website-update/{id}', [AdminWebsitesController::class, 'update'])->name('websites.update');
    Route::get('/website-history/{id}', [AdminWebsitesController::class, 'history'])->name('websites.history');

    //Servers
    Route::get('/servers-list', [AdminServersController::class, 'index'])->name('servers.index');
    Route::get('/server-create', [AdminServersController::class, 'create'])->name('servers.create');
    Route::post('/server-store', [AdminServersController::class, 'store'])->name('servers.store');
    Route::get('/server-edit/{id}', [AdminServersController::class, 'edit'])->name('servers.edit');
    Route::put('/server-update/{id}', [AdminServersController::class, 'update'])->name('servers.update');
    Route::get('/server-history/{id}', [AdminServersController::class, 'history'])->name('servers.history');


    //Work Reports
    Route::get('/work-reports-list', [AdminWorkReportsController::class, 'index'])->name('work.reports.list');
    Route::get('/work-reports-create', [AdminWorkReportsController::class, 'create'])->name('work.reports.create');
    Route::post('/work-reports-store', [AdminWorkReportsController::class, 'store'])->name('work.reports.store');
    Route::get('/work-reports-delete/{id}', [AdminWorkReportsController::class, 'delete'])->name('work.reports.delete');
    Route::get('/work-reports-view/{id}', [AdminWorkReportsController::class, 'view'])->name('work.reports.view');
    Route::get('/work-reports-export', [AdminWorkReportsController::class, 'export'])->name('work.reports.export');
    //Route::get('/work-report-edit/{id}', [AdminWorkReportsController::class, 'edit'])->name('work.reports.edit');
    //Route::post('/work-report-update/{id}', [AdminWorkReportsController::class, 'update'])->name('work.reports.update');

    //Leave apply 
    Route::get('/leave-list', [AdminLeaveController::class, 'index'])->name('leave.list');
    Route::get('/leave-create', [AdminLeaveController::class, 'create'])->name('leave.create');
    Route::post('/leave-store', [AdminLeaveController::class, 'store'])->name('leave.store');
    Route::get('/leave-approve/{id}', [AdminLeaveController::class, 'approve'])->name('leave.approve');
    Route::get('/leave-reject/{id}', [AdminLeaveController::class, 'reject'])->name('leave.reject');
    Route::get('/leave-reports-export', [AdminLeaveController::class, 'export'])->name('leave.reports.export');
    Route::get('/leave/withdrawal-request/{id}', [AdminLeaveController::class, 'details'])->name('leave.details');
    Route::post('/leave/{id}/approve-withdrawal', [AdminLeaveController::class, 'approveWithdrawal'])->name('leave.approveWithdrawal');
    Route::post('/leave/{id}/reject-withdrawal', [AdminLeaveController::class, 'rejectWithdrawal'])->name('leave.rejectWithdrawal');


    //ChatBox
    Route::get('/chatbox', [AdminChatBoxController::class, 'index'])->name('chatbox.index');
    Route::get('/chatbox/{id}', [AdminChatBoxController::class, 'show'])->name('chatbox.show');
    Route::post('/chatbox/pin/{id}', [AdminChatBoxController::class, 'togglePin'])->name('chatbox.pin');

    //Attendance
    Route::get('/attendance', [AdminAttendanceController::class, 'index'])->name('attendance');
    Route::get('/attendance-reports-export', [AdminAttendanceController::class, 'export'])->name('attendance.reports.export');

    //Testimonial
    Route::get('/testimonials', [AdminTestimonialController::class, 'index'])->name('testimonials');
    Route::get('/testimonials/edit/{id}', [AdminTestimonialController::class, 'edit'])->name('testimonials.edit');
    Route::post('/testimonials/update/{id}', [AdminTestimonialController::class, 'update'])->name('testimonials.update');
    Route::get('/testimonials/status/{id}', [AdminTestimonialController::class, 'status'])->name('testimonials.status');

    //Note 
    Route::get('/notes-list', [AdminNotesController::class, 'index'])->name('notes.index');
    Route::get('/notes-create', [AdminNotesController::class, 'create'])->name('notes.create');
    Route::post('/notes-store', [AdminNotesController::class, 'store'])->name('notes.store');
    Route::get('/notes-edit/{id}', [AdminNotesController::class, 'edit'])->name('notes.edit');
    Route::post('/notes-update/{id}', [AdminNotesController::class, 'update'])->name('notes.update');
    Route::get('/notes-delete/{id}', [AdminNotesController::class, 'destroy'])->name('notes.delete');
    Route::get('/notes-view/{id}', [AdminNotesController::class, 'show'])->name('notes.show');

    //Notifications
    Route::get('/notifications', [NotificationController::class, 'index'])->name('notifications.index');
    Route::get('/notifications/create', [NotificationController::class, 'create'])->name('notifications.create');
    Route::post('/notifications', [NotificationController::class, 'store'])->name('notifications.store');
    Route::delete('/notifications/{id}', [NotificationController::class, 'destroy'])->name('notifications.destroy');

    //Reminder
    Route::get('/reminders', [AdminReminderController::class, 'index'])->name('reminders');
    Route::post('/reminders/store', [AdminReminderController::class, 'store'])->name('reminders.store');
    Route::get('/reminders/edit/{id}', [AdminReminderController::class, 'edit'])->name('reminders.edit');
    Route::post('/reminders/update/{id}', [AdminReminderController::class, 'update'])->name('reminders.update');
    Route::get('/reminders/delete/{id}', [AdminReminderController::class, 'destroy'])->name('reminders.delete');
    Route::get('/reminders/complete/{id}', [AdminReminderController::class, 'complete'])->name('reminders.complete');
    Route::get('/reminders/status/{id}', [AdminReminderController::class, 'status'])->name('reminders.status');
    Route::get('/reminders/create', [AdminReminderController::class, 'create'])->name('reminders.create');
    Route::get('/reminders/view/{id}', [AdminReminderController::class, 'show'])->name('reminders.show');


    // IOP Contact Us
    Route::get('/ipo-contactus', [AdminIPOController::class, 'ipoContactUs'])->name('ipo.contactus');
    Route::get('/ipo-contactus-view/{id}', [AdminIPOController::class, 'ipoContactUsView'])->name('ipo.contactusView');
    Route::get('/ipo-contactus-export', [AdminIPOController::class, 'ipocontactsExport'])->name('ipo.contactsExport');
    Route::get('/ipo-contact-landing', [AdminIPOController::class, 'ipoContactLanding'])->name('ipo.contactusLanding');
    Route::get('/ipo-contact-landing-view/{id}', [AdminIPOController::class, 'ipoContactLandingView'])->name('ipo.contactusLandingView');
    Route::get('/ipo-contact-landing-export', [AdminIPOController::class, 'ipocontactsLandingExport'])->name('ipo.contactsLandingExport');
});

Route::prefix('user')->name('user.')->middleware([UserValidation::class])->group(function () {

    //Notifications
    Route::get('/notification/count', [UserNotificationController::class, 'notificationCount'])->name('notification.count');
    Route::get('/notifications', [UserNotificationController::class, 'index'])->name('notifications.index');
    Route::get('/notifications/{id}', [UserNotificationController::class, 'show'])->name('notifications.show');

    // Leave Apply
    Route::get('/leave-list', [UserLeaveController::class, 'index'])->name('leave.list');
    Route::get('/leave-create', [UserLeaveController::class, 'create'])->name('leave.create');
    Route::post('/leave-store', [UserLeaveController::class, 'store'])->name('leave.store');
    Route::get('/leave/withdrawal-request/{id}', [UserLeaveController::class, 'details'])->name('leave.details');
    Route::post('/leave/{id}/withdrawal-request', [UserLeaveController::class, 'requestWithdrawal'])->name('leave.withdrawal.request');

    //Holidays
    Route::get('/holiday-list', [UserHolidayController::class, 'index'])->name('holiday.list');


    //Work Reports
    Route::get('/work-reports-list', [UserWorkReportsController::class, 'index'])->name('work.reports.list');
    Route::get('/work-reports-create', [UserWorkReportsController::class, 'create'])->name('work.reports.create');
    Route::post('/work-reports-store', [UserWorkReportsController::class, 'store'])->name('work.reports.store');
    Route::get('/work-reports-view/{id}', [UserWorkReportsController::class, 'view'])->name('work.reports.view');
    Route::get('/work-reports-delete/{id}', [UserWorkReportsController::class, 'delete'])->name('work.reports.delete');

    //Notes
    Route::get('/notes-list', [UserNotesController::class, 'index'])->name('notes.index');
    Route::get('/notes-create', [UserNotesController::class, 'create'])->name('notes.create');
    Route::post('/notes-store', [UserNotesController::class, 'store'])->name('notes.store');
    Route::get('/notes-edit/{id}', [UserNotesController::class, 'edit'])->name('notes.edit');
    Route::post('/notes-update/{id}', [UserNotesController::class, 'update'])->name('notes.update');
    Route::get('/notes-delete/{id}', [UserNotesController::class, 'destroy'])->name('notes.delete');
    Route::get('/notes-view/{id}', [UserNotesController::class, 'show'])->name('notes.show');

    //Attendance
    Route::get('/attendance', [UserAttendanceController::class, 'index'])->name('attendance');
    Route::get('/attendance-reports-export', [UserAttendanceController::class, 'export'])->name('attendance.reports.export');

    //Reminder
    Route::get('/reminders', [UserReminderController::class, 'index'])->name('reminders');
    Route::post('/reminders/store', [UserReminderController::class, 'store'])->name('reminders.store');
    Route::get('/reminders/edit/{id}', [UserReminderController::class, 'edit'])->name('reminders.edit');
    Route::post('/reminders/update/{id}', [UserReminderController::class, 'update'])->name('reminders.update');
    Route::get('/reminders/delete/{id}', [UserReminderController::class, 'destroy'])->name('reminders.delete');
    Route::get('/reminders/complete/{id}', [UserReminderController::class, 'complete'])->name('reminders.complete');
    Route::get('/reminders/status/{id}', [UserReminderController::class, 'status'])->name('reminders.status');
    Route::get('/reminders/create', [UserReminderController::class, 'create'])->name('reminders.create');
    Route::get('/reminders/view/{id}', [UserReminderController::class, 'show'])->name('reminders.show');

    
    //Websites
    Route::get('/websites-list', [UserWebsitesController::class, 'index'])->name('websites.index');
    Route::get('/website-history/{id}', [UserWebsitesController::class, 'history'])->name('websites.history');
    Route::post('/website-check/{id}', [UserWebsitesController::class, 'storeCheck'])->name('websites.storeCheck');
    
    //Servers
    Route::get('/servers-list', [UserServersController::class, 'index'])->name('servers.index');
    Route::get('/server-history/{id}', [UserServersController::class, 'history'])->name('servers.history');
    Route::post('/server-check/{id}', [UserServersController::class, 'storeCheck'])->name('servers.storeCheck');
});



Route::get('/category/{id}/subcategories', [CommonController::class, 'getAllSubcategory']);
Route::get('/subcategory/{id}/types', [CommonController::class, 'getAllProductType']);
Route::get('/brands/{id}/details', [CommonController::class, 'getMnfMktDetails']);


Route::get('/clear-cache', function () {
    Artisan::call('optimize:clear');
    return 'All caches cleared successfully!';
});


Route::get('/v4', function () {
    return view('chatAI/chatbotV4');
});

Route::get('/v5', function () {
    return view('chatAI/chatbotV5');
});
