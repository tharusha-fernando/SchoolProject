<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        $roles = [
            ['name' => 'superadmin', 'description' => 'Super Admin'],
            ['name' => 'admin', 'description' => 'Admin'],
            ['name' => 'tutor', 'description' => 'Tutor'],
            ['name' => 'student', 'description' => 'Student'],
        ];

        DB::table('roles')->insert($roles);
    }
}
