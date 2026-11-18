<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {

        $this->call([
            PenggunaSeeder::class,
        ]);
        $this->call([
    GelombangPendaftaranSeeder::class,
]);
$this->call([
    PersyaratanSeeder::class,
]);
    }
    
}
