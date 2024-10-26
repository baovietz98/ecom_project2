<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AdminController;

// Route::get('/', function () {
//     return view('welcome');
// });
Route::get('/', [HomeController::class, 'home'])->name('home');
// Route::get('/dashboard', [HomeController::class, 'login_home'])->middleware(['auth', 'verified'])->name('dashboard');
Route::get('/product_details/{id}', [HomeController::class, 'product_details'])->name('product.details');
Route::get('/add_cart/{id}', [HomeController::class, 'add_cart'])->middleware(['auth', 'verified']);
Route::get('/mycart', [HomeController::class, 'mycart'])->middleware(['auth', 'verified']);
Route::get('/delete_cart/{id}', [HomeController::class, 'delete_cart'])->middleware(['auth', 'verified']);
Route::post('/update_cart_quantity/{id}', [HomeController::class, 'updateCartQuantity']);
Route::post('/place-order', [HomeController::class, 'placeOrder'])->name('place.order');
Route::controller(HomeController::class)->group(function(){

    Route::get('stripe/{total}', 'stripe');

    Route::post('stripe/{total}', 'stripePost')->name('stripe.post');

});
Route::get('/my-orders', [HomeController::class, 'myOrders'])->middleware(['auth', 'verified'])->name('my.orders');
Route::get('/order-details/{id}', [HomeController::class, 'orderDetails'])->middleware(['auth', 'verified'])->name('order.details');
Route::get('/shop', [HomeController::class, 'shop'])->name('shop');
Route::get('/why-us', [HomeController::class, 'whyUs'])->name('why-us');
Route::get('/feedback', [HomeController::class, 'feedback'])->name('feedback');
Route::post('/feedback/submit', [HomeController::class, 'store'])->name('feedback.submit');




// Route::get('/dashboard', function () {
//     return view('home.index');
// })->middleware(['auth', 'verified'])->name('dashboard');

Route::get('/dashboard', function () {
    return redirect()->route('home');
})->middleware(['auth'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});
Route::middleware(['auth','Admin'])->group(function () {
    Route::get('/admin/dashboard', [AdminController::class, 'index'])->name('admin.dashboard');    
    Route::get('/admin/category', [AdminController::class, 'view_category'])->name('admin.category'); 
    Route::post('/admin/addcategory', [AdminController::class, 'add_category'])->name('admin.addcategory'); 
    Route::delete('/admin/delete_category/{id}', [AdminController::class, 'delete_category'])->name('admin.deletecategory');
    Route::get('/admin/edit_category/{id}', [AdminController::class, 'edit_category'])->name('admin.editcategory');
    Route::post('/admin/update_category/{id}', [AdminController::class, 'update_category'])->name('admin.updatecategory');
    Route::get('/admin/add_product', [AdminController::class, 'add_product'])->name('admin.addproduct');
    Route::post('/admin/upload_product', [AdminController::class, 'upload_product'])->name('admin.uploadproduct');
    Route::get('/admin/view_product', [AdminController::class, 'view_product'])->name('admin.viewproduct');
    Route::get('/admin/delete_product/{id}', [AdminController::class, 'delete_product'])->name('admin.deleteproduct');
    Route::get('/admin/update_product/{id}', [AdminController::class, 'update_product'])->name('admin.updateproduct');
    Route::post('/admin/edit_product/{id}', [AdminController::class, 'edit_product'])->name('admin.editproduct');
    Route::get('/admin/search_product', [AdminController::class, 'search_product'])->name('admin.searchproduct');
    Route::get('/admin/brands', [AdminController::class, 'view_brands'])->name('admin.brands'); 
    Route::post('/admin/addbrands', [AdminController::class, 'add_brands'])->name('admin.addbrands'); 
    Route::delete('/admin/delete_brands/{id}', [AdminController::class, 'delete_brands'])->name('admin.deletebrands');
    Route::get('/admin/edit_brands/{id}', [AdminController::class, 'edit_brands'])->name('admin.editbrands');
    Route::post('/admin/update_brands/{id}', [AdminController::class, 'update_brands'])->name('admin.updatebrands');

        // Route để hiển thị danh sách các đơn hàng (với phân trang)
    Route::get('/admin/orders', [AdminController::class, 'viewOrders'])->name('admin.orders');

    // Route để hiển thị chi tiết đơn hàng theo ID
    Route::get('/admin/orders/{id}', [AdminController::class, 'orderDetails'])->name('admin.orderDetails');

    // Route để cập nhật trạng thái đơn hàng (chuyển sang trạng thái "shipped")
    Route::post('/admin/orders/update-status/{id}', [AdminController::class, 'updateOrderStatus'])->name('admin.updateOrderStatus');

    // Route để tìm kiếm đơn hàng
    Route::get('/admin/orders/search', [AdminController::class, 'searchOrder'])->name('admin.searchOrder');

    Route::get('/admin/addnews', [AdminController::class, 'add_news'])->name('admin.addnews');

    Route::post('/admin/uploadnews', [AdminController::class, 'upload_news'])->name('admin.uploadnews');



});
require __DIR__.'/auth.php';
