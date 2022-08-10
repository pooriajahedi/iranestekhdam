<?php

use App\Http\Controllers\AdminController;

Route::get('', [AdminController::class,'login']);
Route::post('', [AdminController::class,'doLogin'])->name('do.login');
Route::get('login', [AdminController::class,'login'])->name('login');
Route::get('logout', [AdminController::class,'logout'])->name('logout');

Route::group(['middleware' => 'admin'], function () {

    Route::get('dashboard', [AdminController::class,'dashboard'])->name('dashboard');

    Route::group(['prefix' => 'manager'], function () {
        Route::get('list', [AdminController::class,'listManagers'])->name('manager.list');
        Route::get('new', [AdminController::class,'addManager'])->name('manager.new');;
        Route::get('edit/{id}',  [AdminController::class,'edit'])->name('manager.edit');;
        Route::get('delete/{id}',  [AdminController::class,'deleteManager'])->name('manager.delete');;
        Route::post('new/store', [AdminController::class,'storeManager'])->name('manager.store');;
        Route::post('edit/store/{id}', [AdminController::class,'updateManager'])->name('manager.update');;

    });

    Route::group(['prefix' => 'user'], function () {
        Route::get('', [AdminController::class,'listUsers'])->name('user.index');
        Route::get('list', [AdminController::class,'listUsers'])->name('user.list');
        Route::get('delete/{id}',  [AdminController::class,'deleteUser'])->name('user.delete');;
        Route::get('change-mode/{id}',  [AdminController::class,'refreshUserStatus'])->name('user.changeStatus');;
        Route::get('direct/{id}',  [AdminController::class,'sendDirectMessage'])->name('user.direct');
        Route::post('send-direct/{id}',  [AdminController::class,'doSendDirectMessage'])->name('user.direct.send');
        Route::get('subscription/{id}',  [AdminController::class,'showUserSubscriptions'])->name('user.show.subscription');

    });

    Route::group(['prefix' => 'joboffer'], function () {
        Route::get('', [AdminController::class,'listJobOffers'])->name('job_offer.index');
        Route::get('list', [AdminController::class,'listJobOffers'])->name('job_offer.list');
        Route::get('job-offer-update', [AdminController::class,'updateJobOffers'])->name('job_offer.update');
        Route::get('delete-job-offer/{id}', [AdminController::class,'removeJobOffer'])->name('job_offer.delete');

        Route::get('bank-job-list', [AdminController::class,'listBanksJobOffers'])->name('bank_job_offer.list');
        Route::get('bank-offer-update', [AdminController::class,'updateBanksJobOffers'])->name('bank_job_offer.update');

        Route::get('governmental-job-list', [AdminController::class,'listGovernmentJobOffers'])->name('governmental_job_offer.list');
        Route::get('government-offer-update', [AdminController::class,'updateGovernmental'])->name('government_job_offer.update');

    });

    Route::group(['prefix' => 'field'], function () {
        Route::get('', [AdminController::class,'listEducationFields'])->name('job_offer.index');
        Route::get('education', [AdminController::class,'listEducationFields'])->name('education.list');
        Route::get('education-update', [AdminController::class,'updateEducation'])->name('education.update');

        Route::get('job-title', [AdminController::class,'listJobTitleFields'])->name('job_title.list');
        Route::get('job-title/edit/{id}', [AdminController::class,'listJobTitleFields'])->name('job_title.edit');
        Route::get('job-title/edit/{id}', [AdminController::class,'listJobTitleFields'])->name('job_title.update');
        Route::get('job-title-update', [AdminController::class,'updateJobTitle'])->name('job_title.update');

    });

    Route::group(['prefix' => 'setting'], function () {
        Route::get('bot', [AdminController::class,'loadBotSetting'])->name('setting.bot');
        Route::post('store/bot', [AdminController::class,'storeBotSetting'])->name('setting.store.bot');

    });


    Route::group(['prefix' => 'message'], function () {
        Route::get('all', [AdminController::class,'sendGroupMessage'])->name('messaging.all');
        Route::post('send', [AdminController::class,'doSendMessage'])->name('messaging.send');

    });
    Route::group(['prefix' => 'support'], function () {
        Route::get('', [AdminController::class,'listAllTickets'])->name('support.list');
        Route::get('reply/{id}', [AdminController::class,'replyTicket'])->name('support.reply');
        Route::post('reply/store/{id}', [AdminController::class,'storeTicketReply'])->name('support.reply.store');
        Route::get('close/{id}', [AdminController::class,'closeTicket'])->name('support.close');
        Route::get('open/{id}', [AdminController::class,'openTicket'])->name('support.open');
        Route::get('category/', [AdminController::class,'listSupportCategory'])->name('support.category.list');
        Route::get('category/new', [AdminController::class,'newSupportCategory'])->name('support.category.new');
        Route::get('category/edit/{id}', [AdminController::class,'editSupportCategory'])->name('support.category.edit');
        Route::post('category/new/store', [AdminController::class,'newSupportCategoryStore'])->name('support.category.new.store');
        Route::post('category/edit/store/{id}', [AdminController::class,'editSupportCategoryStore'])->name('support.category.edit.store');
        Route::get('category/delete/{id}', [AdminController::class,'deleteCategorySupport'])->name('support.category.delete');


    });
    Route::group(['prefix' => 'employee'], function () {
        Route::get('', [AdminController::class,'listEmployeeRequest'])->name('employee.request.list');
        Route::get('info/{id}', [AdminController::class,'viewRequest'])->name('employee.request.info');
        Route::get('download/{id}', [AdminController::class,'downloadAttachment'])->name('employee.request.download');
        Route::get('accept/{id}', [AdminController::class,'acceptRequest'])->name('employee.request.accept');
        Route::get('reject/{id}', [AdminController::class,'rejectRequest'])->name('employee.request.reject');
        Route::get('process/{id}', [AdminController::class,'reviewRequest'])->name('employee.request.review');
    });

    Route::group(['prefix' => 'appInfo'], function () {
        Route::get('', [AdminController::class,'loadAppInfo'])->name('appInfo.load');
        Route::post('update', [AdminController::class,'updateAppInfo'])->name('appInfo.update');
    });

    Route::group(['prefix' => 'report'], function () {
        Route::get('', [AdminController::class,'loadReports'])->name('report.list');
    });

    });
