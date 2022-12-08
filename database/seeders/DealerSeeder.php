<?php

namespace Database\Seeders;

use App\Models\Dealer;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class DealerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        Dealer::create([
            'code'      => '401',
            'name'      => 'Kumala Makassar',
            'address'   => 'Jl. AP. Pettarani no 98 B',
            'phone'     => '0411422999',
            'email'     => 'mail@kcawuling.com'
        ]);

        Dealer::create([
            'code'      => '402',
            'name'      => 'Kumala Manado',
            'address'   => 'Jl. Ring Road, Ruko Citraland Miracle Walk 6 No.12 Dan 15. Kelurahan Bumi Nyiur, Kec. Wanea',
            'phone'     => '0431836448',
            'email'     => 'mail@kcawuling.com'
        ]);
    }
}
