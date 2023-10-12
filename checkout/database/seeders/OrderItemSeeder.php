<?php

namespace Database\Seeders;

use App\Models\OrderItem;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class OrderItemSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::connection('old_mysql')->table('order_items')->get()->each(function ($orderItem) {
            OrderItem::create((array) $orderItem);
        });
    }
}
