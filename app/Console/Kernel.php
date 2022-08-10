<?php

namespace App\Console;

use App\Http\Traits\AutoFetch;
use App\Http\Traits\Scheduler;
use Carbon\Carbon;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use Illuminate\Support\Facades\Log;

class Kernel extends ConsoleKernel
{
    use AutoFetch;
    use Scheduler;

    /**
     * Define the application's command schedule.
     *
     * @param \Illuminate\Console\Scheduling\Schedule $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        Log::debug(Carbon::now()." Running");
        $schedule->call(function () {
            $this->removeJobOffersMoreThan40DaysAgo();
        })->dailyAt('00:35');

        $schedule->call(function () {
            $this->getAllBanksHiring();
        })->dailyAt('00:32');


        $schedule->call(function () {
            $this->governmentHiring();
        })->dailyAt('00:38');

        $schedule->call(function () {
            $this->FetchEducationField();
        })->dailyAt('00:40');

        $schedule->call(function () {
            $this->fetchCompanies();
        })->dailyAt('00:00');

        $schedule->call(function () {
            $this->fetchRecruitmentAnnouncement();
        })->hourly();

        // $schedule->call(function () {
        //     $this->sendForSubscribedUser();
        // })->dailyAt('03:20');

        $schedule->call(function () {
            $this->FetchWorkField();
        })->everyFourHours();
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__ . '/Commands');

        require base_path('routes/console.php');
    }
}
