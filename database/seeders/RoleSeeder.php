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
        Role::updateOrCreate([
            'id' => '1',
        ], [
            'level' => 'satgas',
        ]);
    
        Role::updateOrCreate([
            'id' => '2',
        ], [
            'level' => 'pelapor',
        ]);
    
        Role::updateOrCreate([
            'id' => '3',
        ], [
            'level' => 'direktur',
        ]);
    }
    
}
