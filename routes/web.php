<?php

use App\Http\Controllers\API\Order\OrderController as ApiOrderController;
use App\Http\Controllers\FCMController;
use App\Http\Controllers\NotificationManageController;
use App\Http\Controllers\Web\AreaController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Web\PaymentController;
use App\Http\Controllers\Web\DashboardController;
use App\Http\Controllers\Web\Auth\LoginController;
use App\Http\Controllers\Web\Banners\BannerController;
use App\Http\Controllers\Web\Products\OrderController;
use App\Http\Controllers\Web\Products\CouponController;
use App\Http\Controllers\Web\Setting\SettingController;
use App\Http\Controllers\Web\Contacts\ContactController;
use App\Http\Controllers\Web\Products\ProductController;
use App\Http\Controllers\Web\Revenues\RevenueController;
use App\Http\Controllers\Web\Services\ServiceController;
use App\Http\Controllers\Web\Variants\VariantController;

use App\Http\Controllers\Web\Customers\CustomerController;
use App\Http\Controllers\Web\Customers\CustomerGaransiController;
use App\Http\Controllers\Web\Customers\CustomerKlaimController;

use App\Http\Controllers\Web\DeliveryCost\DeliveryCostController;
use App\Http\Controllers\Web\Driver\DriverController;
use App\Http\Controllers\Web\InvoiceManageController;
use App\Http\Controllers\Web\MailConfigurationController;
use App\Http\Controllers\Web\MobileAppUrl\MobileAppUrlController;
use App\Http\Controllers\Web\OrderScheduleController;
use App\Http\Controllers\Web\NotificationController;
use App\Http\Controllers\Web\Products\SubProductController;
use App\Http\Controllers\Web\Profile\ProfileController;
use App\Http\Controllers\Web\Root\AdminController;
use App\Http\Controllers\Web\Services\AdditionalServiceController;
use App\Http\Controllers\Web\SMSGatewaySetupController;
use App\Http\Controllers\Web\Social\SocialController;
use App\Http\Controllers\Web\StripeKeyUpateController;
use App\Http\Controllers\Web\StripePaymentController;
use App\Http\Controllers\Web\WebSettingController;
use Illuminate\Support\Facades\App;
use Spatie\Permission\Contracts\Role;

use App\Http\Controllers\Mobile\Auth\LoginMobileController;

/*
+--------------------------------------------------------------------------
+ Web Routes
+--------------------------------------------------------------------------
*/


Route::get('/login', [LoginController::class, 'index'])->name('login');
Route::post('/login', [LoginController::class, 'login'])->name('login');
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

Route::get('/daftar', [LoginController::class, 'daftar'])->name('daftar');
Route::post('/daftar_action', [LoginController::class, 'daftar_action'])->name('daftar_action');

Route::get('/daftar_sukses', [LoginController::class, 'daftar_sukses'])->name('daftar_sukses');

Route::get('/lupa_password', [LoginController::class, 'lupa_password'])->name('lupa_password');
Route::post('/lupa_password_action', [LoginController::class, 'lupa_password_action'])->name('lupa_password_action');

