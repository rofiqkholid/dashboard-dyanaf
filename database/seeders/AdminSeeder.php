<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::updateOrCreate(
            ['email' => 'support@dyanaf.com'],
            [
                'google_id' => null,
                'name' => 'Admin Dyanaf',
                'email' => 'support@dyanaf.com',
                'avatar' => null,
                'is_admin' => true,
                'chat_display_name' => 'Admin',
                'email_verified_at' => now(),
                'password' => Hash::make('dyanaf13'),
            ]
        );
    }
}
