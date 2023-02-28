<?php

use Illuminate\Support\Facades\Route;
use Laravel\Socialite\Facades\Socialite;
use App\Http\Controllers\auth;
use App\Http\Controllers\index;
use App\Http\Controllers\adminDashboard;
use App\Http\Controllers\taller;

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



Route::get("login", [auth::class, "index"])->name("login");
Route::get("login/redirect", [auth::class, "loginRedirect"])->name("loginRedirect");
Route::get("login/callback", [auth::class, "loginCallback"])->name("loginCallback");
Route::get("logout", [auth::class, "logout"])->name("logout");

Route::middleware(['web', 'userAuth'])->group(function () {
    Route::get("/", [taller::class, "showTallers"])->name("index");

    Route::get("/tallers/new", [taller::class, "createTaller"])->name("createTaller");
    Route::post("/tallers", [taller::class, "storeTaller"])->name("storeTaller");
    Route::get("/taller/{id}", [taller::class, "showTaller"])->name("showTaller");
    Route::get("/taller/{id}/edit", [taller::class, "editTaller"])->name("editTaller");
    Route::get("/tallers/select", [taller::class, "selectTallers"])->name("selectTallers");
    Route::get("/debug", [index::class, "index"])->name("debug");
});

Route::middleware(['web', 'adminProtected'])->group(function () {
    Route::get("/admin", [adminDashboard::class, "index"])->name("adminDashboardIndex");
    Route::get("/admin/settings", [adminDashboard::class, "showSetting"])->name("adminShowSetting");
    Route::post("/admin/settings", [adminDashboard::class, "storeSetting"])->name("adminStoreSetting");
});
