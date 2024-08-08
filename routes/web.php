<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\User\LoginController as UserLoginController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\Backend\Admin\HistoryController;
use App\Http\Controllers\Backend\Admin\BlogController;
use App\Http\Controllers\Backend\User\UserDashboardController;

// Admin login
Route::get('logout', [LoginController::class, 'logout']);

Route::prefix('/')->group(function () {
    Route::get('/', [LoginController::class, 'login'])->name('login');
    Route::post('/', [LoginController::class, 'loginAdmin'])->name('auth.loginAdmin');
    Route::post('logout', [LoginController::class, 'logout']);
    Route::get('logout', [LoginController::class, 'logout']);

    // Admin Dashboard Route
    Route::get('admin/dashboard', function() {
        return view('admin.dashboard');
    })->name('admin.dashboard');

    // User Dashboard Route
    Route::get('user/dashboard', function() {
        return view('user.dashboard');
    })->name('user.dashboard');

    // Admin Dashboard
    Route::group([
        'namespace' => 'Backend\Admin',
        'prefix' => 'admin',
        'as' => 'admin.',
        'middleware' => 'auth:admin'
    ], function () {
        require base_path('routes/backend/admin.php');
    });

    // Import
    Route::prefix('admin')->middleware(['auth:admin'])->group(function () {
        Route::get('history', [HistoryController::class, 'index'])->name('admin.history.index');
        Route::get('history/{id}', [HistoryController::class, 'show'])->name('admin.history.show');
        Route::post('history/export/{id}', [HistoryController::class, 'export'])->name('admin.history.export');
    
        Route::get('blog', [BlogController::class, 'index'])->name('admin.blog.index');
        Route::get('blog/create', [BlogController::class, 'create'])->name('admin.blog.create');
        Route::post('blog/store', [BlogController::class, 'store'])->name('admin.blog.store');
        Route::get('blog/export/imports', [BlogController::class, 'export'])->name('admin.blog.export.imports');
        Route::post('toggle-product-status', [BlogController::class, 'toggleProductStatus'])->name('toggleProductStatus');
    });

    // User Dashboard
    Route::group([
        'namespace' => 'Backend\User',
        'prefix' => 'user',
        'as' => 'user.',
        'middleware' => 'auth:user'
    ], function () {
        require base_path('routes/backend/user.php');
    });
});

// User dashboard
Route::middleware(['auth.redirect'])->group(function () {
    Route::get('/dashboard', 'DashboardController@index')->name('dashboard');
});

// User list
Route::group(['middleware' => 'auth'], function() {
    Route::post('/toggleUserStatus', [UserDashboardController::class, 'toggleUserStatus'])->name('toggleUserStatus');
});
Route::get('/users', [UserDashboardController::class, 'excelList'])->name('excel');
Route::get('/users/{id}/edit', [UserDashboardController::class, 'edit'])->name('users.edit');
Route::get('/users', [UserDashboardController::class, 'getAll'])->name('users');
Route::get('/get-users', [UserDashboardController::class, 'getUsers'])->name('get-users');
