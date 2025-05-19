<?php

namespace Database\Seeders;

use Carbon\Carbon;
use App\Models\Admin;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
     
    public function run()
    {
        Admin::create([
            'name' => 'admin',
            'email' => 'admin@mywishlist.com',
            'password' => Hash::make('12345678')
        ]);
    }

}
