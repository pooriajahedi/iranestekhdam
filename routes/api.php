<?php

use App\Http\Controllers\ApiController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::group(['prefix'=>'v1'], function () {

    Route::group(['prefix'=>'dashboard'], function () {
        Route::get('/',[ApiController::class,'getDashboardItem']);

    });

    Route::group(['prefix'=>'job'], function () {
        Route::any('/',[ApiController::class,'GetAllJobOffers']);
        Route::any('/{id}',[ApiController::class,'getSingleJobOffer']);
        Route::any('/jobField',[ApiController::class,'GetWorkFields']);
    });

    Route::group(['prefix'=>'state'], function () {
        Route::any('/',[ApiController::class,'getStateList']);
        Route::any('/{id}',[ApiController::class,'GetStateJobOffers']);
    });
    Route::group(['prefix'=>'education'], function () {
        Route::any('/',[ApiController::class,'GetEducationFields']);
    });

    Route::group(['prefix'=>'company'], function () {
        Route::get('/cats',[ApiController::class,'getCompanyCategories']);
        Route::any('/',[ApiController::class,'getAllCompanies']);
        Route::get('/{id}',[ApiController::class,'getCompanyJobFields']);
        Route::get('/info/{id}',[ApiController::class,'getSingleCompanyInfo']);
    });
    Route::group(['prefix'=>'appSetting'], function () {
        Route::any('/',[ApiController::class,'getApplicationSettings']);
    });
    Route::group(['prefix'=>'firebase'], function () {
        Route::post('/store',[ApiController::class,'storeDeviceFcmId']);
    });

    Route::group(['prefix'=>'ticket'], function () {
        Route::get('/category',[ApiController::class,'getTicketCategories']);
        Route::post('/submit',[ApiController::class,'sendNewTicket']);
        Route::get('/list',[ApiController::class,'getUserTickets']);
        Route::post('/reply',[ApiController::class,'submitTicketRely']);
        Route::post('/loadReply',[ApiController::class,'loadTicketReplies']);
    });

    Route::group(['prefix'=>'employer'], function () {
        Route::post('/submit',[ApiController::class,'submitJobOffer']);
        Route::get('/check',[ApiController::class,'getUserRequests']);
    });

    Route::group(['prefix'=>'user'], function () {
        Route::post('/register',[ApiController::class,'register']);
        Route::post('/loginDevice',[ApiController::class,'loginByDevice']);
        Route::any('/{user_id}',[ApiController::class,'GetEducationFields']);

    });
    Route::group(['prefix'=>'report'], function () {
        Route::post('/',[ApiController::class,'report']);


    });
});
