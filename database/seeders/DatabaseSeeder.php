<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Admin kullanıcısı oluştur
        User::create([
            'name' => 'Admin',
            'email' => 'admin@verona.com',
            'password' => Hash::make('verona123'),
            'role' => 'admin',
        ]);

        // Kategorileri oluştur
        $this->call(CategorySeeder::class);
    }
}
