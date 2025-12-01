<?php

namespace App\Http\Controllers;

use App\Http\Requests\check_login_request;
use App\Http\Requests\signUp_request;
use App\Http\Requests\store_student_request;
use App\Http\Requests\store_users_request;
use App\Models\app_users;
use App\Models\Students;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function signup(signUp_request $request)
    {
        // اجعل الدور الافتراضي طالب
        $userRole = 'guest';
        // تشفير كلمة المرور
        $password = Hash::make($request->user_password);

        // تسجيل المستخدم فقط في جدول app_users
        $userData = app_users::create([
            'user_email'    => $request->user_email,
            'user_password' => $password,
            'user_role'     => $userRole
        ]);

        return response()->json([
            'status' => true,
            'message' => 'Account Created Successfully. Please login to register with us .',
            'user' => $userData
        ]); 
    }



    public function login(check_login_request $request)
    {
        $user = app_users::where('user_email', $request->user_email)->first();
    
        if (!$user || !Hash::check($request->user_password, $user->user_password)) {
            return response()->json([
                'status' => false,
                'message' => 'Invalid credentials.'
            ], 401);
        }

        // إنشاء توكن جديد
        $token = $user->createToken('auth_token')->plainTextToken;

    
         return response()->json([
            'status' => true,
            'user' => $user,
            'access_token' => $token,
            'token_type' => 'Bearer',
            'message' => 'Login successfully.'
        ]);
    }

    public function logout(Request $request)
    {
        // حذف التوكن الحالي
        $request->user()->currentAccessToken()->delete();

        return response()->json([
            'status' => true,
            'message' => 'Logged out successfully.'
        ]);
    }


    public function registerStudentData(store_student_request $request)
    {
        // تحقق من وجود المستخدم باستخدام الإيميل وكلمة المرور
        $user = app_users::where('user_email', $request->user_email)->first();

        if (!$user || !Hash::check($request->user_password, $user->user_password)) {
            return response()->json([
                'status' => false,
                'message' => 'Student Not Found .'
            ], 401);
        }

        $studentCount = Students::count();
        // التحقق من عدد الطلاب
        if ($studentCount >= 10) {
            return response()->json([
                'status' => false,
                'message' => 'Sorry , Department is full. Cannot register more than [' . $studentCount . '] Students' 
            ], 403);
        }

        // التحقق من أن الطالب لم يسجل مسبقاً
        if (Students::where('user_id', $user->id)->exists()) {
            return response()->json([
                'status' => false,
                'message' => 'You are already registered as a student.'
            ], 400);
        }

        $user->update([
            'user_role' => 'student'
        ]);

        // تخزين بيانات الطالب
        $studentData = Students::storeStudentData($request->all(), $user->id);

        return response()->json([
            'status' => true,
            'message' => 'Student data registered successfully.',
            'student' => $studentData
        ]);
    }

    public function addAdmin(store_users_request $request){

        $admin = new app_users();
        $admin->user_name = $request->user_name;
        $admin->user_email = $request->user_email;
        $admin->user_password = bcrypt($request->user_password);
        $admin->user_role = 'admin'; 
        $admin->save();

        return response()->json([
            'Data' => $admin,
            'message' => 'Admin created successfully'
        ]);
    }

    public function deleteAdmin($id)
    {
        $adminData = app_users::where('id', $id)->where('user_role', 'admin')->first();

         if (!$adminData) {
            return response()->json([
                'status' => 'error',
                'message' => 'Admin not found .',
            ], 404);
        }

        $adminData->delete();

        return response()->json([
            'status' => 'success',
            'Data' => $adminData,
            'message' => 'Admin deleted successfully'
        ]);
    }
}
