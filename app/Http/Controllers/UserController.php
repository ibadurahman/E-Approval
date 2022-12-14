<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Dealer;
use App\Models\Position;
use Illuminate\Http\Request;
use App\DataTables\UsersDataTable;
use App\Http\Requests\UserRequest;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(UsersDataTable $dataTable)
    {
        //
        return $dataTable->render('user.index',[
            'title' => 'User'
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        return view('user.create',[
            'title'     => 'Create User',
            'dealers'   => Dealer::all(),
            'positions' => Position::all()
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(UserRequest $request)
    {
        if(!$request->sign)
        {
            $imageName = '';
        }else{
            $imageName = time().'_'.$request->name.'.'.$request->sign->extension();
            $request->sign->move(public_path('images/sign'),$imageName);
        }

        $user = User::create([
            'name'      => $request->name,
            'email'     => $request->email,
            'phone'     => $request->phone,
            'password'  => bcrypt('12345678'),
            'sign'      => $imageName,
            'is_active' => $request->is_active
        ]);

        DB::table('model_has_position')->insert([
            'user_id'       => $user->id,
            'model_type'    => 'App\Model\User',
            'position_id'   => $request->position
        ]);

        foreach ($request->dealer as $dealer) {
            DB::table('model_has_dealer')->insert([
                'user_id'       => $user->id,
                'model_type'    => 'App\Model\User',
                'dealer_id'     => $dealer
            ]);
        }

        return redirect()->route('user.index')->with('success','Data berhasil ditambahkan');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        return view('user.edit',[
            'title'             => 'Edit User',
            'user'              => $user,
            'user_has_dealer'   => call_user_func(function() use ($user){
                $modelDealer = DB::table('model_has_dealer')->where('user_id',$user->id)->get();
                $modelHasDealers = [];
                foreach ($modelDealer as $dealer) {
                    $modelHasDealers[] = Dealer::where('id',$dealer->dealer_id)->first();
                }
                return $modelHasDealers;
            }),
            'dealers'           => Dealer::all(),
            'positions'         => Position::all()
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
