<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Role;

class RoleSeeder extends Seeder
{
    public function run()
    {
        Role::create([
            'role' => 'Backend developer'
        ]);

        Role::create([
            'role' => 'Frontend developer'
        ]);

        Role::create([
            'role' => 'UX developer'
        ]);

        Role::create([
            'role' => 'Full-stack developer'
        ]);

        Role::create([
            'role' => 'Human resources'
        ]);

        Role::create([
            'role' => 'Marketing'
        ]);
    }
}
