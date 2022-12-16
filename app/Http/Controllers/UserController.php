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
            $imageName = null;
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
                return $modelDealer;
            }),
            'user_has_position' => call_user_func(function() use ($user){
                $position = DB::table('model_has_position')->where('user_id',$user->id)->first();
                return $position;
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
    public function update(UserRequest $request, User $user)
    {
        //
        if (!is_null($request->sign)) {
            if(!is_null($user->sign))
            {
                if(file_exists(public_path('images\sign\\'.$user->sign))){
                    unlink(public_path('images\sign\\'.$user->sign));
                }
            }
            $imageName = time().'_'.$request->name.'.'.$request->sign->extension();
            $request->sign->move(public_path('images\sign\\'),$imageName);
        }else{
            $imageName = $user->sign;
        }

        $modelHasDealer = DB::table('model_has_dealer')->where('user_id',$user->id);
        $modelHasDealerQuery = $modelHasDealer->get();
        if(count($modelHasDealerQuery)!=0){
                $modelHasDealer->delete();
        }
        foreach ($request->dealer as $dlr) {
            DB::table('model_has_dealer')->insert([
                'user_id'       => $user->id,
                'model_type'    => 'App\Models\User',
                'dealer_id'     => $dlr
            ]);
        }

        $modelHasPosition = DB::table('model_has_position')->where('user_id',$user->id);
        if(!is_null($modelHasPosition))
        {
            $modelHasPosition->delete();
            DB::table('model_has_position')->insert([
                'user_id'       => $user->id,
                'model_type'    => 'App\Models\User',
                'position_id'   => $request->position
            ]);
        }

        $user->update([
            'name'  => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'sign'  => $imageName,
            'is_active' => $request->is_active,
        ]);

        return redirect()->route('user.index')->with('success','Data Berhasil Diupdate');
        
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
