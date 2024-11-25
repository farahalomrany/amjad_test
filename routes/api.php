<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\api\CompanyController;
use App\Http\Controllers\api\EmployeeController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();

});
Route::group(['middleware' => ['auth:sanctum', 'verified']], function () {

});

// Route::get('/users/all', [AuthController::class, 'index']);
Route::middleware('auth:sanctum')->get('/users/all', [AuthController::class, 'index']);

Route::post('login', [AuthController::class, 'login']);

// Route::post('/logout', [AuthController::class, 'logout']);
Route::middleware('auth:sanctum')->post('logout', [AuthController::class, 'logout']);


//CompanyController
Route::get('/companies', [CompanyController::class, 'index'])->name('companies.index');
Route::get('/companies/pag', [CompanyController::class, 'index_pag'])->name('companies.index_pag');
Route::post('/companies', [CompanyController::class, 'store'])->name('companies.store');
Route::get('/companies/show/{id}', [CompanyController::class, 'show'])->name('companies.show');
Route::post('/companies/update/{id}', [CompanyController::class, 'update'])->name('companies.update');
Route::post('/companies/delete/{id}', [CompanyController::class, 'delete'])->name('companies.delete');

//EmployeeController
Route::get('/employees', [EmployeeController::class, 'index'])->name('employees.index');
Route::get('/employees/pag', [EmployeeController::class, 'index_pag'])->name('employees.index_pag');
Route::post('/employees', [EmployeeController::class, 'store'])->name('employees.store');
Route::get('/employees/show/{id}', [EmployeeController::class, 'show'])->name('employees.show');
Route::post('/employees/update/{id}', [EmployeeController::class, 'update'])->name('employees.update');
Route::post('/employees/delete/{id}', [EmployeeController::class, 'delete'])->name('employees.delete');


//lang

Route::get('/set-language/{locale}', function ($locale) {
    // Validate the locale before setting
    $supportedLocales = ['en', 'ar']; // Add more languages if necessary
    if (in_array($locale, $supportedLocales)) {
        app()->setLocale($locale);
        session()->put('locale', $locale);
    }

    return redirect()->back();  // Redirect the user back to the previous page
});
