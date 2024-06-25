<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;


class Userseeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'role_id' => '1',
            'nama' => 'Dodi Satriawan',
            'npm_nidn_npak' => '210202090',
            'email' => 'satgas@gmail.com',
            'password' => Hash::make('satgas'),
            'remember_token' => Str::random(60),
        ]);

        User::create([
            'role_id' => '1',
            'nama' => 'Willy Devin',
            'npm_nidn_npak' => '210202048',
            'email' => 'satgas1@gmail.com',
            'password' => Hash::make('satgas'),
            'remember_token' => Str::random(60),
        ]);
        
        
        User::create([
            'role_id' => '2',
            'nama' => 'pelapor',
            'npm_nidn_npak' => '210202047',
            'email' => 'pelapor@gmail.com',
            'password' => Hash::make('pelapor'),
            'remember_token' => Str::random(60),
        ]);
    }
}
