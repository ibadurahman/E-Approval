<?php

namespace Database\Seeders;

use App\Models\Position;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class PositionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        Position::create([
            'name'  => 'PIC Service'
        ]);

        Position::create([
            'name'  => 'Admin'
        ]);

        Position::create([
            'name'  => 'General Manager'
        ]);

        Position::create([
            'name'  => 'Aftersales Manager'
        ]);

        Position::create([
            'name'  => 'Service Manager'
        ]);
    }
}
