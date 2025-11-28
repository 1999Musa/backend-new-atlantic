<?php

use Illuminate\Support\Facades\Route;

// ✅ Import all controllers
use App\Http\Controllers\Admin\TeamMemberController;
use App\Http\Controllers\Admin\HeroSliderController;
use App\Http\Controllers\Admin\FactoryController;
use App\Http\Controllers\Admin\SustainabilityController;
use App\Http\Controllers\Admin\LogoController;
use App\Http\Controllers\Admin\ProductSliderController;
use App\Http\Controllers\Admin\FrontFactoryController;
use App\Http\Controllers\Admin\CertifiedLogoController;
use App\Http\Controllers\Admin\ShortStoryVideoController;
use App\Http\Controllers\Admin\AboutHeroController;
use App\Http\Controllers\Admin\ClientController;
use App\Http\Controllers\Admin\ChooseHeroController;
use App\Http\Controllers\Admin\ExcellenceController;
use App\Http\Controllers\Admin\CommunitySectionController;
use App\Http\Controllers\Admin\ContactHeroController;
use App\Http\Controllers\Admin\CategoryController as AdminCategoryController;
use App\Http\Controllers\Admin\ProductController as AdminProductController;
use App\Http\Controllers\Admin\CustomRequestAdminController;
use App\Http\Controllers\UserAdminController;
use App\Http\Controllers\Admin\SwatchRequestAdminController;



Route::get('/admin/users', [UserAdminController::class, 'index']);

// ✅ Default routes
Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');

// ✅ Single unified admin route group
Route::middleware(['auth'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {

        Route::resource('custom-requests', CustomRequestAdminController::class)
            ->only(['index', 'show', 'destroy'])
            ->middleware('auth');

        Route::post('custom-requests/{id}/status', [CustomRequestAdminController::class, 'updateStatus'])
            ->name('custom-requests.update-status')
            ->middleware('auth');

        Route::post('custom-requests/bulk-delete', [CustomRequestAdminController::class, 'bulkDelete'])
            ->name('custom-requests.bulk-delete');

        Route::delete('swatch-requests/{id}', [SwatchRequestAdminController::class, 'destroy'])
            ->name('swatch.destroy');
            
        Route::get('swatch-requests', [SwatchRequestAdminController::class, 'index'])->name('swatch.index');
        Route::patch('swatch-requests/{swatch}/status', [SwatchRequestAdminController::class, 'updateStatus'])->name('swatch.status');
        Route::post('swatch-requests/bulk-delete', [SwatchRequestAdminController::class, 'bulkDelete'])->name('swatch.bulk-delete');// Add this line to enable the delete button
    
        // 2. Index (List)
        Route::get('swatch-requests', [SwatchRequestAdminController::class, 'index'])->name('swatch.index');

        // 3. Show (Single Detail Page) - THIS WAS MISSING
        Route::get('swatch-requests/{id}', [SwatchRequestAdminController::class, 'show'])->name('swatch.show');

        Route::get('/users', [UserAdminController::class, 'index'])
            ->name('users.index');
        // Product & Category Management
        Route::resource('categories', AdminCategoryController::class);
        Route::resource('products', AdminProductController::class);
        Route::resource('contacthero', ContactHeroController::class);
        Route::resource('community', CommunitySectionController::class);
        Route::resource('team-members', TeamMemberController::class);

        Route::resource('hero-sliders', HeroSliderController::class);
        Route::resource('factory', FactoryController::class);
        Route::resource('sustainability', SustainabilityController::class);
        Route::resource('logo', LogoController::class);
        Route::resource('product-sliders', ProductSliderController::class);
        Route::resource('front-factory', FrontFactoryController::class);
        Route::resource('certified-logos', CertifiedLogoController::class);
        Route::resource('short-story', ShortStoryVideoController::class);
        Route::resource('about-hero', AboutHeroController::class);
        Route::resource('clients', ClientController::class);
        Route::resource('chooseimg', ChooseHeroController::class);

        // Excellence
        Route::resource('excellence', ExcellenceController::class)
            ->only(['index', 'create', 'store', 'edit', 'update', 'destroy']);

        // Custom route for removing excellence image
        Route::delete('excellence/{id}/remove-image', [ExcellenceController::class, 'removeImage'])
            ->name('excellence.removeImage');
    });
use Illuminate\Support\Facades\Mail;

// ✅ Authentication routes
require __DIR__ . '/auth.php';
