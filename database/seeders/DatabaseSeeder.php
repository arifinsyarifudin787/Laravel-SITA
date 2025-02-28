<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {   
        User::create([
            'name' => 'Bina Ragawan, M.T.',
            'role' => 'dosen',
            'username' => '0987654321',
            'password' => 'pabina'
        ]);

        User::create([
            'name' => 'Dedi Suhardi, S.T., M.Kom.',
            'role' => 'dosen',
            'username' => '12345678910',
            'password' => 'padedi'
        ]);
        
        User::create([
            'name' => 'Administrator',
            'role' => 'admin',
            'username' => 'admin',
            'password' => 'ifsakti'
        ]);
    }
}
