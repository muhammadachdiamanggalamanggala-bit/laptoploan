<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    public function run(): void
    {
        $admin = User::firstOrNew([
            'email' => config('app.admin.email'),
        ]);

        $admin->fill([
            'name' => config('app.admin.name'),
            'role' => 'admin',
            'is_active' => true,
        ]);

        if (! $admin->exists) {
            $admin->password = config('app.admin.password');
        }

        $admin->save();
    }
}