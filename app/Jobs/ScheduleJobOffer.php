<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use function App\Helpers\ConvertToUTF8;
use function App\Helpers\SendTelegramMessageAsHTML;
use function App\Helpers\SendTelegramMessageAsHTMLWithUserId;

class ScheduleJobOffer implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $jobOffer;
    protected $user;
    protected $keyboard;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($jobOffer, $user, $keyboard)
    {
        $this->jobOffer = $jobOffer;
        $this->user = $user;
        $this->keyboard = $keyboard;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        SendTelegramMessageAsHTMLWithUserId(ConvertToUTF8($this->jobOffer), $this->user, $this->keyboard);

    }
}
