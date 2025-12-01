<?php

namespace App\Http\Controllers;

use App\Http\Requests\store_users_request;
use App\Http\Requests\update_users_request;
use App\Models\app_users;
use Illuminate\Http\Request;

class AppUserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $userData = app_users::all();
        if($userData->isEmpty()){
            return response()->json('No Users Exists .' , 200);
        }
        else{
        return response()->json($userData , 200);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(store_users_request $request)
    {
        $userDate = app_users::create($request->validated());
        return response()->json([
            'data' => $userDate,
            'success' => true,
            'message' => 'User created successfully.'
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $userData = app_users::find($id);
    
        if(!$userData) {
            return response()->json([
                'success' => false,
                'message' => 'No User With This id .'
            ], 404);
        }
        
        return response()->json([
            'success' => true,
            'message' => 'User retrieved successfully.',
            'data' => $userData
        ], 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(update_users_request $request, $id)
    {
        $userData = app_users::find($id);
    
        if(!$userData) {
        return response()->json([
            'success' => false,
            'message' => 'No User With This id.'
        ], 404);
    }
    
        $userData->update($request->validated());
        
        return response()->json([
            'success' => true,
            'message' => 'User updated successfully.',
            'data' => $userData
        ], 200);
    }
    
    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $userData = app_users::find($id);
    
        if(!$userData) {
            return response()->json([
                'success' => false,
                'message' => 'No User With This id.'
            ], 404);
        }
        
        $userData->delete();
        
        return response()->json([
            'data' => $userData,
            'success' => true,
            'message' => 'User deleted successfully.'
        ], 200);
    }
}
