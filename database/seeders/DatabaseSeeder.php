<?php

namespace Database\Seeders;
        use Illuminate\Support\Facades\Hash;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
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
        \App\Models\User::factory(10)->create();


\App\Models\User::factory()->create([
    'name' => 'hassan User',
    'email' => 'A@A',
    'password' => Hash::make('11'), // Hash the password
]);
    }
}
