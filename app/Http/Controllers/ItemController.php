<?php

namespace App\Http\Controllers;

use App\DataTables\ItemDataTable;
use App\Models\Item;
use Illuminate\Http\Request;

class ItemController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(ItemDataTable $dataTable)
    {
        return $dataTable->render('item.index',[
            'title' => 'Item'
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('item.create',[
            'title' => 'Create Item'
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
            'name'  => ['required']
        ]);

        Item::create([
            'name'  => $request->name
        ]);

        return redirect()->route('item.index')->with('success','Data Item Berhasil Ditambahkan');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Item  $item
     * @return \Illuminate\Http\Response
     */
    public function edit(Item $item)
    {
        return view('item.edit',[
            'title'     => 'Edit Item',
            'item'  => $item
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Item  $item
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Item $item)
    {
        $validation = $request->validate([
            'name'  => ['required','min:3']
        ]);

        if (!$validation) {
            return redirect()->route('item.index')->with('error','Data Item Gagal Diupdate');
        }

        $item->update([
            'name'  => $request->name
        ]);

        return redirect()->route('item.index')->with('success','Data Item Berhasil Diupdate');
    }
}
