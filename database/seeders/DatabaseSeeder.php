<?php

namespace Database\Seeders;

use App\Models\User;
use Database\Seeders\CandidateSeeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        $user = User::factory()->create([
            'name' => 'Test User',
            'username' => 'testuser',
            'email' => 'test@example.com',
            'password' => bcrypt('password'),
            'is_admin' => true,
        ]);

        $user->voter()->create([
            'name' => 'Test User',
            'national_id' => 'RWA-0000000001',
        ]);

        $this->call(CandidateSeeder::class);
    }
}
