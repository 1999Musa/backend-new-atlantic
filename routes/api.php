<?php

use Illuminate\Support\Facades\Route;
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
use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\ContactController;
use App\Http\Controllers\Api\UserLoginController;
use App\Http\Controllers\UserProfileController;




Route::middleware('apiToken')->group(function () {
    Route::get('/user', [UserProfileController::class, 'show']);
    Route::put('/user/update', [UserProfileController::class, 'updateProfile']);
    Route::put('/user/change-password', [UserProfileController::class, 'changePassword']);
});


// Register
Route::post('/register', [UserLoginController::class, 'register']);

// Login
Route::post('/login', [UserLoginController::class, 'login']);

// All users
Route::get('/users', [UserLoginController::class, 'index']);



Route::post('/contact', [ContactController::class, 'sendMail']);


Route::get('/categories', [CategoryController::class, 'index']);

// API routes (React will use this)
Route::get('/team-members', [TeamMemberController::class, 'apiIndex']);



Route::get('/contacthero', [ContactHeroController::class, 'apiIndex']);


Route::get('/community', [CommunitySectionController::class, 'apiIndex']);


Route::get('/clients', [ClientController::class, 'apiIndex']);


Route::get('/place-order', [PlaceOrderItemController::class, 'apiIndex']);



Route::get('/chooseimg', [ChooseHeroController::class, 'apiIndex']);


// Route::get('/product-categories', [ProductCategoryController::class, 'apiIndex']);



Route::get('/hero-sliders', [HeroSliderController::class, 'apiIndex']);



Route::get('/factory', [FactoryController::class, 'apiIndex']);


Route::get('/excellence', [ExcellenceController::class, 'apiIndex']);


Route::get('/sustainabilities', [SustainabilityController::class, 'apiIndex']);




Route::get('/logo', [LogoController::class, 'apiIndex']);


Route::get('/product-sliders', [ProductSliderController::class, 'apiIndex']);



Route::get('/front-factory', [FrontFactoryController::class, 'apiIndex']);


Route::get('/certified-logos', [CertifiedLogoController::class, 'apiIndex']);


Route::get('/short-story-video', [ShortStoryVideoController::class, 'apiIndex']);


Route::get('/about-hero', [AboutHeroController::class, 'apiIndex']);