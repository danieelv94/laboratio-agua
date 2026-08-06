<?php

namespace Database\Seeders;

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
        \App\Models\User::updateOrCreate(
            ['email' => 'staff@ceaa.gob.mx'],
            [
                'name' => 'Personal de la CEAA',
                'password' => bcrypt('password'),
            ]
        );
    }
}
