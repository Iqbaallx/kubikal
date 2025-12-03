<?php

namespace Database\Seeders;

use App\Models\Admin;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Check if admin already exists to prevent duplicates
        $existingAdmin = Admin::where('email', 'admin@kubikal.com')->first();
        
        if (!$existingAdmin) {
            Admin::create([
                'email' => 'admin@kubikal.com',
                'password' => Hash::make('admin123'),
            ]);
            
            $this->command->info('✓ Admin user created successfully!');
            $this->command->info('  Email: admin@kubikal.com');
            $this->command->info('  Password: admin123');
        } else {
            $this->command->warn('⚠ Admin user already exists, skipping...');
        }
    }
}
