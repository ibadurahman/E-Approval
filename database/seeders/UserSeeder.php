<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        User::create([
            'name'      => 'admin',
            'email'     => 'admin@mail.com',
            'phone'     => '085772077222',
            'password'  => bcrypt('12345678'),
            'sign'      => '',
            'is_active' => true
        ]);
    }
}
