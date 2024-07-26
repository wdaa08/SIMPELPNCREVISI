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
    public function run()
    {
        // User::create([
        //     'role_id' => 1,
        //     'nama' => 'Dodi Satriawan',
        //     'npm_nidn_npak' => '210202090',
        //     'nomorhp' => '081234567890',
        //     'domisili' => 'Jawa Timur',
        //     'email' => 'satgas@gmail.com',
        //     'password' => Hash::make('satgas'),
        //     'remember_token' => Str::random(60),
        // ]);

        // User::create([
        //     'role_id' => 1,
        //     'nama' => 'Willy Devin',
        //     'npm_nidn_npak' => '210202048',
        //     'nomorhp' => '081234567891',
        //     'domisili' => 'Jawa Timur',
        //     'email' => 'satgas1@gmail.com',
        //     'password' => Hash::make('satgas'),
        //     'remember_token' => Str::random(60),
        // ]);

        User::create([
            'role_id' => 3,
            'nama' => 'Riyadi Purwanto, S.T., M.Eng.',
            'npm_nidn_npak' => '198503182019031013',
            'nomorhp' => '081234567871',
            'domisili' => 'Jawa Tengah',
            'email' => 'riyadi@gmail.com',
            'password' => Hash::make('riyadi'),
            'remember_token' => Str::random(60),
        ]);
    }
}
