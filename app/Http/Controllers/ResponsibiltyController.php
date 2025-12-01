<?php

namespace App\Http\Controllers;

use App\Http\Requests\store_responsibilty_request;
use App\Http\Requests\update_responsibilty_request;
use App\Models\Responsibilities;
use Illuminate\Http\Request;

class ResponsibiltyController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $responsibilities = Responsibilities::all(); 

        if($responsibilities->isEmpty()){
            return response()->json('No Responsibilities Exists .' , 200);
        }
        else{
        return response()->json($responsibilities , 200);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(store_responsibilty_request $request)
    {
        $validated = $request->validated();

        $responsibilityData = Responsibilities::create(attributes:$validated);
        return response()->json([
            'success' => true,
            'data' => $responsibilityData,
            'message' => 'The Responsibility stored successfully'
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $responsibilityData = Responsibilities::find($id);

        if($responsibilityData->isEmpty())
        {
            return response()->json([
                'success' => false,
                'message' => 'No Responsibility With id [' . $id . ']'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'message' => 'Responsibility retrieved successfully.',
            'data' => $responsibilityData
        ], 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(update_responsibilty_request $request, $id)
    {
        $validated = $request->validated();
        $responsibilityData = Responsibilities::find($id);
    
        if(!$responsibilityData) {
            return response()->json([
                'success' => false,
                'message' => 'No Responsibility With id [' . $id  . ']'
            ], 404);
        }

        // تحديث التاريخ بتاريخ اليوم عند كل تعديل يقوم به المشرف
        $validated['date'] = now()->toDateString();

        $responsibilityData->update($validated);

        return response()->json([
            'success' => true,
            'data' => $responsibilityData,
            'message' => 'Responsibility updated successfully.'
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $responsibilityData = Responsibilities::find($id);
    
        if(!$responsibilityData) {
            return response()->json([
                'success' => false,
                'message' => 'No responsibility With id [' . $id . ']'
            ], 404);
        }
        
        $responsibilityData->delete();
        
        return response()->json([
            'data' => $responsibilityData,
            'success' => true,
            'message' => 'Responsibility deleted successfully.'
        ], 200);
    }
}
