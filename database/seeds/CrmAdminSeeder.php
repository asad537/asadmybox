<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\CrmUser;

class CrmAdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Check if admin already exists
        $admin = CrmUser::where('email', 'admin@example.com')->first();

        if (!$admin) {
            CrmUser::create([
                'name' => 'Admin User',
                'email' => 'admin@example.com',
                'password' => Hash::make('password'),
                'role' => 'admin',
            ]);
            $this->command->info('Admin user created successfully.');
            $this->command->info('Email: admin@example.com');
            $this->command->info('Password: password');
        } else {
            $this->command->info('Admin user already exists.');
            $this->command->info('Email: admin@example.com');
            // We cannot show the password if it's already hashed, so we just show the email.
        }
    }
}
