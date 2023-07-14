<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\AdminHomeController;
use App\Http\Controllers\Admin\AdminProfileController;
use App\Http\Controllers\Admin\AdminCategoryController;
use App\Http\Controllers\Admin\{AdminProductController,AdminPageController,AdminBlogController,AdminGalleryController};

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

Route::get('/run-migration', function () {
    Artisan::call('migrate --force');
    return 'Migrated successfully';
});
Route::get('/optimize-clear', function () {
    Artisan::call('optimize:clear');
    return 'Optimized successfully';
});
Route::get('/migration-refresh', function () {
    Artisan::call('migrate:refresh');
    return 'migration refreshed';
});
Route::get('/storage-link', function () {
    Artisan::call('storage:link');
    return 'migration refreshed';
});

Route::get('/welcome', function () {
    return view('welcome');
});

// Route::get('/dashboard', function () {
//     return view('dashboard');
// })->middleware(['auth', 'verified'])->name('dashboard');

require __DIR__.'/auth.php';

/*** 
 * Admin Panel Routes
 */
Route::prefix('admin')->middleware('auth')->group(function () {
    
    Route::get('dashboard', [AdminHomeController::class, 'index'])->name('home');

    //Password reset
    Route::get('password-reset', [AdminProfileController::class, 'passwordReset'])->name('admin.profile.password_reset');
    Route::post('password-reset/update_password/{id}', [AdminProfileController::class, 'updatePassword'])->name('admin.profile.update_password');

    //Category Management
    Route::get('categories', [AdminCategoryController::class, 'index'])->name('admin.category');
    Route::post('category/fetch', [AdminCategoryController::class, 'fetch'])->name('admin.category.fetch');
    Route::get('category/create', [AdminCategoryController::class, 'create'])->name('admin.category.create');
    Route::post('category/store', [AdminCategoryController::class, 'store'])->name('admin.category.store');
    Route::get('category/edit/{id}', [AdminCategoryController::class, 'edit'])->name('admin.category.edit');
    Route::post('category/update/{id}', [AdminCategoryController::class, 'update'])->name('admin.category.update');
    Route::get('category/delete/{id}', [AdminCategoryController::class, 'destroy'])->name('admin.category.destroy');
    Route::get('category/show/{id}', [AdminCategoryController::class, 'show'])->name('admin.category.show');

    //Product Management
    Route::get('products', [AdminProductController::class, 'index'])->name('admin.products');
    Route::post('product/fetch', [AdminProductController::class, 'fetch'])->name('admin.product.fetch');
    Route::get('product/create/{category_id}', [AdminProductController::class, 'create'])->name('admin.product.create');
    Route::post('product/store', [AdminProductController::class, 'store'])->name('admin.product.store');
    Route::get('product/edit/{id}', [AdminProductController::class, 'edit'])->name('admin.product.edit');
    Route::post('product/update/{id}', [AdminProductController::class, 'update'])->name('admin.product.update');
    Route::get('product/delete/{id}', [AdminProductController::class, 'destroy'])->name('admin.product.destroy');
    Route::get('product/show/{id}', [AdminProductController::class, 'show'])->name('admin.product.show');

    Route::post('product/image/update/sequence/{id}', [AdminProductController::class, 'updateImageSequence'])->name('product.image.update.sequence');
    Route::post('product/image/delete', [AdminProductController::class, 'removeProductImage'])->name('product.image.delete');

    Route::get('pages', [AdminPageController::class, 'index'])->name('admin.pages');
    Route::post('page/fetch', [AdminPageController::class, 'fetch'])->name('admin.page.fetch');
    Route::get('page/create', [AdminPageController::class, 'create'])->name('admin.page.create');
    Route::post('page/store', [AdminPageController::class, 'store'])->name('admin.page.store');
    Route::get('page/edit/{id}', [AdminPageController::class, 'edit'])->name('admin.page.edit');
    Route::post('page/update/{id}', [AdminPageController::class, 'update'])->name('admin.page.update');
    Route::get('page/delete/{id}', [AdminPageController::class, 'destroy'])->name('admin.page.destroy');
    Route::get('page/show/{id}', [AdminPageController::class, 'show'])->name('admin.page.show');

    Route::post('page/image/update/sequence/{id}', [AdminPageController::class, 'updateImageSequence'])->name('page.image.update.sequence');
    Route::post('page/image/delete', [AdminPageController::class, 'removePageImage'])->name('page.image.delete');

    Route::get('blogs', [AdminBlogController::class, 'index'])->name('admin.blog');
    Route::post('blog/fetch', [AdminBlogController::class, 'fetch'])->name('admin.blog.fetch');
    Route::get('blog/create', [AdminBlogController::class, 'create'])->name('admin.blog.create');
    Route::post('blog/store', [AdminBlogController::class, 'store'])->name('admin.blog.store');
    Route::get('blog/edit/{id}', [AdminBlogController::class, 'edit'])->name('admin.blog.edit');
    Route::post('blog/update/{id}', [AdminBlogController::class, 'update'])->name('admin.blog.update');
    Route::get('blog/delete/{id}', [AdminBlogController::class, 'destroy'])->name('admin.blog.destroy');
    Route::get('blog/show/{id}', [AdminBlogController::class, 'show'])->name('admin.blog.show');

    Route::get('galleries', [AdminGalleryController::class, 'index'])->name('admin.galleries');
    Route::post('galleries/fetch', [AdminGalleryController::class, 'fetch'])->name('admin.galleries.fetch');
    Route::get('galleries/create', [AdminGalleryController::class, 'create'])->name('admin.galleries.create');
    Route::post('galleries/store', [AdminGalleryController::class, 'store'])->name('admin.galleries.store');
    Route::get('galleries/edit/{id}', [AdminGalleryController::class, 'edit'])->name('admin.galleries.edit');
    Route::post('galleries/update/{id}', [AdminGalleryController::class, 'update'])->name('admin.galleries.update');
    Route::get('galleries/delete/{id}', [AdminGalleryController::class, 'destroy'])->name('admin.galleries.destroy');
    Route::get('galleries/show/{id}', [AdminGalleryController::class, 'show'])->name('admin.galleries.show');

    Route::post('galleries/image/update/sequence/{id}', [AdminGalleryController::class, 'updateImageSequence'])->name('galleries.image.update.sequence');
    Route::post('galleries/image/delete', [AdminGalleryController::class, 'removeGalleryImage'])->name('galleries.image.delete');
});
