<?php

namespace App\Jobs;

use App\Models\Order;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class OrderCompleted implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    public function __construct(public readonly array $data)
    {
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        Order::create([
           'id' => $this->data['id'],
           'user_id' => $this->data['user_id'],
           'code' => $this->data['code'],
           'total' => $this->data['ambassador_revenue'],
        ]);
    }
}
