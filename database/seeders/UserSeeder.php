<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
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
        $user = User::create([
            'name'      => 'admin',
            'email'     => 'admin@mail.com',
            'phone'     => '085772077222',
            'password'  => bcrypt('12345678'),
            'sign'      => '',
            'is_active' => true
        ]);

        DB::table('model_has_position')->insert([
            'user_id'       => $user->id,
            'model_type'    => 'App\Models\User',
            'position_id'   => 1
        ]);

        DB::table('model_has_dealer')->insert([
            'user_id'       => $user->id,
            'model_type'    => 'App\Models\User',
            'dealer_id'     => 1
        ]);

        DB::table('model_has_dealer')->insert([
            'user_id'       => $user->id,
            'model_type'    => 'App\Models\User',
            'dealer_id'     => 2
        ]);
    }
}
