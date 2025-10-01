<?php

namespace Database\Seeders;

use App\Models\TipeObat;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        // User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
        User::create([
            'nama' => 'admin',
            'username' => 'admin',
            'role' => 'admin',
            'password' => bcrypt('admin123'),
        ]);
        User::create([
            'nama' => 'kasir',
            'username' => 'kasir',
            'role' => 'kasir',
            'password' => bcrypt('kasir123'),
        ]);

        $dataTipeObat = ['bebas','bebas terbatas','keras','narkotika','psikotropika'];

        foreach( $dataTipeObat as $value ) {
            TipeObat::create([
                "nama"=> $value,
            ]);
        }
    }
}