Route::middleware(['auth', 'role:admin|visitor|customer|root', 'permission_check'])->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('root');

    // Service routes
    Route::get('/services', [ServiceController::class, 'index'])->name('service.index');
    Route::get('/services/create', [ServiceController::class, 'create'])->name('service.create');
    Route::post('/services', [ServiceController::class, 'store'])->name('service.store');
    Route::get('/services/{service}/edit', [ServiceController::class, 'edit'])->name('service.edit');
    Route::put('/services/{service}', [ServiceController::class, 'update'])->name('service.update');
    Route::get('/services/{service}/toggle-status', [ServiceController::class, 'toggleActivationStatus'])
        ->name('service.status.toggle');
    Route::get('/services/{service}/variants', [ServiceController::class, 'getVariant'])->name('service.getVariant');

    // Additional service
    Route::get('/additional-services', [AdditionalServiceController::class, 'index'])->name('additional.index');
    Route::get('/additional-services/create', [AdditionalServiceController::class, 'create'])->name('additional.create');
    Route::post('/additional-services', [AdditionalServiceController::class, 'store'])->name('additional.store');
    Route::get('/additional-services/{additional}/edit', [AdditionalServiceController::class, 'edit'])->name('additional.edit');
    Route::put('/additional-services/{additional}', [AdditionalServiceController::class, 'update'])->name('additional.update');
    Route::get('/additional-services/{additional}/toggle-status', [AdditionalServiceController::class, 'toggleActivationStatus'])
        ->name('additional.status.toggle');

    // Variant routes
    Route::get('/variants', [VariantController::class, 'index'])->name('variant.index');
    Route::put('/variants/{variant}/', [VariantController::class, 'update'])->name('variant.update');
    Route::post('/variants', [VariantController::class, 'store'])->name('variant.store');
    Route::get('/variants/{variant}/products', [VariantController::class, 'productsVariant'])->name('variant.products');

    // Notification routes
    Route::get('/notifications', [NotificationController::class, 'index'])->name('notification.index');
    Route::post('/send-notifications', [NotificationController::class, 'sendNotification'])->name('notification.send');

    // Customer routes
    Route::get('/customers', [CustomerController::class, 'index'])->name('customer.index');
    Route::get('/customers/{customer}/show', [CustomerController::class, 'show'])->name('customer.show');
    Route::get('/customers/create', [CustomerController::class, 'create'])->name('customer.create');
    Route::post('/customers', [CustomerController::class, 'store'])->name('customer.store');
    Route::get('/customers/{customer}/edit', [CustomerController::class, 'edit'])->name('customer.edit');
    Route::put('/customers/{customer}', [CustomerController::class, 'update'])->name('customer.update');

    // Route::get('/customer/{customer}/delete', [CustomerController::class, 'delete'])->name('customer.delete');

    Route::get('/user/{user}/toggle-status', [CustomerController::class, 'toggleStatus'])->name('user.status.toggle');


    // Garansi routes
    Route::get('/garansi', [CustomerGaransiController::class, 'index'])->name('garansi.index');
    Route::get('/garansi/{garansi}/show', [CustomerGaransiController::class, 'show'])->name('garansi.show');
    Route::get('/garansi/create', [CustomerGaransiController::class, 'create'])->name('garansi.create');
    Route::post('/garansi', [CustomerGaransiController::class, 'store'])->name('garansi.store');
    Route::get('/garansi/{garansi}/edit', [CustomerGaransiController::class, 'edit'])->name('garansi.edit');
    Route::put('/garansi/{garansi}', [CustomerGaransiController::class, 'update'])->name('garansi.update');
    Route::get('/garansi/{garansi}/delete', [CustomerGaransiController::class, 'delete'])->name('garansi.delete');


    // Klaim routes
    Route::get('/klaim', [CustomerKlaimController::class, 'index'])->name('klaim.index');
    Route::get('/klaim/{klaim}/show', [CustomerKlaimController::class, 'show'])->name('klaim.show');
    Route::get('/klaim/{klaim}/proses', [CustomerKlaimController::class, 'show'])->name('klaim.proses');
    Route::post('/klaim/{klaim}', [CustomerKlaimController::class, 'proses_action'])->name('klaim.proses_action');
    Route::get('/klaim/create', [CustomerKlaimController::class, 'create'])->name('klaim.create');
    Route::post('/klaim', [CustomerKlaimController::class, 'store'])->name('klaim.store');

    Route::get('/klaim/check_validasi', [CustomerKlaimController::class, 'check_validasi'])->name('klaim.check_validasi');

    Route::get('/klaim/{klaim}/edit', [CustomerKlaimController::class, 'edit'])->name('klaim.edit');
    Route::put('/klaim/{klaim}', [CustomerKlaimController::class, 'update'])->name('klaim.update');
    Route::get('/klaim/{klaim}/delete', [CustomerKlaimController::class, 'delete'])->name('klaim.delete');



    // Product routes
    Route::controller(ProductController::class)->group(function () {
        Route::get('/products', 'index')->name('product.index');
        Route::get('/products/create', 'create')->name('product.create');
        Route::post('/products', 'store')->name('product.store');

        Route::post('/products/imports', 'imports');

        Route::get('/products/{product}/show', 'show')->name('product.show');
        Route::get('/products/{product}/edit', 'edit')->name('product.edit');
        Route::put('/products/{product}/update', 'update')->name('product.update');
        Route::get('/products/{product}/delete', 'delete')->name('product.delete');
        Route::get('/products/{product}/toggle-status', 'toggleActivationStatus')->name('product.status.toggle');
        Route::put('/products/{product}/ordering', 'orderUpdate')->name('product.update.order');
    });

    Route::post('/products/import/', [ProductController::class, 'import']);

    Route::controller(SubProductController::class)->group(function () {
        Route::get('/products/{product}/sub-product', 'index')->name('product.subproduct.index');
        Route::post('/products/{product}/sub-product/store', 'store')->name('product.subproduct.store');
        Route::put('/products/{product}/sub-product/update', 'update')->name('product.subproduct.update');
    });

    // Banner Routes
    Route::get('/web-banners', [BannerController::class, 'index'])->name('banner.index');
    Route::get('/mobile-banners', [BannerController::class, 'getPromotional'])->name('banner.promotional');
    Route::post('/banners', [BannerController::class, 'store'])->name('banner.store');
    Route::get('/banners/{banner}/edit', [BannerController::class, 'edit'])->name('banner.edit');
    Route::put('/banners/{banner}', [BannerController::class, 'update'])->name('banner.update');
    Route::delete('/banners/{banner}', [BannerController::class, 'destroy'])->name('banner.destroy');
    Route::get('/banners/{banner}/toggle-status', [BannerController::class, 'toggleActivationStatus'])
        ->name('banner.status.toggle');



    // Revenue Eoutes
    Route::get('revenues', [RevenueController::class, 'index'])->name('revenue.index');
    Route::get('revenues/generate-pdf', [RevenueController::class, 'generatePDF'])->name('revenue.generate.pdf');
    Route::get('reports/generate-pdf', [RevenueController::class, 'generateInvoicePDF'])->name('report.generate.pdf');

    // Coupon Routes
    Route::get('/coupons', [CouponController::class, 'index'])->name('coupon.index');
    Route::get('/coupons/create', [CouponController::class, 'create'])->name('coupon.create');
    Route::post('/coupons', [CouponController::class, 'store'])->name('coupon.store');
    Route::get('/coupons/{coupon}/edit', [CouponController::class, 'edit'])->name('coupon.edit');
    Route::put('/coupons/{coupon}', [CouponController::class, 'update'])->name('coupon.update');

    //Contact Routes
    Route::get('/contacts', [ContactController::class, 'index'])->name('contact');

    //Driver Routes
    Route::get('/drivers', [DriverController::class, 'index'])->name('driver.index');
    Route::get('/drivers/create', [DriverController::class, 'create'])->name('driver.create');
    Route::post('/drivers/store', [DriverController::class, 'store'])->name('driver.store');
    Route::get('/drivers-assign/{order}/{drive}', [DriverController::class, 'driverAssign'])->name('driver.assign');

    Route::get('/drivers/{driver}/details', [DriverController::class, 'details'])->name('driver.details');
    Route::get('/driver/{driver}/toggle-status', [DriverController::class, 'toggleStatus'])->name('driver.status.toggle');



    Route::controller(OrderScheduleController::class)->group(function () {
        Route::get('/{type}/scheduls', 'index')->name('schedule.index');
        Route::get('/schedules/{id}/toggle/update', 'updateStatus')->name('toggole.status.update');
        Route::put('/schedules/{orderSchedule}/update', 'update')->name('schedule.update');
    });
});



