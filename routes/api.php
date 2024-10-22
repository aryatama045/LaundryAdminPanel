<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Web\PaymentController;
use App\Http\Controllers\API\Auth\AuthController;
use App\Http\Controllers\API\User\UserController;
use App\Http\Controllers\API\Order\OrderController;

use App\Http\Controllers\API\Banner\BannerController;
use App\Http\Controllers\API\Coupon\CouponController;
use App\Http\Controllers\API\Master\masterController;
use App\Http\Controllers\API\Rating\RatingController;
use App\Http\Controllers\API\Address\AddressController;
use App\Http\Controllers\API\Product\ProductController;
use App\Http\Controllers\API\Service\ServiceController;
use App\Http\Controllers\API\Setting\SettingController;
use App\Http\Controllers\API\Variant\VariantController;
use App\Http\Controllers\API\Contacts\ContactController;
use App\Http\Controllers\API\Customers\CustomerController;
use App\Http\Controllers\API\Auth\ForgotPasswordController;
use App\Http\Controllers\API\Promotion\PromotionController;
use App\Http\Controllers\API\Additional\AdditionalServiceController;
use App\Http\Controllers\API\Admin\Auth\LoginController;
use App\Http\Controllers\API\Payment\PaymentController as PaymentControllerApi;
use App\Http\Controllers\API\PostCode\PostCodeController;
use App\Http\Controllers\API\Admin\dashboard\dashboardController;
use App\Http\Controllers\API\Admin\order\OrderController as AdminOrderController;
use App\Http\Controllers\API\AreaController;
use App\Http\Controllers\API\Customers\CardController;
use App\Http\Controllers\API\Driver\Auth\LoginController as DriverLoginController;
use App\Http\Controllers\API\Driver\Dashboard\DashboardController as DriverDashboardController;
use App\Http\Controllers\API\Driver\Notifications\DriverNotificationController;
use App\Http\Controllers\API\Notifications\NotificationsController;
use App\Http\Controllers\API\Social\SocialLinkController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
*/

Route::get('/privacy-policy', function () {
    return view('settings.privacy-policy');
});

Route::middleware('guest:api')->group(function () {
    Route::post('/register', [AuthController::class, 'register']);
    Route::post('/login', [AuthController::class, 'login']);
    Route::post('/forgot-password', [ForgotPasswordController::class, 'forgotPassword']);
    Route::post('/forgot-password/otp/verify', [ForgotPasswordController::class, 'verifyOtp']);
    Route::post('/reset-password', [ForgotPasswordController::class, 'resetPassword']);
});
Route::get('/social-link', [SocialLinkController::class, 'index']);

Route::controller(AreaController::class)->group(function () {
    Route::get('/areas', 'index');
});

Route::post('/resend/otp', [AuthController::class, 'resendOTP']);

Route::middleware(['auth:api', 'role:customer'])->group(function () {
    Route::post('/coupons/{coupon:code}/apply', [CouponController::class, 'apply']);
    Route::get('/orders', [OrderController::class, 'index']);
    Route::post('/orders', [OrderController::class, 'store']);
    Route::put('/orders/{order}', [OrderController::class, 'update']);
    Route::get('/orders/{id}/details', [OrderController::class, 'show']);

    Route::post('/users/update', [UserController::class, 'update']);
    Route::post('/users/profile-photo/update', [UserController::class, 'updateProfilePhoto']);
    Route::post('/users/change-password', [UserController::class, 'changePassword']);

    Route::get('/customers', [CustomerController::class, 'show']);

    Route::get('/card-list', [CardController::class, 'index']);
    Route::post('/cards', [CardController::class, 'store']);

    Route::get('/addresses', [AddressController::class, 'index']);
    Route::post('/addresses', [AddressController::class, 'store']);
    Route::post('/addresses/{address}', [AddressController::class, 'update']);
    Route::delete('/addresses/{address}', [AddressController::class, 'delete']);

    Route::post('/logout', [AuthController::class, 'logout']);

    Route::get('/ratings', [RatingController::class, 'index']);
    Route::post('/ratings', [RatingController::class, 'store']);

    Route::post('/contact/verify', [AuthController::class, 'mobileVerify']);

    Route::get('/pick-schedules/{date}', [OrderController::class, 'pickSchedule']);
    Route::get('/delivery-schedules/{date}', [OrderController::class, 'deliverySchedule']);

    Route::post('/payments', [PaymentControllerApi::class, 'store']);

    Route::get('/notifications', [NotificationsController::class, 'index']);
    Route::post('/notifications', [NotificationsController::class, 'store']);
    Route::post('/notifications/{notification}', [NotificationsController::class, 'update']);
    Route::delete('/notifications/{notification}', [NotificationsController::class, 'delete']);
});

