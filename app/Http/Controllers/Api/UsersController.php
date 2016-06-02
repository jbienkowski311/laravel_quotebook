<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;

use App\User;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UsersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $offset = $request->has('offset') ? $request->input('offset') : 0;
        $limit = $request->has('limit') ? $request->input('limit') : 25;
        $all_users = User::count();
        $users = User::skip($offset)->take($limit)->get();
        return response()->json([
            'status' => 200,
            'metadata' => [
                'count' => $all_users,
                'offset' => $offset,
                'limit' => $limit
            ],
            'data' => $users
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
        $this->validate($request, [
            'name' => 'required',
            'email' => 'required|unique:users',
            'password' => 'required'
        ]);
        $user = new User();
        $user->name = $request->input('name');
        $user->email = $request->input('email');
        $user->password = Hash::make($request->input('password'));
        $user->api_token = str_random(60);
        $user->save();
        return response()->json([
            'status' => 200,
            'data' => $user
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $user = User::find($id);
        if(!$user){
            return response()->json([
                'status' => 404,
                'message' => 'User not found'
            ], 404);
        }
        return response()->json([
            'status' => 200,
            'data' => $user
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
        $this->validate($request, [
            'name' => 'required',
            'email' => 'required|unique:users'
        ]);
        $user = User::find($id);
        if(!$user){
            return response()->json([
                'status' => 404,
                'message' => 'User not found'
            ], 404);
        }
        if($request->has('password') && $request->has('new_password')){
            $credentials = [
                'email' => $user->email,
                'password' => $request->input('password')
            ];
            if(Auth::attempt($credentials)){
                $user->password = Hash::make($request->input('new_password'));
            }else{
                return response()->json('Unauthorized.', 401);
            }
        }
        $user->name = $request->input('name');
        $user->email = $request->input('email');
        $user->update();
        return response()->json([
            'status' => 200,
            'data' => $user
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user = User::find($id);
        if(!$user){
            return response()->json([
                'status' => 404,
                'message' => 'User not found'
            ], 404);
        }
        $user->quotes()->detach();
        $user->delete();
        return response()->json([
            'status' => 200,
            'message' => 'User deleted'
        ]);
    }
}
