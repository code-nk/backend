<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\TrackingController;
use App\Http\Controllers\SignupRecordController;
use App\Http\Controllers\CalendlyController;
use App\Http\Controllers\OpenAIController;


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

Route::group(['middleware'=>'api'],function($routes){
    Route::post('register',[AuthController::class,'register']);
    Route::post('login',[AuthController::class,'login']);
    Route::post('logout',[AuthController::class,'logout']);
    Route::post('refresh',[AuthController::class,'refresh']);
    Route::post('me',[AuthController::class,'me']);

});



/*
|--------------------------------------------------------------------------
| Tracking Controller Routes
|--------------------------------------------------------------------------
|
*/
Route::get('tracking-script', [TrackingController::class, 'getTrackingScript']);
Route::post('ping', [TrackingController::class, 'store']);
Route::get('see-visitors', [TrackingController::class, 'seeVisitors']);
Route::post('visitor-stats', [TrackingController::class, 'visitorStats']);
Route::post('fetch-session-details', [TrackingController::class, 'fetchSessionDetails']);
Route::post('fetch-visitor-journey', [TrackingController::class, 'fetchVisitorJourney']);

Route::post('add-signup-record', [SignupRecordController::class, 'store']);



//Route::post('hubspot-pings', [HubspotController::class, 'hubspotWebhook']);
// Calendly Routes
Route::post('calendly-pings', [CalendlyController::class, 'handleWebhook']);
Route::get('calendly', [CalendlyController::class, 'showCalendlyRecords']);
Route::get('monthly-calendly-stats', [CalendlyController::class, 'monthlyCalendlyStats']);
Route::get('daily-calendly-stats', [CalendlyController::class, 'dailyCalendlyStats']);
Route::get('all-calendly-stats/{startDate}/{endDate}', [CalendlyController::class, 'getCalendlyStatsByDateRange']);



// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::post('/get-chatgpt-response', [OpenAIController::class, 'getChatGPTResponse']);