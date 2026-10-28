<?php

use App\Http\Controllers\ActivityController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\EwalletController;
use App\Http\Controllers\GameController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TopupController;
use App\Models\Game;
use App\Models\Transaction;
use App\Models\User;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\GameController as AdminGameController;
use App\Http\Controllers\Admin\EwalletController as AdminEwalletController;
use App\Http\Controllers\Admin\TransactionController as AdminTransactionController;
use App\Http\Controllers\Admin\UserController as AdminUserController;
use App\Http\Controllers\GoogleController;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\Request;
use App\Http\Controllers\PasswordResetController;
use App\Http\Controllers\PaymentNotificationController;

Route::get('/', [AuthController::class, 'login'])->name('login');
Route::post('/login', [AuthController::class, 'authenticate']);
Route::post('/logout', [AuthController::class, 'logout']);
Route::get('/register', [AuthController::class, 'registerView']);
Route::post('/register', [AuthController::class, 'register']);

Route::get('/dashboard', function () {
    session()->forget('baru_daftar');
    $user = auth()->user();

    if ($user->role_id == 1) {
        $totalUser = User::where('role_id', 2)->count();
        $totalTransaksi = Transaction::count();
        $totalCoinMasuk = Transaction::where('tipe', 'masuk')->sum('jumlah_coin');
        $latestTransactions = Transaction::with('user')->latest()->take(4)->get();

        return view('pages.dashboard', compact('totalUser', 'totalTransaksi', 'totalCoinMasuk', 'latestTransactions'));
    }

    // ===== Data untuk Customer =====
    $games = Game::select('games.*')
        ->leftJoin('transactions', function ($join) {
            $join->on('games.nama_game', '=', 'transactions.nama_item')
                ->where('transactions.jenis', '=', 'game');
        })
        ->selectRaw('COUNT(transactions.id) as total_topup')
        ->groupBy('games.id_game', 'games.nama_game', 'games.deskripsi', 'games.photo', 'games.icon', 'games.created_at', 'games.updated_at')
        ->orderByDesc('total_topup')
        ->take(3)
        ->get();

    $lastTransactions = Transaction::where('user_id', $user->id)
        ->latest()
        ->take(1)
        ->get();

    return view('pages.dashboard', compact('games', 'lastTransactions'));
})->middleware('role:Admin,User')->name('dashboard');

//Menu topup saldo
Route::get('/topup', [TopupController::class, 'index'])->middleware(['auth', 'verified'])->name('topup.index');
Route::post('/topup', [TopupController::class, 'store'])->middleware(['auth', 'verified'])->name('topup.store');

//Menu topup game
Route::get('/topup-game', [GameController::class, 'index'])->middleware(['auth', 'verified'])->name('topup.game');
Route::get('/topup-game/{game:id_game}', [GameController::class, 'detail'])->middleware(['auth', 'verified'])->name('topup.game.detail');
Route::post('/topup-game/process', [GameController::class, 'process'])->middleware(['auth', 'verified'])->name('topup.game.process');

//Menu topup ewallet
Route::get('/topup-ewallet', [EwalletController::class, 'index'])->middleware(['auth', 'verified'])->name('topup.ewallet');
Route::get('/topup-ewallet/{ewallet:id_ewallet}', [EwalletController::class, 'detail'])->middleware(['auth', 'verified'])->name('topup.ewallet.detail');
Route::post('/topup-ewallet/process', [EwalletController::class, 'process'])->middleware(['auth', 'verified'])->name('topup.ewallet.process');

//Aktivitas
Route::get('/aktivitas', [ActivityController::class, 'index'])->middleware(['auth', 'verified'])->name('activity.index');

//Profile
Route::middleware(['auth'])->group(function () {
    Route::get('/profile', [ProfileController::class, 'index'])->name('profile.index');
    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::post('/profile/edit', [ProfileController::class, 'update'])->name('profile.update');
    Route::get('/profile/change-password', [ProfileController::class, 'changePassword'])->name('profile.change-password');
    Route::post('/profile/change-password', [ProfileController::class, 'updatePassword'])->name('profile.update-password');
});

