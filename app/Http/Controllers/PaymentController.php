<?php

namespace App\Http\Controllers;

use App\Http\Requests\store_payment_request;
use App\Http\Requests\update_payment_request;
use App\Models\Payments;
use App\Models\Students;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    // Show all Payments
    public function index()
    {
        $paymentData = Payments::with(relations: 'student:id,student_name')->get(); // جلب اسم الطالب فقط

        if($paymentData->isEmpty()){
            return response()->json('No Payment Exists .' , 200);
        }
        else{
        return response()->json($paymentData , 200);
        }
    }

    // Create new payment for student
    public function store(store_payment_request $request)
    {
        $validated = $request->validated();
        
        // تأكيد تطابق الاسم والـ id
        $studentData = Students::where('id', $validated['student_id'])
        ->where('student_name', $validated['student_name'])->first();
        
        if (!$studentData) {
            return response()->json([
                'success' => false,
                'message' => 'Student id [' . $validated['student_id'] . '], and student name : [' . $validated['student_name'] . '] not match.'
            ], 404);
        }

        $validated['totle_payment'] = $validated['food_payment'] + $validated['housing_payment'];

        $paymentData = Payments::create($validated);

        return response()->json([
            'success' => true,
            'message' => 'Payment stored successfully for student: [' . $studentData->student_name . ']',
            'data' => $paymentData
        ], 201);
    }

   // Show a payment for student
    public function show($id)
    {
        $paymentData = Payments::with('student:id,student_name')->find($id);

        if(!$paymentData) {
            return response()->json([
                'success' => false,
                'message' => 'No Payment With id [' . $id . ']'
            ], 404);
        }
        
        return response()->json([
            'success' => true,
            'message' => 'Payment retrieved successfully.',
            'data' => $paymentData
        ], 200);
    }

    // Update payment for student
    public function update(update_payment_request $request, $id)
    {

        $validated = $request->validated();
        $paymentData = Payments::find($id);
    
        if(!$paymentData) {
            return response()->json([
                'success' => false,
                'message' => 'No Payment With id [' . $id  . ']'
            ], 404);
        }


        if ($paymentData->student_id != $validated['student_id']) {
            return response()->json([
                'success' => false,
                'message' => "This payment does not belong to student [{$validated['student_name']}]."
            ], 403);
        }


        // تأكيد تطابق الاسم مع الـ id
        $studentData = Students::where('id', $validated['student_id'])
        ->where('student_name', $validated['student_name'])->first();

        if (!$studentData) {
            return response()->json([
                'success' => false,
                'message' => 'Student id [' . $validated['student_id'] . '], and student name : [' . $validated['student_name'] . '] not match.'
            ], 404);
        }


        $paymentData->update($validated);

        $paymentData->totle_payment = $paymentData->food_payment + $paymentData->housing_payment;
        $paymentData->save();
    
        return response()->json([
            'data' => $paymentData,
            'success' => true,
            'message' => 'Payment updated successfully for student [' . $validated['student_name'] . ']'
        ], 200);
    }

    // Delete payment for student
    public function destroy($id)
    {
        $paymentData = Payments::find($id);
    
        if(!$paymentData) {
            return response()->json([
                'success' => false,
                'message' => 'No Payment With id [' . $id . ']'
            ], 404);
        }
        
        $paymentData->delete();
        
        return response()->json([
            'data' => $paymentData,
            'success' => true,
            'message' => 'Payment deleted successfully.'
        ], 200);
    }
}
