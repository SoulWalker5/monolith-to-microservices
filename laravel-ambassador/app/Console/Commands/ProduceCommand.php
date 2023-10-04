<?php

namespace App\Console\Commands;

use App\Jobs\OrderCompleted;
use App\Jobs\ProduceJob;
use App\Models\Order;
use Illuminate\Console\Command;

class ProduceCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'produce';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $order = Order::first();

        OrderCompleted::dispatch($order->toArray() + [
            'admin_revenue' => $order->admin_revenue,
            'ambassador_revenue' => $order->ambassador_revenue,
        ]);
    }
}
