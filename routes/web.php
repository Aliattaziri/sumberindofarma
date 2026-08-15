<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\PrescriptionController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminDashboardController;
use App\Http\Controllers\AdminMedicineController;
use App\Http\Controllers\AdminPrescriptionController;
use App\Http\Controllers\AdminPrescriptionProductController;
use App\Http\Controllers\AdminProdukController;
use App\Http\Controllers\AdminBannerController;
use App\Http\Controllers\PurchaseHistoryController;

// Favicon fallbacks for hosting setups that move public assets
Route::get('/favicon.ico', function () {
    $candidates = [
        public_path('favicon.ico'),
        base_path('favicon.ico'),
    ];

    foreach ($candidates as $path) {
        if (is_file($path)) {
            return response()->file($path, ['Content-Type' => 'image/x-icon']);
        }
    }

    abort(404);
});

// Public routes
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/tentang-kami', [HomeController::class, 'about'])->name('about');
Route::get('/contact', [HomeController::class, 'contact'])->name('contact');
// Halaman Mitra Kami
Route::get('/mitra-kami', [HomeController::class, 'partners'])->name('partners');

// Serve uploaded images langsung dari storage/ (banners, promos & medicines)
// Dipakai saat symlink tidak tersedia di hosting
Route::get('/storage/{folder}/{filename}', function (string $folder, string $filename) {
    $allowed = ['banners', 'medicines', 'promos'];
    if (!in_array($folder, $allowed)) abort(404);

    $path = storage_path($folder . '/' . $filename);
    if (!file_exists($path)) abort(404);

    $mime = mime_content_type($path) ?: 'application/octet-stream';
    return response()->file($path, ['Content-Type' => $mime]);
})->where(['folder' => 'banners|medicines|promos', 'filename' => '.+'])->name('storage.image');

// Products routes
Route::get('/products', [ProductController::class, 'index'])->name('products.index');
Route::get('/products/{id}', [ProductController::class, 'show'])->name('products.show');
Route::get('/products-pbf-gate', [ProductController::class, 'pbfGate'])->name('products.pbf.gate');
Route::get('/products-pbf', [ProductController::class, 'pbf'])->name('products.pbf');
Route::post('/products-pbf/verify', [ProductController::class, 'pbfVerify'])->name('products.pbf.verify');
Route::post('/products-pbf/logout', [ProductController::class, 'pbfLogout'])->name('products.pbf.logout');
Route::get('/products-apotek', [ProductController::class, 'apotek'])->name('products.apotek');
Route::get('/products-apotek-select', [ProductController::class, 'apotekSelect'])->name('products.apotek.select');
Route::post('/orders/history', [PurchaseHistoryController::class, 'store'])->name('orders.history.store');

// Category routes (Layer 2 & 3)
Route::get('/category/{main}/{sub}', [CategoryController::class, 'layer2'])->name('category.layer2');

// Medicine detail (public)
Route::get('/medicines/{id}', [HomeController::class, 'show'])->name('medicines.show');

// Prescriptions routes
Route::get('/prescriptions', [PrescriptionController::class, 'index'])->name('prescriptions.index');
Route::get('/prescriptions/{id}', [PrescriptionController::class, 'show'])->name('prescriptions.show');

// Auth routes
Route::get('/login', [AuthController::class, 'loginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
Route::post('/customer/logout', [AuthController::class, 'customerLogout'])->name('customer.logout');

// Admin routes
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');
    Route::get('/dashboard/stats', [AdminDashboardController::class, 'stats'])->name('dashboard.stats');
    Route::get('/dashboard/global-stats', [AdminDashboardController::class, 'globalStats'])->name('dashboard.global-stats');

    // Medicines management
    Route::resource('medicines', AdminMedicineController::class);
    Route::post('medicines/{medicine}/update-stock', [AdminMedicineController::class, 'updateStock'])->name('medicines.update-stock');
    Route::post('medicines/{medicine}/update-price', [AdminMedicineController::class, 'updatePrice'])->name('medicines.update-price');
    

    // Prescriptions management
    Route::resource('prescriptions', AdminPrescriptionController::class);
    Route::post('prescriptions/{prescription}/update-stock', [AdminPrescriptionController::class, 'updateStock'])->name('prescriptions.update-stock');
    Route::post('prescriptions/{prescription}/update-price', [AdminPrescriptionController::class, 'updatePrice'])->name('prescriptions.update-price');
    

    // Prescription Products management
    Route::resource('prescription-products', AdminPrescriptionProductController::class);
    Route::post('prescription-products/{prescriptionProduct}/update-stock', [AdminPrescriptionProductController::class, 'updateStock'])->name('prescription-products.update-stock');
    Route::post('prescription-products/{prescriptionProduct}/update-price', [AdminPrescriptionProductController::class, 'updatePrice'])->name('prescription-products.update-price');
    

    // Produk management
    Route::delete('produk/bulk-delete', [AdminProdukController::class, 'destroyMany'])->name('produk.destroyMany');
    Route::resource('produk', AdminProdukController::class);
    Route::post('produk/{produk}/update-stock', [AdminProdukController::class, 'updateStock'])->name('produk.update-stock');
    Route::post('produk/{produk}/update-price', [AdminProdukController::class, 'updatePrice'])->name('produk.update-price');
    

    // Banner / Promo Slideshow management
    Route::resource('banners', AdminBannerController::class);
    Route::post('banners/{banner}/toggle', [AdminBannerController::class, 'toggleAktif'])->name('banners.toggle');

    // Principals (logo) management - simple file-based admin
    Route::get('principals', [\App\Http\Controllers\AdminPrincipalController::class, 'index'])->name('principals.index');
    Route::post('principals', [\App\Http\Controllers\AdminPrincipalController::class, 'store'])->name('principals.store');
    Route::delete('principals/{filename}', [\App\Http\Controllers\AdminPrincipalController::class, 'destroy'])->where('filename', '.+')->name('principals.destroy');

});