// Order Routes
Route::get('/orders', [OrderController::class, 'index'])->name('order.index');
Route::get('/orders/{order}', [OrderController::class, 'show'])->name('order.show');
Route::get('/orders/{order}/update-status', [OrderController::class, 'statusUpdate'])->name('order.status.change');
Route::get('/orders/{order}/print/labels', [OrderController::class, 'printLabels'])
    ->name('order.print.labels');
Route::get('/orders/{order}/print/invoice', [OrderController::class, 'printInvioce'])
    ->name('order.print.invioce');

//INcomplete Order Route
Route::get('/orders-incomplete', [OrderController::class, 'index'])->name('orderIncomplete.index');
Route::get('/orders/{order}/paid', [OrderController::class, 'orderPaid'])->name('orderIncomplete.paid');


//Profile
Route::get('/setting/profile', [ProfileController::class, 'index'])->name('profile.index');
Route::post('/setting/profile', [ProfileController::class, 'update'])->name('profile.update');
Route::get('/setting/profile-edit', [ProfileController::class, 'edit'])->name('profile.edit');
Route::post('/setting/profile/change-password', [ProfileController::class, 'changePassword'])->name('profile.change-password');
Route::get('/setting/profile/change-password', function () {
    return view('profile.change-password');
})->name('profile.change-password');




