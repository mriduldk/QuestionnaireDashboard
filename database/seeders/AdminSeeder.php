<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Admin;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    public function run(): void
    {
        Admin::create([
            'name' => 'Super Admin',
            'email' => 'superadmin@questionnaire.com',
            'phone' => '9999999999',
            'designation' => 'System Admin',
            'password' => Hash::make('Password@2233#'),
            'role' => 'super_admin',
            'is_deleted' => false,
            'created_by' => 'admin',
            'modified_by' => null,
        ]);
    }
}

