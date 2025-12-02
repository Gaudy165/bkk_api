<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class AdminSeeder extends Seeder
{
    public function run(): void
    {
        User::create([
            'name' => 'Admin',
            'email' => 'admin@gmail.com',
            'password' => 'password',
            'role' => 'admin',
        ]);

        $this->command->info('Admin berhasil dibuat!');
        $this->command->info('Email: admin@gmail.com');
        $this->command->info('Password: password');
    }
}
