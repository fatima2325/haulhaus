<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;

class CreateAdminUser extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'admin:create {email?} {password?}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create an admin user with username "admin"';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $email = $this->argument('email') ?: $this->ask('Enter email address');
        $password = $this->argument('password') ?: $this->secret('Enter password');
        
        // Check if admin user already exists
        $existingAdmin = User::where('name', 'admin')->first();
        if ($existingAdmin) {
            if ($this->confirm('Admin user already exists. Update it?', true)) {
                $existingAdmin->update([
                    'email' => $email,
                    'password' => Hash::make($password),
                ]);
                $this->info('Admin user updated successfully!');
                $this->info('Email: ' . $email);
                $this->info('Username: admin');
                return 0;
            } else {
                $this->info('Operation cancelled.');
                return 0;
            }
        }
        
        // Create new admin user
        User::create([
            'name' => 'admin',
            'email' => $email,
            'password' => Hash::make($password),
        ]);
        
        $this->info('Admin user created successfully!');
        $this->info('Email: ' . $email);
        $this->info('Username: admin');
        $this->info('Password: [the password you entered]');
        
        return 0;
    }
}
