<?php

use App\Http\Controllers\TelegramController;
use App\Http\Controllers\WebController;
use Illuminate\Support\Facades\Route;

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

Route::get('',[WebController::class,'write']);

// Route::get('/', [WebController::class, 'storeData']);
// Route::get('/all', [WebController::class, 'sendForSubscribedUser']);
// Route::get('/test', [WebController::class, 'test2']);
// Route::get('/states', [WebController::class, 'removeJobOffersMoreThan40DaysAgo']);
// Route::get('/jobs', [WebController::class, 'fetchJobFields']);
// Route::get('/educations', [WebController::class, 'fetchEducations']);
// Route::get('/offers', [WebController::class, 'fetchJobOffers']);
// Route::get('/testSplit', [WebController::class, 'testSplit']);
// Route::get('/bank', [WebController::class, 'getAllBanksHiring']);
// Route::get('/government', [WebController::class, 'governmentHiring']);
// Route::get('/company', [WebController::class, 'fetchCompanies']);

// Route::get("bot/setWebHook", [TelegramController::class, 'setWebHook']);
// Route::get("bot/removeWebHook", [TelegramController::class, 'removeWebhook']);
// Route::post('/' . env('BOT_TOKEN') . env("BOT_Handle_Messages_Route"), [TelegramController::class, 'handleIncomingBotMessages']);
