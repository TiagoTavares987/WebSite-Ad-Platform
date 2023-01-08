<?php

namespace Database\Seeders;

use App\Database\DB;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Anuncio;
use App\Models\Compra;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        DB::DisableForeignKeys();

        User::factory(10)->create();
        Anuncio::factory(100)->create();
        Compra::factory(3)->create();

        DB::EnableForeignKeys();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
    }
}
