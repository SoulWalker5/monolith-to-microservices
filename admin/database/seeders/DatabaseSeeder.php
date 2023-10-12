<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\LinkProduct;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            ProductSeeder::class,
            LinkSeeder::class,
            LinkProductSeeder::class,
            OrderSeeder::class,
            OrderItemSeeder::class,
        ]);
    }
}
