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

    private $orderData ;
    private $orderItemsData ;
    private $data;

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
        $this->orderData = $this->data[0];
        $this->orderItemsData = $this->data[1];
        // var_dump($this->data);
        Mail::send('influencer.admin-email', [
            'id' => $this->orderData['id'],
            'admin_total' => $this->orderData['admin_total']
        ], function ($message) {
            $message->to('admin@admin.com');
            $message->subject('A new order has been compeleted');
        });
        Mail::send('influencer.influencer-email', [
            'code' => $this->orderData['code'],
            'influencer_total' => $this->orderData['influencer_total']
        ], function ($message) {
            $message->to($this->orderData['influencer_email']);
            $message->subject('A new order has been compeleted');
        });
    }
}
