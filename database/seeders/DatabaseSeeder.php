<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'name' => 'admin',
            'email' => 'admin@gmail.com',
            'phone' => '09684333435',
            'address' => 'Taunggyi',
            'role' => 'admin',
            'gender' => 'male',
            'password' => Hash::make('admin1234')
        ]);
    }
}
