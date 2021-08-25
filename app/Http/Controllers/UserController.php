<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateUserRequest;
use App\Http\Requests\LoginRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    public function get_user(){
        $user = Auth::user();
        if ($user){
            return [
                'status' => 200,
                'data' => ['user' => $user]
            ];
        }else{
            return[
                'status' => 200,
                'data' => ['user' => null]
            ];
        }
    }

    public function login(LoginRequest $request){
        if(Auth::attempt(['username' => $request['username'], 'password' => $request['password']])){
            $user = Auth::user();
            $token = $user->api_token = Str::random(80);
            $user->save();

            return ['status' => 200,
                'data' => ['user' => $user,'token' => $token]
            ];
        }
        return ['status' => 200,
            'data' => false,
        ];
    }

    public function createUser(CreateUserRequest $request){
        $user = User::create([
            'name' => $request['name'],
            'username' => $request['username'],
            'password' => Hash::make($request['password']),
            'roles' => '0000',
            'permissions' => '000',
            'api_token' => Str::random(80),
        ]);

        return [
            $user,
        ];
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
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
    public function edit($id)
    {
        //
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
