<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminController;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
Route::get('/', [ContactController::class, 'index']);
Route::post('/confirm', [ContactController::class, 'confirm']);
Route::post('/store', [ContactController::class, 'store']);
Route::get('/thanks', [ContactController::class, 'thanks']);


Route::get('/admin', [AuthController::class, 'admin']);


Route::middleware(['auth'])->group(function () {
    
    // FN021, FN022: お問い合わせ一覧表示と検索
    Route::get('/admin', [AdminController::class, 'index'])->name('admin.index');
    
    // FN026: 削除機能
    Route::delete('/admin/contacts/{contact}', [AdminController::class, 'destroy'])->name('admin.contacts.destroy');

    // FN024: エクスポート機能
    // 検索条件を引き継ぐため、GETで index と同じルート名で処理します
    Route::get('/admin/export', [AdminController::class, 'export'])->name('admin.contacts.export');
});





/*Route::post('/confirm', [ContactController::class, 'confirm']);

Route::post('/store', [ContactController::class, 'store'])->name('contact.store');*/

/*Route::get('/thanks', function () {
    return view('thanks');
})->name('thanks');*/


/*
Route::get('/', [ContactController::class, 'index']);
Route::post('/confirm', [ContactController::class, 'confirm']);
Route::post('/store', [ContactController::class, 'store']);
Route::get('/thanks', [ContactController::class, 'thanks']);
*/