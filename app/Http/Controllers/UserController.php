<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use App\Models\User;
use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use App\Http\Requests\StoreUserRequest;

class UserController extends Controller
{
    public function index()
    {
        $users = User::orderBy('name','desc')->paginate(6);
        // return ([
        // 'id' => $this->id,
        // 'name' => $this->name,
        // 'email' => $this->email,
        // ],200);
        return response()->json([
            'Success'=>true,
            'Data'=> $users
         ],200);
    }

    public function show($id)
    {
        $user = auth()->user()->find($id);
        if(!$user){
            return response()->json([
                'Success'=>false,
                'Data'=> 'User with id'.$id.'not found',
            ],404);
    }
        return response()->json([
            'Success'=>true,
            'Data'=> $user->toArray(),
        ],202);
    }

    public function store(StoreUserRequest $request)
    {
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
        ]);
        return new UserResource($user);
    }

    public function update(StoreUserRequest $request, $id)
    {
        $user = User::find($id);
        if (!$user){
             return response()->json([
                    'success'=>false,
                     'data'=>'User with id'.$id.'not found',
                 ],404);
        }
        $user->fill($request->all());
        $user->save();
    
        if($user){
        return response()->json([
            'Success'=>true,
            'Message'=>'User updated successfully',
            'data' => $user
            ],202);
        } else {
        return response()->json([
            'Success'=>false,
            'Message'=>'User could not be updated',
            ],401);
        }

        $user = User::update([
            'name' => $request->name,
            'email' => $request->email,
        ]);

        return new UserResource($user); 
    }

    public function destroy(User $user)
    {
        $product = Product::find($id);

        if(!$user){
            return response()->json([
                'Success'=>false,
                'Message'=>'User with id'.$id.'not found'
            ],404);
        } if($product->delete()){
            return response()->json([
                'Success'=>true,
                'Message'=>'User deleted successfully'
            ]);
        } else {
            return response()->json([
                'Success'=>false,
                'Message'=>'User could not be deleted'
            ],401);
        }
    }

}
