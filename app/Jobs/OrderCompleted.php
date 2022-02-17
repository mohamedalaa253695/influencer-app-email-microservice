<?php
namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Support\Facades\Mail;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class OrderCompleted implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $data ;

    public function __construct($data)
    {
        $this->data = $data;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        // var_dump($this->data);
        Mail::send('influencer.admin-email', [
            'id' => $this->data['id'],
            'admin_total' => $this->data['admin_total']
        ], function ($message) {
            $message->to('admin@admin.com');
            $message->subject('A new order has been compeleted');
        });
        Mail::send('influencer.influencer-email', [
            'code' => $this->data['code'],
            'influencer_total' => $this->data['influencer_total']
        ], function ($message) {
            $message->to($this->data['influencer_email']);
            $message->subject('A new order has been compeleted');
        });
        // try {

        // } catch (\Exception $e) {
        //     dd($e);
        // }
    }
}
