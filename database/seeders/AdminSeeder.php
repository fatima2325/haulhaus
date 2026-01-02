<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $admin = User::where('name', 'admin')->first();

        if ($admin) {
            $admin->update([
                'email' => 'admin@haulhaus.com',
                'password' => Hash::make('12345678'),
            ]);
            $this->command->info('Admin user updated (admin@haulhaus.com / 12345678)');
        } else {
            User::create([
                'name' => 'admin',
                'email' => 'admin@haulhaus.com',
                'password' => Hash::make('12345678'),
            ]);
            $this->command->info('Admin user created (admin@haulhaus.com / 12345678)');
        }
    }
}