Route::get('/payments/{orderId}/{cardId}', [PaymentController::class, 'index']);

Route::get('/banners', [BannerController::class, 'index']);
Route::get('/promotions', [PromotionController::class, 'index']);
Route::get('/services', [ServiceController::class, 'index']);
Route::get('/additional-services', [AdditionalServiceController::class, 'index']);
Route::get('/variants', [VariantController::class, 'index']);
Route::get('/products', [ProductController::class, 'index']);
Route::get('/legal-pages/{page:slug}', [SettingController::class, 'show']);

Route::post('/contacts', [ContactController::class, 'store']);

Route::get('/master', [masterController::class, 'index']);

Route::get('/post-code', [PostCodeController::class, 'index']);


// =========Route for Admin==========

Route::post('/admin/login', [LoginController::class, 'login']);

Route::group(['prefix' => '/admin', 'middleware' => ['auth:api', 'role:admin']], function () {
    Route::get('/dashboard', [dashboardController::class, 'index']);
    Route::get('/orders', [AdminOrderController::class, 'index']);
    Route::get('/orders/{id}', [AdminOrderController::class, 'orderDetails']);
    Route::get('/orders/{order}/update-status', [AdminOrderController::class, 'statusUpdate']);
    Route::get('/orders-status', [dashboardController::class, 'status']);

    Route::get('/logout', [LoginController::class, 'logout']);
});

// ==========Route for Driver==========

Route::post('/driver/login', [DriverLoginController::class, 'login'])->name('driver.login');

Route::group(['prefix' => '/driver', 'middleware' => ['auth:api', 'role:driver']], function () {

    Route::get('/user', [DriverLoginController::class, 'show']);
    Route::get('/user/{user}/toggle-status', [CustomerController::class, 'toggleStatus']);
    Route::delete('/{user}/delete', [DriverLoginController::class, 'delete']);
    Route::post('/profile-update', [UserController::class, 'update']);
    Route::post('/profile-photo/update', [UserController::class, 'updateProfilePhoto']);
    Route::post('/change-password', [DriverLoginController::class, 'changePassword']);

    Route::controller(DriverDashboardController::class)->group(function () {
        Route::get('/accept-order/{order}', 'acceptOrder');
        Route::get('/todays', 'today');
        Route::get('/todays-pending', 'todayPending');
        Route::get('/today-orders', 'todayOrders');
        Route::get('/this-week', 'thisWeek');
        Route::get('/last-week', 'lastWeek');
        Route::get('/total-orders', 'totalOrder');
        Route::get('/order-histories', 'history');

        Route::get('/orders/{id}', 'orderDetails');
        Route::get('/orders/{order}/update', 'statusUpdate');
    });

    Route::get('/orders-status', [dashboardController::class, 'status']);

    Route::get('/notifications', [DriverNotificationController::class, 'index']);
    Route::post('/notifications', [DriverNotificationController::class, 'store']);
    Route::post('/notifications/{notification}', [DriverNotificationController::class, 'update']);
    Route::delete('/notifications/{notification}', [DriverNotificationController::class, 'delete']);

    Route::get('/logout', [DriverLoginController::class, 'logout']);
});
