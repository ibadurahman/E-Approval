<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\SubItem;
use Illuminate\Http\Request;
use App\DataTables\SubItemDataTable;

class SubItemController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(SubItemDataTable $dataTable)
    {
        return $dataTable->render('subItem.index',[
            'title' => 'Sub Item'
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('subItem.create',[
            'title' => 'Create Sub Item',
            'items' => Item::all(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'item_id'   => ['required'],
            'name'      => ['required']
        ]);

        SubItem::create([
            'item_id'   => $request->item_id,
            'name'      => $request->name
        ]);

        return redirect()->route('subItem.index')->with('success','Data Sub Item Berhasil Ditambahkan');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\SubItem  $subItem
     * @return \Illuminate\Http\Response
     */
    public function show(SubItem $subItem)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\SubItem  $subItem
     * @return \Illuminate\Http\Response
     */
    public function edit(SubItem $subItem)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\SubItem  $subItem
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, SubItem $subItem)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\SubItem  $subItem
     * @return \Illuminate\Http\Response
     */
    public function destroy(SubItem $subItem)
    {
        //
    }

    
}
