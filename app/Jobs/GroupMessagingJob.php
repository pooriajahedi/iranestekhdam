<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use function App\Helpers\sendPhoto;
use function App\Helpers\SendTelegramMessage;
use function App\Helpers\SendTelegramMessageWithCustomUserId;

class GroupMessagingJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $imageName;
    protected $user;
    protected $caption;
    protected $type;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($imageName, $user, $caption, $type)
    {
        $this->imageName = $imageName;
        $this->user = $user;
        $this->caption = $caption;
        $this->type = $type;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        if ($this->type == "text") {
            SendTelegramMessageWithCustomUserId($this->caption, $this->user);
        } else if ($this->type == "image") {
            $url = env('APP_URL') . '/messaging/' . $this->imageName;
            sendPhoto($url, "file", $this->caption, $this->user->chat_id);
        }

    }
}
