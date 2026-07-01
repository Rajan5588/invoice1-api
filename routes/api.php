<?php

use Illuminate\Http\Request;
use App\Http\Controllers\Api\LoginApiController;

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\TemplatesController;
use App\Http\Controllers\Api\ItemCategoryController;
use App\Http\Controllers\Api\BusinessProfileApiController;
use Illuminate\Support\Facades\Http;
use App\Http\Controllers\Api\CustomerController;
use App\Http\Controllers\Api\ItemController;
use App\Http\Controllers\Api\StockController;
use Google\Client;
use App\Http\Controllers\Api\HistoryController;
use App\Http\Controllers\TransactionController;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\Api\InvoiceController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\Api\SubscriptionController;
use App\Http\Controllers\Api\SubscribedUserController;
use App\Http\Controllers\CouponController;
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


Route::get('/test-fcm', function () {
    // Load service account from file
    $serviceAccountPath = storage_path('app/firebase.json');

    $client = new Client();
    $client->setAuthConfig($serviceAccountPath);
    $client->addScope('https://www.googleapis.com/auth/firebase.messaging');

    // Get access token
    $token = $client->fetchAccessTokenWithAssertion();
    $accessToken = $token['access_token'];

    // Device token (replace with your FCM token)
    $deviceToken = "eB0PNA-qRY-lCsLQoKzzNC:APA91bEc_4ydK6zdip1Uv9eLhzZ3awKCIwlvheY0I_Wtkh0qp0NrzwNr0sTf8V63TiwP3a2yc132nuK5ke_buom2I4MHloBfAxEa6S5FA1-odFAcz4xP5nQ";

    $projectId = json_decode(file_get_contents($serviceAccountPath), true)['project_id'];
    $url = "https://fcm.googleapis.com/v1/projects/{$projectId}/messages:send";

    $response = Http::withToken($accessToken)->post($url, [
        "message" => [
            "token" => $deviceToken,
            "notification" => [
                "title" => "Test Notification 🚀",
                "body"  => "Hello from Laravel using Firebase Admin SDK!"
            ],
            "data" => [
                "custom_key" => "custom_value"
            ]
        ]
    ]);

    return $response->json();
});


Route::get('/users', [UserController::class, 'getUsers']);

Route::get('/subscriptions', [SubscriptionController::class, 'index']);
Route::post('/subscribed-user-store', [SubscribedUserController::class, 'store']);

Route::prefix('transactions')->group(function () {
    Route::get('/', [TransactionController::class, 'index']);
    Route::post('/', [TransactionController::class, 'store']);
    Route::get('/status-change', [TransactionController::class, 'changeStatus']);
Route::get('/user/total-collection', [TransactionController::class, 'totalCollectionByUser']);
    Route::get('/{id}', [TransactionController::class, 'show']);
    Route::put('/{id}', [TransactionController::class, 'update']);
    Route::delete('/{id}', [TransactionController::class, 'destroy']);

    // Custom
    
    Route::get('/user/{user_id}', [TransactionController::class, 'getByUser']);
   


});

Route::prefix('invoices')->group(function () {
    Route::get('/', [InvoiceController::class, 'index']);
    Route::post('/', [InvoiceController::class, 'store']);

    // Must go before {id}
    Route::get('/user', [InvoiceController::class, 'getByUser']);
    Route::post('/update', [InvoiceController::class, 'update']);

    Route::get('/{id}', [InvoiceController::class, 'show']);

    // Changed from DELETE to GET with query param ?action=
Route::post('/action', [InvoiceController::class, 'destroy'])->name('invoices.destroy');

});




Route::prefix('histories')->group(function () {
    Route::get('/', [HistoryController::class, 'index']);            // all histories
    Route::get('/user/{user_id}', [HistoryController::class, 'getByUser']); // histories by user
              // add history
});
Route::post('/validate-coupon', [CouponController::class, 'validateCoupon']);

Route::prefix('stocks')->group(function () {
    // Create stock
    Route::post('/', [StockController::class, 'store']);

    // Update stock
    Route::post('/update', [StockController::class, 'update']); // POST for multipart

    // Delete stock
    Route::delete('/{id}', [StockController::class, 'destroy']);

    // Get stocks by item_id
    Route::get('/item/{item_id}', [StockController::class, 'getByItem']);
    
     Route::get('/{id}', [StockController::class, 'show']);

    // Get stocks by user_id
    Route::get('/user/{user_id}', [StockController::class, 'getByUser']);
});


Route::prefix('items')->group(function() {
    Route::get('/', [ItemController::class, 'index']);       
    Route::post('/', [ItemController::class, 'store']);

    // must be above {id}
    Route::get('/user', [ItemController::class, 'getItemsByUser']);

    Route::get('/{id}', [ItemController::class, 'show']);
    Route::post('/update', [ItemController::class, 'update']);
    Route::delete('/{id}', [ItemController::class, 'destroy']);
});



Route::prefix('customers')->group(function () {
    Route::get('/', [CustomerController::class, 'index']);       // List all
    Route::post('/byuser', [CustomerController::class, 'showbyuser']);    // View single
    Route::post('/', [CustomerController::class, 'store']);      // Add
    Route::put('/{id}', [CustomerController::class, 'update']);  // Update
    Route::delete('/{id}', [CustomerController::class, 'destroy']); // Delete
});

Route::prefix('item-categories')->group(function () {
    Route::get('/', [ItemCategoryController::class, 'index']);       // List all
    Route::post('/byuser', [ItemCategoryController::class, 'showbyuser']);    // View single
    Route::post('/', [ItemCategoryController::class, 'store']);      // Add
    Route::put('/{id}', [ItemCategoryController::class, 'update']);  // Update
    Route::delete('/{id}', [ItemCategoryController::class, 'destroy']); // Delete
});


Route::get('business-profiles', [BusinessProfileApiController::class, 'index']);
Route::post('business-profiles', [BusinessProfileApiController::class, 'store']);
Route::delete('business-profiles/{id}', [BusinessProfileApiController::class, 'destroy']);

Route::get('/bill-first-template', [TemplatesController::class, 'getTemplate']);



 Route::get('/get-user-details', [LoginApiController::class, 'getProfile']);
    Route::post('/send-otp', [LoginApiController::class, 'sendOtp']);
    Route::post('/verify-otp', [LoginApiController::class, 'verifyOtp']);
    Route::post('/update-user-info', [LoginApiController::class, 'updateUserInfo']);