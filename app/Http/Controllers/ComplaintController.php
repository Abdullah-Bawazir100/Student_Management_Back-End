<?php

namespace App\Http\Controllers;

use App\Http\Requests\store_complaint_request;
use App\Models\Complaints;
use App\Models\Students;
use Illuminate\Http\Request;

class ComplaintController extends Controller
{
    // Show all Complaints
    public function index()
    {
        $complaint = Complaints::with(relations: 'student:id,student_name')->get(); // جلب اسم الطالب فقط

        if($complaint->isEmpty()){
            return response()->json('No Complaints Exists .' , 200);
        }
        else{
        return response()->json($complaint , 200);
        }
    }

    // Create a new Complaint
   public function store(store_complaint_request $request)
    {
        $validated = $request->validated();

        // تحقق من أن الطالب موجود
        $student = Students::where('id', $validated['student_id'])
            ->where('student_name', $validated['student_name'])
            ->first();

        if (!$student) {
            return response()->json([
                'success' => false,
                'message' => 'Student id [' . $validated['student_id'] . '], and student name : [' . $validated['student_name'] . '] do not match.'
            ], 404);
        }

        // إنشاء الشكوى
        $complaint = Complaints::create([
            'student_id' => $student->id,
            'student_name' => $student->student_name, // إذا أضفت هذا العمود
            'description' => $validated['description'],
        ]);

        return response()->json([
            'success' => true,
            'data' => $complaint,
            'message' => 'Complaint stored successfully for student ['. $student->student_name . ']'
        ], 201);
    }


    // Show specific Complaint
    public function show($id)
    {
        $complaintData = Complaints::with('student:id,student_name')->find($id);    
        
        if(!$complaintData) {
            return response()->json([
                'success' => false,
                'message' => 'No Complaint With id [' . $id . ']'
            ], 404);
        }
        
        return response()->json([
            'success' => true,
            'message' => 'Complaint retrieved successfully.',
            'data' => $complaintData,
        ], 200);
    }

    // Delete a Complaint
    public function destroy($id)
    {
        $complaintData = Complaints::find($id);
    
        if(!$complaintData) {
            return response()->json([
                'success' => false,
                'message' => 'No Complaint With id [' . $id . ']'
            ], 404);
        }
        
        $complaintData->delete();
        
        return response()->json([
            'data' => $complaintData,
            'success' => true,
            'message' => 'Complaint deleted successfully.'
        ], 200);
    }
}