// access only root user.
Route::middleware(['auth', 'role:root|visitor'])->group(function () {
    // Settings Routes
    Route::get('/settings/{slug}', [SettingController::class, 'show'])->name('setting.show');
    Route::get('/settings/{slug}/edit', [SettingController::class, 'edit'])->name('setting.edit');
    Route::put('/settings/{setting}', [SettingController::class, 'update'])->name('setting.update');

    //Delivery Cost
    Route::get('/setting/delivery-cost', [DeliveryCostController::class, 'index'])->name('deliveryCost');
    Route::post('/setting/delivery-cost', [DeliveryCostController::class, 'updateOrCreate'])->name('deliveryCost');

    //Delivery Cost
    Route::get('/setting/mobile-app-link', [MobileAppUrlController::class, 'index'])->name('mobileApp');
    Route::post('/setting/mobile-app-link', [MobileAppUrlController::class, 'updateOrCreate'])->name('mobileApp');

    //Social link
    Route::get('/setting/social-link', [SocialController::class, 'index'])->name('socialLink.index');
    Route::post('/setting/social-link', [SocialController::class, 'store'])->name('socialLink.store');
    Route::post('/setting/social-link/{socialLink}', [SocialController::class, 'update'])->name('socialLink.update');
    Route::get('/setting/social-link/{socialLink}/delete', [SocialController::class, 'delete'])->name('socialLink.delete');

    Route::get('/stripe-key', [StripeKeyUpateController::class, 'index'])->name('stripeKey.index');
    Route::post('/stripe-key', [StripeKeyUpateController::class, 'update'])->name('stripeKey.update');

    Route::get('/web-setting', [WebSettingController::class, 'index'])->name(('webSetting.index'));
    Route::post('/web-setting/{webSetting?}', [WebSettingController::class, 'update'])->name(('webSetting.update'));

    Route::get('/invoice-manage', [InvoiceManageController::class, 'index'])->name(('invoiceManage.index'));
    Route::post('/invoice-manage/{invoiceManage?}', [InvoiceManageController::class, 'update'])->name(('invoiceManage.update'));

    Route::get('/customer/{customer}/delete', [CustomerController::class, 'delete'])->name('customer.delete');

    Route::controller(AdminController::class)->group(function () {
        Route::get('/admins', 'index')->name('admin.index');
        Route::get('/admins/{user}/toggle-status-update', 'toggleStatusUpdate')->name('admin.status-update');
        Route::get('/admins/create', 'create')->name('admin.create');
        Route::post('/admins', 'store')->name('admin.store');
        Route::get('/admins/{user}/edit', 'edit')->name('admin.edit');
        Route::put('/admins/{user}', 'update')->name('admin.update');
        Route::get('/admins/{user}/show', 'show')->name('admin.show');
        Route::post('/admins/{user}/set-permission', 'setPermission')->name('admin.set-permission');
    });

    // Area Route
    Route::controller(AreaController::class)->group(function () {
        Route::get('/areas', 'index')->name('areas.index');
        Route::post('/areas/store', 'store')->name('areas.store');
        Route::put('/areas/{area}/update', 'update')->name('areas.update');
        Route::get('/areas/{area}/toggle', 'toggle')->name('areas.toggle');
        Route::get('/areas/{area}/delete', 'delete')->name('areas.delete');
    });

    //  SMS Gateway
    Route::controller(SMSGatewaySetupController::class)->group(function(){
        Route::get('/sms-gateway', 'index')->name('sms-gateway.index');
        Route::put('/sms-gateway', 'update')->name('sms-gateway.update');
    });

    // Notification management
    Route::controller(NotificationManageController::class)->group(function () {
        Route::get('/notifications/manage', 'index')->name('notification.manage');
        Route::post('/notifications/update/{notificationManage}', 'update')->name('notification.manage.update');
    });

    // firebase cloud message
    Route::controller(FCMController::class)->group(function () {
        Route::get('/fcm-configuration', 'index')->name('fcm.index');
        Route::post('/fcm-configuration', 'update')->name('fcm.update');
    });

    //  mail configuration
    Route::controller(MailConfigurationController::class)->group(function () {
        Route::get('/mail-configuration', 'index')->name('mail-config.index');
        Route::put('/mail-configuration', 'update')->name('mail-config.update');
    });

});

Route::get('/order-payment/{order}/{card}', [PaymentController::class, 'payment'])->name('payment');
Route::get('/setup-intents/{customer}/{card}/{amount}/{order}', [PaymentController::class, 'intent']);
Route::get('/order-update/{order}', [PaymentController::class, 'updatePayment']);



Route::get('/check_validasi', [PaymentController::class, 'check_validasi'])->name('check_validasi');
Route::get('/new-orders', [ApiOrderController::class, 'newOrder'])->name('new.orders');
Route::get('payment', [PaymentController::class, 'testIndex']);

Route::controller(StripePaymentController::class)->group(function () {
    Route::get('/payment', 'index')->name('payment');
    Route::get('/charge', 'charge')->name('charge');
});

Route::get('change-language', function () {
    App::setLocale(\request()->ln);
    session()->put('local', \request()->ln);
    return back();
})->name('change.local');


// Mobile
Route::get('/mobile', [LoginMobileController::class, 'index'])->name('mobile');
Route::post('/mobile', [LoginMobileController::class, 'login'])->name('mobile');
Route::post('/mlogout', [LoginController::class, 'mlogout'])->name('mlogout');
