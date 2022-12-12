<?php

namespace Database\Seeders;

use App\Models\Item;
use App\Models\SubItem;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class ItemSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $item = Item::create([
            'name'=>'Cost of Manpower',
        ]);
        SubItem::create([
            'item_id'   => $item->id,
            'name'      => 'Salary'
        ]);
        SubItem::create([
            'item_id'   => $item->id,
            'name'      => 'Insentif'
        ]);
        SubItem::create([
            'item_id'   => $item->id,
            'name'      => 'Meal Allowance'
        ]);
        SubItem::create([
            'item_id'   => $item->id,
            'name'      => 'Transport Allowance'
        ]);
        SubItem::create([
            'item_id'   => $item->id,
            'name'      => 'Bonus / THR'
        ]);
        SubItem::create([
            'item_id'   => $item->id,
            'name'      => 'Other Allowance'
        ]);

        $item = Item::create([
            'name'=>'Training Education and Recruitment'
        ]);
        SubItem::create([
            'item_id'   => $item->id,
            'name'      => 'Training and Education'
        ]);
        SubItem::create([
            'item_id'   => $item->id,
            'name'      => 'Recruitment'
        ]);
        SubItem::create([
            'item_id'   => $item->id,
            'name'      => 'Meeting'
        ]);

        $item = Item::create([
            'name'  => 'Entertainment'
        ]);
        SubItem::create([
            'item_id'   => $item->id,
            'name'      => 'Entertainment'
        ]);

        $item = Item::create([
            'name'  => 'Warehousing, Shipping, and Packing'
        ]);
        SubItem::create([
            'item_id'   => $item->id,
            'name'      => 'Shipping'
        ]);
        SubItem::create([
            'item_id'   => $item->id,
            'name'      => 'Warehouse'
        ]);
        SubItem::create([
            'item_id'   => $item->id,
            'name'      => 'Delivery'
        ]);
        SubItem::create([
            'item_id'   => $item->id,
            'name'      => 'Packaging'
        ]);

        $item = Item::create([
            'name'  => 'Tools and Equipment'
        ]);
        SubItem::create([
            'item_id'   => $item->id,
            'name'      => 'Uniform'
        ]);
        SubItem::create([
            'item_id'   => $item->id,
            'name'      => 'Tools Workshop'
        ]);
        SubItem::create([
            'item_id'   => $item->id,
            'name'      => 'Service Car'
        ]);

        $item = Item::create([
            'name'  => 'Repair and Maintenance'
        ]);
        SubItem::create([
            'item_id'   => $item->id,
            'name'      => 'Building / Workshop'
        ]);
        SubItem::create([
            'item_id'   => $item->id,
            'name'      => 'Workshop Equipment'
        ]);
        SubItem::create([
            'item_id'   => $item->id,
            'name'      => 'Transportation (Operational Vehicle)'
        ]);
        SubItem::create([
            'item_id'   => $item->id,
            'name'      => 'Office Equipment'
        ]);

        Item::create([
            'name'  => 'Communication Expense'
        ]);

        Item::create([
            'name'  => 'Transportation and Traveling'
        ]);

        Item::create([
            'name'  => 'Office Expense'
        ]);

        Item::create([
            'name'  => 'Taxes and Licenses'
        ]);

        Item::create([
            'name'  => 'Employees Compensation'
        ]);

        Item::create([
            'name'  => 'Part Purchase'
        ]);

        Item::create([
            'name'  => 'Utility and Energy'
        ]);

        Item::create([
            'name'  => 'Claim Expense'
        ]);

        Item::create([
            'name'  => 'Operational Expense'
        ]);

        Item::create([
            'name'  => 'Event'
        ]);
    }
}
