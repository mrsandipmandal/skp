<?php
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\AdminController;
use App\Http\Controllers\SetupController;
use App\Http\Controllers\GoogleDriveController;

/* Login */
// Route::get('website', [AdminController::class, 'website']);
Route::get('/', [AdminController::class, 'login']);
Route::get('/login', [AdminController::class, 'login']);
Route::post('/login', [AdminController::class, 'logins']);


Route::middleware(['isLogged'])->group(function () {
    /* Dashbord and password change */
    Route::controller(AdminController::class)->group(function () {
        Route::get('/dashboard', 'dashboard');
        Route::post('/change-password', 'changepass');
        Route::post('/change-password', 'changepass');

        Route::get('/menu-setup', 'menu_setup')->name('menu.setup');
        Route::post('/menu-setup', 'menu_setups')->name('menu.save');
        Route::get('/menu-edit', 'menu_edit')->name('menu.edit');
        Route::get('/menu-assign', 'menu_assign');
        Route::post('/menu-assigns', 'menu_assigns')->name('menu.assign');
        Route::get('/menu-status-update', 'menu_status_update')->name('menu.status.update');
    });

    /* Setup  */
    Route::controller(SetupController::class)->group(function () {

        Route::get('/person-entry', 'Person_Entry')->name('Person.Entry');
        Route::post('/person-entry', 'Person_Entrys')->name('Person.Store');
        Route::post('/person/status', 'Person_Status')->name('Person.Status');
        Route::post('/person/edit', 'Person_Edit')->name('Person.Edit');
        Route::get('/customer-list', 'CustomerList')->name('Customer.List');


    });

});

Route::get('/google-auth-url', [GoogleDriveController::class, 'get_google_auth_url']);
Route::get('/google-callback', [GoogleDriveController::class, 'google_callback']);
Route::get('/check-google-auth', [GoogleDriveController::class, 'check_google_auth']);

/* Logout */
Route::get('/logout', function () {
    session()->forget(['isLoged']);
    return redirect("/dashboard");
});

/* If Route is not found in menu then it will redirect to noaccess page */
Route::get('/noaccess', function () {
    return view('errors.noaccess');
});

/* If upcoming pages */
Route::get('/coming-soon', function () {
    return view('errors.comingsoon');
});
