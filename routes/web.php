<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\auth;
use App\Http\Controllers\index;
use App\Http\Controllers\adminDashboard;
use App\Http\Controllers\adminUser;
use App\Http\Controllers\WorkShop;
use App\Http\Controllers\WorkShopHistory;

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
    Route::get("/", [WorkShop::class, "showWorkshops"])->name("index");

    // Grup de tallers
    Route::get("/workshops/new", [WorkShop::class, "createWorkshop"])->name("createWorkshop");
    Route::post("/workshops", [WorkShop::class, "storeWorkshop"])->name("storeWorkshop");
    Route::get("/workshops/view/{id}", [WorkShop::class, "showWorkshop"])->name("showWorkshop");
    Route::get("/workshops/view/{id}/edit", [WorkShop::class, "editWorkshop"])->name("editWorkshop");
    Route::post("/workshops/view/{id}/clone", [WorkShop::class, "cloneWorkshop"])->name("cloneWorkshop");
    Route::post("/workshops/select", [WorkShop::class, "selectWorkshop"])->name("selectWorkshop");

    // Grup del historial de tallers
    Route::get("/workshops/history", [WorkShopHistory::class, "showWorkshops"])->name("showWorkshopsHistory");
    Route::post("/workshops/history", [WorkShopHistory::class, "storeWorkshop"])->name("storeWorkshopsHistory");
    Route::get("/workshops/history/{id}", [WorkShopHistory::class, "showWorkshop"])->name("showWorkshopHistory");
    // Route::get("/workshops/history/{id}/edit", [WorkShopHistory::class, "editWorkshop"])->name("editWorkshopHistory");

    Route::get("/debug", [index::class, "index"])->name("debug");
});

Route::middleware(['web', 'adminProtected'])->group(function () {
    Route::get("/admin", [adminDashboard::class, "index"])->name("adminDashboardIndex");

    // configuracions d'administrador
    Route::get("/admin/settings", [adminDashboard::class, "showSettings"])->name("adminShowSetting");
    Route::post("/admin/settings", [adminDashboard::class, "storeSetting"])->name("adminStoreSetting");
    Route::post("/admin/routine", [adminDashboard::class, "runRoutine"])->name("adminRoutine");

    // llistat d'alumnes
    Route::get("/admin/users", [adminUser::class, "showUsers"])->name("adminShowUsers");
    // Route::post("/admin/users/filter", [adminUser::class, "showUsersFiltered"])->name("adminShowUsersFiltered");
    Route::get("/admin/users/new", [adminUser::class, "createUser"])->name("adminCreateUser");
    Route::post("/admin/users", [adminUser::class, "storeUser"])->name("adminStoreUser");
    Route::get("/admin/users/view/{id}", [adminUser::class, "showUser"])->name("adminShowUser");
    Route::get("/admin/users/view/{id}/edit", [adminUser::class, "editUser"])->name("adminEditUser");
    Route::post("/admin/users/view/{id}/delete", [adminUser::class, "deleteUser"])->name("adminDeleteUser");
    Route::get("/admin/users/import", [adminUser::class, "importUsers"])->name("adminImportUsers");

    // modificacio de tallers d'alumnes
    Route::get("/admin/users/view/{id}/workshopSelection", [adminUser::class, "selectWorkshop"])->name("adminSelectWorkshop");
    Route::post("/admin/users/view/{id}/selectWorkshop", [adminUser::class, "storeWorkshopSelection"])->name("adminStoreWorkshopSelection");
});

Route::middleware(['web', 'superAdminProtected'])->group(function () {
    Route::post("/admin/users/view/{id}/role", [adminUser::class, "updateUserRole"])->name("adminUpdateUserRole");
});
