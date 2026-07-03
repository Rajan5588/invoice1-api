<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\BusinessProfileController;
use App\Http\Controllers\ItemCategoryController;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\SubscriptionController;
use App\Http\Controllers\CouponController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\RolesPermissionController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\ExpenseController;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/


Auth::routes();
Route::get('/apitest', function () {
    return response()->json([
        'status' => true,
        'message' => 'JSON Working'
    ]);
});

Route::middleware(['auth', 'company.prefix'])
    ->prefix('{company_slug}')
    ->group(function () {
        
  Route::prefix('admin-expenses')->name('admin-expenses.')->group(function () {
            Route::get('/', [ExpenseController::class, 'index'])->name('index');
            Route::get('/{expense}/edit', [ExpenseController::class, 'edit'])->name('edit');
            Route::post('/', [ExpenseController::class, 'store'])->name('store');
            Route::put('/{expense}', [ExpenseController::class, 'update'])->name('update');
            Route::delete('/{expense}', [ExpenseController::class, 'destroy'])->name('destroy');
            Route::post('/{expense}/status', [ExpenseController::class, 'updateStatus'])->name('status');
        });

Route::resource('admin-customers', CustomerController::class)
            ->names('admin-customers');

        // For DataTables Ajax
        Route::get('admin-customers-data', [CustomerController::class, 'getData'])
            ->name('admin-customers.get');

Route::get('/roles',[RoleController::class,'index'])->name('roles.index');
Route::post('/roles',[RoleController::class,'store'])->name('roles.store');
Route::put('/roles/{id}',[RoleController::class,'update'])->name('roles.update');
Route::get('/roles/get',[RoleController::class,'getRoles'])->name('roles.get');
Route::delete('/roles/{id}', [RoleController::class,'destroy'])->name('roles.destroy');



Route::resource('/permissions', RolesPermissionController::class);

Route::prefix('/company')->name('company.')->group(function () {
    Route::get('/get', [UserController::class, 'getCompanies'])->name('get');
     Route::get('/', [UserController::class, 'indexCompany'])->name('index'); 
         Route::post('/', [UserController::class, 'storeCompany'])->name('store'); 
    Route::get('/create', [UserController::class, 'createCompany'])->name('create');
    
    Route::get('/{id}/edit', [UserController::class, 'editCompany'])->name('edit');
    Route::put('/{id}', [UserController::class, 'updateCompany'])->name('update'); 
});


Route::prefix('/users')->name('users.')->group(function () {
    // DataTable
    Route::get('/get', [UserController::class, 'getUsers'])->name('get');

    // CRUD
    Route::get('/', [UserController::class, 'index'])->name('index');   // list
    Route::get('/create', [UserController::class, 'create'])->name('create'); // form
    Route::post('/', [UserController::class, 'store'])->name('store');  // save new
    Route::get('/{id}', [UserController::class, 'show'])->name('show'); // details
    Route::get('/{id}/edit', [UserController::class, 'edit'])->name('edit'); // edit form
    
    Route::put('/{id}', [UserController::class, 'update'])->name('update');  // update
    Route::delete('/{id}', [UserController::class, 'destroy'])->name('destroy'); // delete

    // Related Data
    Route::get('/{id}/invoices', [UserController::class, 'getInvoices'])->name('invoices');
    Route::get('/{id}/transactions', [UserController::class, 'getTransactions'])->name('transactions');
});





// Transactions Routes
Route::prefix('/transactions')->group(function () {
    // Main transactions page (table view)
    Route::get('/', [TransactionController::class, 'index'])->name('transactions.index');

    // Data for DataTable (AJAX call)
    Route::get('/get', [TransactionController::class, 'getTransactions'])->name('transactions.get');

    // Show single transaction details
 
});


Route::get('/invoices', [InvoiceController::class, 'index'])->name('invoices.index');
Route::get('/invoices/create', [InvoiceController::class, 'create'])->name('invoices.create');
Route::get('/invoices/get', [InvoiceController::class, 'getInvoices'])->name('invoices.get');
Route::post('/invoices', [InvoiceController::class, 'store'])->name('invoices.store');

// ✅ Edit & Update routes
Route::get('/invoices/{id}/edit', [InvoiceController::class, 'edit'])->name('invoices.edit');
Route::put('/invoices/{id}', [InvoiceController::class, 'update'])->name('invoices.update');

Route::get('/invoices/{id}', [InvoiceController::class, 'show'])->name('invoices.show');
Route::get('/invoices/bill1/{id}', [InvoiceController::class, 'showbill1'])->name('invoices.bill1');
Route::get('/invoices/bill2/{id}', [InvoiceController::class, 'showbill2'])->name('invoices.bill2');
Route::delete('/invoices/destroy', [InvoiceController::class, 'destroy'])->name('invoices.destroyy');

Route::resource('/coupons', CouponController::class)->except(['create', 'show', 'edit']);


Route::get('/index/{locale}', [HomeController::class, 'lang']);



Route::get('/items', [ItemController::class, 'index'])->name('items.index');
Route::get('/items/get', [ItemController::class, 'get'])->name('items.get');
Route::post('/items/store', [ItemController::class, 'store'])->name('items.store');

// Show item details
Route::get('/items/{id}', [ItemController::class, 'show'])->name('items.show');

// Edit item
Route::get('/items/{id}/edit', [ItemController::class, 'edit'])->name('items.edit');

// Update item
Route::post('/items/{id}/update', [ItemController::class, 'update'])->name('items.update');

Route::delete('/items/{id}/delete', [ItemController::class, 'destroy'])->name('items.destroy');

Route::resource('/subscriptions', SubscriptionController::class);

Route::get('/item-categories', [ItemCategoryController::class, 'index'])->name('item_categories.index');
Route::get('/item-categories/get', [ItemCategoryController::class, 'get'])->name('item_categories.get');
Route::delete('/item-categories/{id}', [ItemCategoryController::class, 'destroy'])->name('item_categories.destroy');
Route::post('/categories/store', [ItemCategoryController::class, 'store'])->name('categories.store');




Route::prefix('/business-profiles')->name('business_profiles.')->group(function () {
    Route::get('/', [BusinessProfileController::class, 'index'])->name('index');
    Route::get('/get', [BusinessProfileController::class, 'getBusinessProfiles'])->name('get');
    Route::get('/create', [BusinessProfileController::class, 'create'])->name('create');
    Route::get('/{id}', [BusinessProfileController::class, 'show'])->name('show');
    Route::delete('/{id}', [BusinessProfileController::class, 'destroy'])->name('destroy');


    // Store route
    Route::post('/', [BusinessProfileController::class, 'store'])->name('store');
});




    Route::get('/', [HomeController::class, 'root'])->name('root');
    Route::post('/update-profile/{id}', [HomeController::class, 'updateProfile'])->name('updateProfile');
    Route::post('/update-password/{id}', [HomeController::class, 'updatePassword'])->name('updatePassword');

 });
