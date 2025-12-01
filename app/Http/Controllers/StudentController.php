<?php

namespace App\Http\Controllers;

use App\Http\Requests\store_student_request;
use App\Http\Requests\update_student_request;
use App\Models\Students;
use Illuminate\Http\Request;

class StudentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $studentData = Students::all();

        if($studentData->isEmpty()){
            return response()->json('No Students Exists .' , 200);
        }
        else{
        return response()->json($studentData , 200);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(store_student_request $request)
    {
        $studentData = Students::create(attributes: $request->validated());

        return response()->json([
        'data' => $studentData,
        'success' => true,
        'message' => 'Student Stored successfully.'
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $studentData = Students::find($id);    

        if(!$studentData) {
            return response()->json([
                'success' => false,
                'message' => 'No Student With id [' . $id . ']'
            ], 404);
        }
        
        return response()->json([
            'success' => true,
            'message' => 'Student retrieved successfully.',
            'data' => $studentData
        ], 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(update_student_request $request, $id)
    {
        $studentData = students::find($id);
    
        if(!$studentData) {
        return response()->json([
            'success' => false,
            'message' => 'No Student With id [' . $id . ']'
        ], 404);
        }
    
        $studentData->update(attributes: $request->validated());
        
        return response()->json([
            'success' => true,
            'message' => 'Student updated successfully.',
            'data' => $studentData
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $studentData = students::find($id);
    
        if(!$studentData) {
            return response()->json([
                'success' => false,
                'message' => 'No Student With id [' . $id . ']'
            ], 404);
        }
        
        $studentData->delete();
        
        return response()->json([
            'data' => $studentData,
            'success' => true,
            'message' => 'Student deleted successfully.'
        ], 200);
    }
}
