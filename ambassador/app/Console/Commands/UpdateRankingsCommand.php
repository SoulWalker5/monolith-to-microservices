<?php

namespace App\Console\Commands;

use App\Models\Order;
use DiKay\UserService;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Redis;

class UpdateRankingsCommand extends Command
{
    protected $signature = 'update:rankings';

    public function handle(UserService $userService)
    {
        $users = $userService->get('users')->collect();

        $ambassadors = $users->filter(fn ($user) => $user['is_admin'] === 0)->values();

        $bar = $this->output->createProgressBar($ambassadors->count());

        $bar->start();

        $ambassadors->each(function ($user) use ($bar) {
            $revenue = Order::where('user_id', $user->id)->sum('total');

            Redis::zadd('rankings', (int)$revenue, $user->first_name . ' ' . $user->last_name);

            $bar->advance();
        });

        $bar->finish();
    }
}
