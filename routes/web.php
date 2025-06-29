<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\TeknisiController;
use App\Http\Controllers\AdminUserController;

Route::get('/ping', function () {
    return response('OK', 200);
});

// ======== REGISTER ========
Route::get('/register', [AuthController::class, 'register'])->name('register');
Route::post('/register', [AuthController::class, 'doRegister']);

// ======== AUTH ========
Route::get('/', [AuthController::class, 'login'])->name('login');
Route::post('/login', [AuthController::class, 'doLogin']);
Route::get('/logout', [AuthController::class, 'logout']);

// ======== DASHBOARD REDIRECT ========
Route::middleware('auth')->group(function () {
    Route::get('/dashboard', function () {
        $role = auth()->user()->role;
        return redirect("/$role/dashboard");
    });

    // ======== USER ========
    Route::prefix('user')->group(function () {
        Route::get('/dashboard', function () {
            if (auth()->user()->role !== 'user') {
                abort(403, 'Akses ditolak');
            }
            return app(UserController::class)->index();
        });

        Route::post('/pasang', function (Request $request) {
            if (auth()->user()->role !== 'user') {
                abort(403, 'Akses ditolak');
            }
            return app(UserController::class)->store($request);
        })->name('user.pasang');
    });

    // ======== TEKNISI ========
    Route::prefix('teknisi')->group(function () {
        Route::get('/dashboard', function () {
            if (auth()->user()->role !== 'teknisi') {
                abort(403, 'Akses ditolak');
            }
            return app(TeknisiController::class)->index();
        });

        Route::patch('/update/{id}', [TeknisiController::class, 'update'])->name('teknisi.update');
    });

    // ======== ADMIN ========
    Route::prefix('admin')->group(function () {
        Route::get('/dashboard', function () {
            if (auth()->user()->role !== 'admin') {
                abort(403, 'Akses ditolak');
            }
            return app(AdminController::class)->index();
        });

        // CRUD Pengguna oleh Admin
        Route::resource('/users', AdminUserController::class)->names('admin.users');

        // Update Keterangan Admin pada pemasangan
        Route::patch('/pemasangan/{id}/keterangan', [AdminController::class, 'updateKeterangan'])->name('admin.keterangan.update');
    });
});
