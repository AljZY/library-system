<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\MemberController;
use App\Http\Controllers\BookController;

// Test database connection
Route::get('/test-db', function () {
    return DB::select('SHOW TABLES');
});

Route::get('/', function () {
    return view('loginAdmin');
});

// Handle logout
Route::get('/admin/logout', function () {
    // Clear session data and redirect to login page
    session()->flush();
    return redirect('/');
})->name('admin.logout');

Route::post('/admin/login', function (Request $request) {
    $request->validate([
        'email' => 'required|email',
        'password' => 'required',
    ]);

    $adminEmail = 'admin@library.com';
    $adminPassword = 'admin';

    if ($request->email === $adminEmail && $request->password === $adminPassword) {
        session(['admin_logged_in' => true]);
        return redirect('/admin/homepage');
    }

    return redirect('/')->withErrors(['loginError' => 'Invalid credentials.']);
});

Route::get('/admin/homepage', [BookController::class, 'homepage'])->name('admin.homepage');

Route::get('/admin/books', [BookController::class, 'index'])->name('admin.books');
Route::post('/admin/books/add', [BookController::class, 'store'])->name('books.store');
Route::post('/admin/books/borrow', [BookController::class, 'borrow'])->name('books.borrow');
Route::post('/admin/books/{id}/borrow', [BookController::class, 'borrow'])->name('books.borrow');
Route::post('/admin/books/{id}/return', [BookController::class, 'returnBook'])->name('books.return');
Route::put('/admin/books/{id}/update', [BookController::class, 'update'])->name('books.update');
Route::delete('/admin/books/{id}', [BookController::class, 'destroy'])->name('books.destroy');

Route::get('/admin/members', [App\Http\Controllers\MemberController::class, 'index'])->name('admin.members');
Route::post('/admin/members/add', [MemberController::class, 'store'])->name('members.store');
Route::get('/admin/members/{id}/edit', [MemberController::class, 'edit'])->name('members.edit');
Route::post('/admin/members/{id}/update', [MemberController::class, 'update'])->name('members.update');
Route::delete('/admin/members/{id}', [MemberController::class, 'destroy'])->name('members.destroy');
Route::get('/admin/members/search', [MemberController::class, 'search'])->name('members.search');

Route::get('/admin/borrow-history', [BookController::class, 'borrowHistory'])->name('admin.borrow-history');

Route::get('/loginMember', function () {
    return view('loginMember');
})->name('loginMember');

Route::post('/member/loginMember', [MemberController::class, 'login'])->name('member.loginMember');

// Member logout
Route::get('/member/logout', function () {
    session()->forget('member_id');
    return redirect()->route('loginMember');
})->name('member.logout');

Route::get('/member/homepage', [BookController::class, 'memberNotReturnedBooks'])->name('member.homepage');

Route::get('/member/books', [BookController::class, 'memberBooks'])->name('member.books');

Route::get('/member/borrow-history', [MemberController::class, 'borrowHistory'])->name('member.borrow-history');

Route::get('/member/changePassword', function () {
    return view('member.changePassword');
})->name('member.changePassword');
Route::post('/member/changePassword', [MemberController::class, 'changePassword'])->name('member.changePassword');
