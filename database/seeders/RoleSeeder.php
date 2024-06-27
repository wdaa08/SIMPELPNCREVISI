<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        Role::query()->delete();

        Role::create([
            "id"=> "1",
            "level"=> "satgas",
        ]);
        Role::create([
            "id"=> "2",
            "level"=> "pelapor",
        ]);
    }
}
