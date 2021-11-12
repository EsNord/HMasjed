<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateUserRequest;
use App\Http\Requests\LoginRequest;
use App\Models\Role;
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
    
    public function test(){

        return ["sadsd"];
    
    }

    public function get_users(){
        return ["asda" => "asda"];
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

    public static function setRoles($nameRoles){
        $roles = Role::orderBy('index')->get();

        $binRoles = "";

        foreach ($roles as $role){
            if (in_array($role->name,$nameRoles)){
                $binRoles = "1" . $binRoles;
            }else{
                $binRoles = "0" . $binRoles;
            }
        }
        return $binRoles;
    }

    public function createUser(CreateUserRequest $request){
        $roles = $this->setRoles([$request['role']]);
        $permissions = Role::where('name',$request['role'])->first()->permissions;

        $user = User::create([
            'name' => $request['name'],
            'username' => $request['username'],
            'password' => Hash::make($request['password']),
            'roles' => $roles,
            'permissions' => $permissions,
            'api_token' => Str::random(80),
        ]);

        return [
            'status' => 200,
            'data' => $user,
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
