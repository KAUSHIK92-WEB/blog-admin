<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class DummyUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // We set 'role' => 'author' so that these dummy users 
        // will receive the background new-category emails you just built!
        User::factory(50)->create([
            'role' => 'author',
            'password' => bcrypt('password'), // They can all log in with 'password'
        ]);
    }
}