//Manage game (Admin)
Route::middleware(['auth', 'role:Admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/game', [AdminGameController::class, 'index'])->name('game.index');
    Route::get('/game/create', [AdminGameController::class, 'create'])->name('game.create');
    Route::post('/game', [AdminGameController::class, 'store'])->name('game.store');
    Route::get('/game/{game:id_game}/edit', [AdminGameController::class, 'edit'])->name('game.edit');
    Route::post('/game/{game:id_game}', [AdminGameController::class, 'update'])->name('game.update');
    Route::delete('/game/{game:id_game}', [AdminGameController::class, 'destroy'])->name('game.destroy');

    //Manage package game
    Route::get('/game/{game:id_game}/package', [AdminGameController::class, 'package'])->name('game.package');
    Route::post('/game/{game:id_game}/package', [AdminGameController::class, 'packageStore'])->name('game.package.store');
    Route::post('/game/{game:id_game}/package/{package:id_package}', [AdminGameController::class, 'packageUpdate'])->name('game.package.update');
    Route::delete('/game/{game:id_game}/package/{package:id_package}', [AdminGameController::class, 'packageDestroy'])->name('game.package.destroy');

    //Manage ewallet (Admin)
    Route::get('/ewallet', [AdminEwalletController::class, 'index'])->name('ewallet.index');
    Route::get('/ewallet/create', [AdminEwalletController::class, 'create'])->name('ewallet.create');
    Route::post('/ewallet', [AdminEwalletController::class, 'store'])->name('ewallet.store');
    Route::get('/ewallet/{ewallet:id_ewallet}/edit', [AdminEwalletController::class, 'edit'])->name('ewallet.edit');
    Route::post('/ewallet/{ewallet:id_ewallet}', [AdminEwalletController::class, 'update'])->name('ewallet.update');
    Route::delete('/ewallet/{ewallet:id_ewallet}', [AdminEwalletController::class, 'destroy'])->name('ewallet.destroy');
    Route::get('/ewallet/{ewallet:id_ewallet}/package', [AdminEwalletController::class, 'package'])->name('ewallet.package');
    Route::post('/ewallet/{ewallet:id_ewallet}/package', [AdminEwalletController::class, 'packageStore'])->name('ewallet.package.store');
    Route::post('/ewallet/{ewallet:id_ewallet}/package/{package:id_package}', [AdminEwalletController::class, 'packageUpdate'])->name('ewallet.package.update');
    Route::delete('/ewallet/{ewallet:id_ewallet}/package/{package:id_package}', [AdminEwalletController::class, 'packageDestroy'])->name('ewallet.package.destroy');

    //Aktivitas (Admin)
    Route::get('/transaksi', [AdminTransactionController::class, 'index'])->name('transaksi.index');

    //User data (Admin)
    //User data (Admin)
    Route::get('/user', [AdminUserController::class, 'index'])->name('user.index');
    Route::patch('/user/{user}/toggle-status', [AdminUserController::class, 'toggleStatus'])->name('user.toggleStatus');
    Route::delete('/user/{user}', [AdminUserController::class, 'destroy'])->name('user.destroy');
});

// Google
Route::get('/auth/google', [GoogleController::class, 'redirect'])->name('google.redirect');
Route::get('/auth/google/callback', [GoogleController::class, 'callback'])->name('google.callback');

// Verifikasi email
Route::middleware('auth')->group(function () {
    // Kalau sudah terverifikasi, langsung ke dashboard
    Route::get('/email/verify', function (Request $request) {
        if ($request->user()->hasVerifiedEmail()) {
            return redirect()->route('dashboard');
        }
        return view('pages.auth.verify-email');
    })->name('verification.notice');

    // Dipakai script cek otomatis di halaman verifikasi
    Route::get('/email/verification-status', function (Request $request) {
        return response()->json([
            'verified' => $request->user()->fresh()->hasVerifiedEmail(),
        ]);
    })->name('verification.status');

    Route::get('/email/verify/{id}/{hash}', function (EmailVerificationRequest $request) {
        $request->fulfill();
        return redirect()->route('dashboard')->with('success', 'Email berhasil diverifikasi!');
    })->middleware('signed')->name('verification.verify');

    Route::post('/email/verification-notification', function (Request $request) {
        if ($request->user()->hasVerifiedEmail()) {
            return redirect()->route('dashboard');
        }
        $request->user()->sendEmailVerificationNotification();
        return back()->with('success', 'Link verifikasi telah dikirim ulang.');
    })->middleware('throttle:3,1')->name('verification.send');
});

// Reset password
Route::get('/forgot-password', [PasswordResetController::class, 'request'])->middleware('guest')->name('password.request');
Route::post('/forgot-password', [PasswordResetController::class, 'email'])->middleware('throttle:3,1')->name('password.email');
Route::get('/reset-password/{token}', [PasswordResetController::class, 'reset'])->name('password.reset');
Route::post('/reset-password', [PasswordResetController::class, 'update'])->name('password.update');

// Midtrans (Payment Gateway)
Route::post('/payment/notification', [PaymentNotificationController::class, 'handle'])->name('payment.notification');
Route::get('/topup/selesai', [TopupController::class, 'finish'])->middleware(['auth', 'verified'])->name('topup.finish');
