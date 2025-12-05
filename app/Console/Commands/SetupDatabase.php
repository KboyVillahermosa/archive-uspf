<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Artisan;

class SetupDatabase extends Command
{
    /**
     * The name and signature of the console command.
     */
    protected $signature = 'app:setup-database';

    /**
     * The console command description.
     */
    protected $description = 'Setup database for Laravel Cloud deployment';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('🚀 Setting up database for Laravel Cloud...');

        // Test database connection
        try {
            DB::connection()->getPdo();
            $this->info('✅ Database connection successful');
        } catch (\Exception $e) {
            $this->error('❌ Database connection failed: ' . $e->getMessage());
            return 1;
        }

        // Run migrations
        $this->info('🔄 Running migrations...');
        try {
            Artisan::call('migrate', ['--force' => true]);
            $this->info('✅ Migrations completed');
        } catch (\Exception $e) {
            $this->error('❌ Migration failed: ' . $e->getMessage());
            return 1;
        }

        // Run seeders
        $this->info('🌱 Running seeders...');
        try {
            // First try to run the role seeder
            Artisan::call('db:seed', [
                '--class' => 'RoleSeeder',
                '--force' => true
            ]);
            
            // Then run the department program seeder
            Artisan::call('db:seed', [
                '--class' => 'DepartmentProgramSeeder', 
                '--force' => true
            ]);
            
            // Finally run the main database seeder
            Artisan::call('db:seed', [
                '--class' => 'DatabaseSeeder',
                '--force' => true
            ]);
            
            $this->info('✅ Seeders completed');
        } catch (\Exception $e) {
            $this->error('❌ Seeder failed: ' . $e->getMessage());
            
            // Try to create a basic user manually if seeding fails
            $this->info('🔄 Attempting to create basic user manually...');
            try {
                $user = \App\Models\User::firstOrCreate(
                    ['email' => 'fvillahermosa_ccs@uspf.edu.ph'],
                    [
                        'name' => 'Francisco Combong Villahermosa',
                        'password' => \Hash::make('password'),
                        'role' => 'student',
                        'status' => 'active',
                        'email_verified_at' => now(),
                    ]
                );
                $this->info('✅ Basic user created');
            } catch (\Exception $manualError) {
                $this->error('❌ Manual user creation failed: ' . $manualError->getMessage());
                return 1;
            }
        }

        $this->info('🎉 Database setup completed successfully!');
        $this->info('📊 Database status:');
        
        // Show user count
        try {
            $userCount = DB::table('users')->count();
            $this->info("   Users: {$userCount}");
            
            // Show test user credentials
            $testUser = DB::table('users')->where('email', 'fvillahermosa_ccs@uspf.edu.ph')->first();
            if ($testUser) {
                $this->info('🔑 Test login credentials:');
                $this->info('   Email: fvillahermosa_ccs@uspf.edu.ph');
                $this->info('   Password: password');
            }
            
        } catch (\Exception $e) {
            $this->error('❌ Could not verify database: ' . $e->getMessage());
        }

        return 0;
    }
}