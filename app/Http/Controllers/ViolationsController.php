<?php

namespace App\Http\Controllers;

use App\Http\Requests\store_violation_request;
use App\Http\Requests\update_violation_request;
use App\Models\Students;
use App\Models\Violations;
use Illuminate\Http\Request;

class ViolationsController extends Controller
{
    // Show all violations 
    public function index()
    {
        $violationData = Violations::with('student:id,student_name')->get();

        if($violationData->isEmpty()){
            return response()->json('No Violations Exists .' , 200);
        }
        else {
        return response()->json($violationData , 200);
        }
    }

    // Create a new violation for student
    public function store(store_violation_request $request)
    {
        $validated = $request->validated();
        $studentData = Students::where('id', $validated['student_id'])
        ->where('student_name', $validated['student_name'])->first();


        if (!$studentData) {
            return response()->json([
                'success' => false,
                'message' => 'Student id [' . $validated['student_id'] . '], and student name : [' . $validated['student_name'] . '] not match.'
            ], 404);
        }

        $validated['student_id'] = $studentData->id; 

        $violationData = Violations::create(attributes:$validated);
        return response()->json([
            'success' => true,
            'data' => $violationData,
            'message' => 'Violation stored successfully for student ['. $studentData->student_name . ']'
        ], 201);
    }

    // Show Violation for student
    public function show($id)
    {
        $violationData = Violations::with('student:id,student_name')->find($id);    
        
        if(!$violationData) {
            return response()->json([
                'success' => false,
                'message' => 'No Violation With id [' . $id . ']'
            ], 404);
        }
        
        return response()->json([
            'success' => true,
            'message' => 'Violation retrieved successfully.',
            'data' => $violationData
        ], 200);
    }

    // Update violation for student
    public function update(update_violation_request $request, $id)
    {
        $validated = $request->validated();

        $violationData = Violations::find($id);

        if (!$violationData) {
            return response()->json([
                'success' => false,
                'message' => 'No Violation With id [' . $id . ']'
            ], 404);
        }

        if ($violationData->student_id != $validated['student_id']) {
            return response()->json([
                'success' => false,
                'message' => "This violation does not belong to student [{$validated['student_name']}]."
            ], 403);
        }

        $violationData->update($validated);

        return response()->json([
            'success' => true,
            'data' => $violationData,
            'message' => 'Violation updated successfully for student [' . $validated['student_name'] . ']'
        ], 200);
    }

    // Delete Violation for a student
    public function destroy($id)
    {
        $violationData = Violations::find($id);
    
        if(!$violationData) {
            return response()->json([
                'success' => false,
                'message' => 'No Violation With id [' . $id . ']'
            ], 404);
        }
        
        $violationData->delete();
        
        return response()->json([
            'data' => $violationData,
            'success' => true,
            'message' => 'Violation deleted successfully.'
        ], 200);
    }
}
