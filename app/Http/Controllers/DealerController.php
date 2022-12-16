<?php

namespace App\Http\Controllers;

use App\DataTables\DealerDataTable;
use App\Models\Dealer;
use App\Http\Controllers\Controller;
use App\Http\Requests\DealerRequest;
use Illuminate\Http\Request;

class DealerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(DealerDataTable $dataTable)
    {
        return $dataTable->render('dealer.index',[
            'title' => 'Dealer'
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('dealer.create',[
            'title' => 'Dealer Create'
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(DealerRequest $request)
    {
        //
        Dealer::create([
            'code'      => $request->code,
            'name'      => $request->name,
            'address'   => $request->address,
            'phone'     => $request->phone,
            'email'     => $request->email,
        ]);

        return redirect()->route('dealer.index')->with('success','Data berhasil ditambahkan');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Dealer  $dealer
     * @return \Illuminate\Http\Response
     */
    public function show(Dealer $dealer)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Dealer  $dealer
     * @return \Illuminate\Http\Response
     */
    public function edit(Dealer $dealer)
    {
        return view('dealer.edit',[
            'title'     => 'Edit Dealer',
            'dealer'    => $dealer,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Dealer  $dealer
     * @return \Illuminate\Http\Response
     */
    public function update(DealerRequest $request, Dealer $dealer)
    {
        $dealer->update([
            'code'      => $request->code,
            'name'      => $request->name,
            'address'   => $request->address,
            'email'     => $request->email,
            'phone'     => $request->phone
        ]);

        return redirect()->route('dealer.index')->with('success','Data Berhasil Diupdate');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Dealer  $dealer
     * @return \Illuminate\Http\Response
     */
    public function destroy(Dealer $dealer)
    {
        //
    }
}
