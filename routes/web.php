<?php


use App\Http\Controllers\Backend\Auth\AdminAuthController;
use App\Http\Controllers\Backend\Dashboard\AdminDashboardController;
use App\Http\Controllers\Backend\ManPower\ManPowerController;
use App\Http\Controllers\Backend\Menu\MenuController;
use App\Http\Controllers\Backend\Menu\MenuItemController;
use App\Http\Controllers\Backend\Prediction\PredictionAndReportController;
use App\Http\Middleware\AdminMiddleware;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

// Apply guest middleware to login routes

    Route::get('admin-login', [AdminAuthController::class, 'adminLogin'])->name('adminLogin');
    Route::post('admin-login-request', [AdminAuthController::class, 'adminLoginRequest'])->name('adminLoginRequest');


Route::middleware([AdminMiddleware::class])->prefix('admin')->group(function () {
    Route::get('logout', [AdminAuthController::class, 'adminLogout'])->name('adminLogout');
    Route::get('dashboard', [AdminDashboardController::class, 'adminDashboard'])->name('adminDashboard');
    
    // man power routes
    Route::get('manpower-index',[ManPowerController::class,'manpowerIndex'])->name('manpowerIndex');
    Route::post('manpower-store',[ManPowerController::class,'manpowerStore'])->name('manpowerStore');
    Route::get('manpower-edit-content',[ManPowerController::class,'manpowerEditContent'])->name('manpowerEditContent');
    Route::post('manpower-update',[ManPowerController::class,'manpowerUpdate'])->name('manpowerUpdate');
    Route::get('manpower-delete',[ManPowerController::class,'manpowerDelete'])->name('manpowerDelete');

    // menu routes
    Route::get('menu-item-index',[MenuItemController::class,'menuItemIndex'])->name('menuItemIndex');
    Route::post('menu-item-store',[MenuItemController::class,'menuItemStore'])->name('menuItemStore');
    Route::get('menu-item-edit-content',[MenuItemController::class,'menuItemEditContent'])->name('menuItemEditContent');
    Route::post('menu-item-update',[MenuItemController::class,'menuItemUpdate'])->name('menuItemUpdate');
    Route::get('menu-item-delete',[MenuItemController::class,'menuItemDelete'])->name('menuItemDelete');

    // prediction and report routes
    Route::get('prediction-report-index',[PredictionAndReportController::class,'predictionReportIndex'])->name('predictionReportIndex');
});

// Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
