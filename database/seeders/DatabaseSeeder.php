<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::create([
            'name' => 'Staff',
            'email' => 'staff@mail.com',
            'role' => 1,
            'password' => Hash::make('staff123'),
        ]);

        User::create([
            'name' => 'Admin',
            'email' => 'admin@mail.com',
            'role' => 0,
            'password' => Hash::make('admin123'),
        ]);


        $data = [
            ['nama_jenis' => 'Jual Tanah PT'],
            ['nama_jenis' => 'Jual Tanah Pribadi'],
            ['nama_jenis' => 'Jual Tanah Milik Suami-Istri'],
        ];

        DB::table('jenis_transaksis')->insert($data);

    }
}
