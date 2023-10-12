<?php

namespace Database\Seeders;

use App\Models\LinkProduct;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class LinkProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::connection('old_mysql')->table('link_products')->get()->each(function ($linkProduct) {
            LinkProduct::create((array) $linkProduct);
        });
    }
}
