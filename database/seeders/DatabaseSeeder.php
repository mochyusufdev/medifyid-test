<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Database\Seeders\MasterSeeder;
use Database\Seeders\KategoriItemSeeder;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        $this->call([
            KategoriItemSeeder::class,
            MasterSeeder::class,
        ]);
    }
}
