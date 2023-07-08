<?php

use App\Models\Quote;
use App\Http\Controllers\QuoteController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/posts', function () {
    $data = ['message' => 'Hello World'];
    return response()->json($data);
});

// Not Good Practice

// 01
// Route::get('/quote/{id}', function ($id) {
//     $quote = Quote::find($id);
//     if ($quote) {
//         return response()->json($quote);
//     } else {
//         return response()->json(['message' => 'Quote not found'], 404);
//     }
// });

// 02
// Route::get('/quote/{id}', [QuoteController::class, 'show']);

// 03
// Route::resource('quote', QuoteController::class);

// Best Practice

// Route::apiResource('/quote', QuoteController::class);

// route updae yang kurang

Route::put('/quoteUpdate/{id}', [QuoteController::class, 'update']);
