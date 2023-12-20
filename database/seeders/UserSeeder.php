<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        \App\Models\User::factory(10)->create();

        \App\Models\User::create([
            'name' => 'Admin Maulana',
            'email' => 'maulana@fic11.com',
            'phone' => '089633755424',
            'roles' => 'ADMIN',
            'password' => Hash::make('12345678'),
        ]);
    }
}
