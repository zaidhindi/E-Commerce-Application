<?php

use App\Http\Controllers\BackendController;
use App\Http\Controllers\FrontendController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

/*Route::get('/', function () {
    return view('welcome');
});*/

Route::controller(FrontendController::class)->group(function () {
    Route::get('/', 'home')->name('home');
    Route::any('/user/login', 'user_login');
    Route::any('/new_account', 'new_account');
    Route::any('/user/reset-password', 'user_reset_password');
    Route::any('/user/update-password', 'user_updated_password');

    Route::get('/user/forget/password', 'user_forget_password')->name('user.forget.password');
    Route::get('/user/update/password/{id}', 'user_update_password')->name('user.update.password');
    Route::get('/error/403', 'error_403')->name('error.403');
    Route::get('/error/404', 'error_404')->name('error.404');
    Route::get('/products-by-category/{id}', 'products_by_category')->name('products.by.category');
    Route::get('/products-view/{id}', 'product_view')->name('product.view');
    Route::get('/super-deals', 'super_delas')->name('super.deals');
    Route::get('/all-products', 'products')->name('products');
    Route::any('/search-products', 'search_products');
    Route::get('/search/result/{input}', 'search_result');
    Route::any('/add-cart', 'add_cart');
    Route::get('/cart-view', 'cart_view')->name('cart.view');
    Route::get('/cart-delete/{product_id}', 'cart_delete');
    Route::get('/cart-empty', 'cart_empty');
    Route::get('/add-wishlist/{id}', 'add_wishlist');
    Route::get('/wishlist', 'wishlist')->name('wishlist');
    Route::get('/wishlist-delete/{id}', 'wishlist_delete');
    Route::get('/pay-now', 'pay_now')->name('pay.now');
    Route::get('/checkout-succees', 'checkout_succees')->name('checkout.success');
    Route::get('/checkout-cancel', 'checkout_cancel')->name('checkout.cancel');
    Route::post('/order-shipping/store', 'order_ship_store')->name('order.shipping.store');
    Route::get('/order-confirmed', 'order_confirmed')->name('order.confirmed');
    Route::get('/my-orders', 'my_orders')->name('my.orders');
    Route::get('/contact-us', 'contact_us')->name('contact.us');
    Route::post('/contact-us/submit', 'contact_us_submit')->name('contact.us.submit');
    Route::middleware(['auth', 'verified', 'role:user'])->group(function () {
        Route::get('/user/logout', 'UserLogout')->name('user.logout');
        Route::get('/user-account', 'user_account')->name('user.account');
        Route::post('/update-profile', 'update_profile');
        Route::get('/support-tickets', 'user_support_tickets')->name('user.support.tickites');
        Route::get('/support-tickets/add', 'user_support_ticket_add')->name('user.support.ticket.add');
        Route::post('/support-tickets/store', 'user_support_ticket_store');
        Route::get('/support-tickets/view/{id}', 'support_view')->name('support.view');

        Route::post('/support-tickets/update', 'support_ticket_update');
        Route::post('/user/support-tickets/close', 'user_support_ticket_close');
    });
});
Route::controller(BackendController::class)->group(function () {
    Route::middleware(['auth', 'verified', 'role:admin'])->group(function () {
        Route::get('/dashboard', 'dashboard')->name('dashboard');
        Route::get('/admin/logout', 'AdminLogout')->name('admin.logout');
        Route::get('/add/category', 'AddCategory')->name('add.category');

        Route::any('/add/category/store', 'AddCategoryStore');
        Route::get('/category', 'ShowCategory')->name('show.category');
        Route::get('/category/edit/{id}', 'CategoryEdit')->name('category.edit');
        Route::any('/category/update', 'CategoryUpdate');
        Route::any('/category/delete', 'CategoryDelete');
        Route::any('/products/store', 'productStore');
        Route::get('/products/add', 'ProductAdd')->name('products.add');
        Route::get('/products/edit/{id}', 'ProductEdit')->name('product.edit');
        Route::get('/product/view', 'productView')->name('products.view');
        Route::any('/product/update', 'productUpdate');
        Route::any('/proudct/delete', 'productDelete');
        // Featured Product routes
        Route::get('/featured/view', 'featured_view')->name('featured.view');
        Route::get('/featured/add', 'featured_add')->name('featured.add');
        Route::any('/featured-product/update', 'featured_product_update');
        Route::any('/featured/products/store', 'featured_products_store');
        Route::get('/featured/product/edit/{id}', 'featured_product_edit')->name('featured.product.edit');
        Route::any('/featured-proudct/delete', 'featured_product_delete');
        Route::get('/admin-profile', 'admin_profile')->name('admin.profile');
        Route::any('/admin/update-account', 'admin_update_account');
        Route::get('/general-setting', 'general_setting')->name('general.setting');
        Route::get('/general-setting/edit', 'general_setting_edit')->name('setting.general.edit');
        Route::any('/general-setting/update', 'general_setting_update');
        Route::get('/contact-us/all', 'contact_us_all')->name('contact.us.all');
        Route::get('/contact-us/delete/{id}', 'contact_us_delete')->name('contact.us.delete');
        Route::get('/admin/users', 'users')->name('users');
        Route::post('/admin/delete-user', 'delete_user');
        Route::get('/admin/support-tickets', 'admin_support_tickets')->name('admin.support.ticket');
        Route::get('/admin/support-tickets/view/{ticket_no}', 'admin_support_tickets_view')->name('admin.support.ticket.view');
        Route::post('/admin/support-tickets/reply', 'admin_support_ticket_reply');
        Route::post('/admin/support-tickets/close', 'admin_support_ticket_close');
    });
});

/*Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');*/

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';
