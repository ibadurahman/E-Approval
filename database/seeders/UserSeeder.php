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
            'name'      => 'admin Makassar',
            'email'     => 'admin.mk@mail.com',
            'phone'     => '085772077222',
            'password'  => bcrypt('12345678'),
            'sign'      => '',
            'is_active' => true
        ]);
        DB::table('model_has_position')->insert([
            'user_id'       => $user->id,
            'model_type'    => 'App\Models\User',
            'position_id'   => 2
        ]);
        DB::table('model_has_dealer')->insert([
            'user_id'       => $user->id,
            'model_type'    => 'App\Models\User',
            'dealer_id'     => 1
        ]);

        $user = User::create([
            'name'      => 'aftersales Manager Makassar',
            'email'     => 'assm.mk@mail.com',
            'phone'     => '085772077222',
            'password'  => bcrypt('12345678'),
            'sign'      => '',
            'is_active' => true
        ]);
        DB::table('model_has_position')->insert([
            'user_id'       => $user->id,
            'model_type'    => 'App\Models\User',
            'position_id'   => 5
        ]);
        DB::table('model_has_dealer')->insert([
            'user_id'       => $user->id,
            'model_type'    => 'App\Models\User',
            'dealer_id'     => 1
        ]);

        $user = User::create([
            'name'      => 'General Manager Makassar',
            'email'     => 'gm.mk@mail.com',
            'phone'     => '085772077222',
            'password'  => bcrypt('12345678'),
            'sign'      => '',
            'is_active' => true
        ]);
        DB::table('model_has_position')->insert([
            'user_id'       => $user->id,
            'model_type'    => 'App\Models\User',
            'position_id'   => 3
        ]);
        DB::table('model_has_dealer')->insert([
            'user_id'       => $user->id,
            'model_type'    => 'App\Models\User',
            'dealer_id'     => 1
        ]);

        $user = User::create([
            'name'      => 'admin Manado',
            'email'     => 'admin.mnd@mail.com',
            'phone'     => '085772077222',
            'password'  => bcrypt('12345678'),
            'sign'      => '',
            'is_active' => true
        ]);
        DB::table('model_has_position')->insert([
            'user_id'       => $user->id,
            'model_type'    => 'App\Models\User',
            'position_id'   => 2
        ]);
        DB::table('model_has_dealer')->insert([
            'user_id'       => $user->id,
            'model_type'    => 'App\Models\User',
            'dealer_id'     => 2
        ]);

        $user = User::create([
            'name'      => 'aftersales Manager Manado',
            'email'     => 'assm.mnd@mail.com',
            'phone'     => '085772077222',
            'password'  => bcrypt('12345678'),
            'sign'      => '',
            'is_active' => true
        ]);
        DB::table('model_has_position')->insert([
            'user_id'       => $user->id,
            'model_type'    => 'App\Models\User',
            'position_id'   => 5
        ]);
        DB::table('model_has_dealer')->insert([
            'user_id'       => $user->id,
            'model_type'    => 'App\Models\User',
            'dealer_id'     => 2
        ]);

        $user = User::create([
            'name'      => 'General Manager Manado',
            'email'     => 'gm.mnd@mail.com',
            'phone'     => '085772077222',
            'password'  => bcrypt('12345678'),
            'sign'      => '',
            'is_active' => true
        ]);
        DB::table('model_has_position')->insert([
            'user_id'       => $user->id,
            'model_type'    => 'App\Models\User',
            'position_id'   => 3
        ]);
        DB::table('model_has_dealer')->insert([
            'user_id'       => $user->id,
            'model_type'    => 'App\Models\User',
            'dealer_id'     => 2
        ]);

    }
}
