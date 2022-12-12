<?php

namespace App\Jobs;

use App\Mail\newDisparo as MailNewDisparo;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;


use stdClass;

class newDisparo implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    // public $tries = 3;
    private $user;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(stdClass $user)
    {
        $this->user = $user;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        // Mail::send(new newDisparo($this->user));
        Mail::send(new MailNewDisparo($this->user));
    }
}
