<?php

use App\Http\Controllers\AppUserController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ComplaintController;
use App\Http\Controllers\NewsController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\ResponsibiltyController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\ViolationsController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');


Route::post('/signup', [AuthController::class, 'signup']); // للجميع
Route::post('/login', [AuthController::class, 'login']);   // للجميع

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']); // أي مستخدم مسجّل

    Route::middleware('AdminOnly')->group(function () {
        Route::post('/admin/add', [AuthController::class, 'addAdmin']);
        Route::delete('/admin/delete/{id}', [AuthController::class, 'deleteAdmin']);
    });
});

Route::post('register/' , [AuthController::class , 'registerStudentData']);

Route::apiResource('app_users' , AppUserController::class);

Route::get('/responsibilities', [ResponsibiltyController::class, 'index']);
// عمليات المشرف فقط
Route::middleware(['auth:sanctum', 'AdminOnly'])->group(function () {
    Route::post('/responsibilities', [ResponsibiltyController::class, 'store']);
    Route::put('/responsibilities/{id}', [ResponsibiltyController::class, 'update']);
    Route::delete('/responsibilities/{id}', [ResponsibiltyController::class, 'destroy']);
});

Route::get('/news', [NewsController::class, 'index']);
Route::middleware(['auth:sanctum', 'AdminOnly'])->group(function () {
    Route::post('/news', [NewsController::class, 'store']);
    Route::delete('/news/{id}', [NewsController::class, 'destroy']);
});


Route::get('/students' , [StudentController::class , 'index']);
Route::get('/students/{id}' , [StudentController::class , 'index']);
Route::middleware(['auth:sanctum' , 'AdminOnly'])->group(function() {
    Route::get('/students/{id}' , [StudentController::class , 'show']);
    Route::delete('/students/{id}' , [StudentController::class , 'destroy']);
    Route::put('/students/{id}' , [StudentController::class , 'update']);
});

Route::get('violations' , [ViolationsController::class , 'index']);
Route::get('/violations/{id}' , [ViolationsController::class , 'show']);
Route::middleware(['auth:sanctum' , 'AdminOnly'])->group(function() {
    Route::post('/violations' , [ViolationsController::class , 'store']);
    Route::delete('/violations/{id}' , [ViolationsController::class , 'destroy']);
    Route::put('/violations/{id}' , [ViolationsController::class , 'update']);
});

Route::get('payments' , [PaymentController::class , 'index']);
Route::get('payments/{id}' , [PaymentController::class , 'show']);
Route::middleware(['auth:sanctum' , 'AdminOnly'])->group(function() {
    Route::post('payments/' , [PaymentController::class , 'store']);
    Route::delete('/payments/{id}' , [PaymentController::class , 'destroy']);
    Route::put('/payments/{id}' , [PaymentController::class , 'update']);
});

Route::get('complaints', [ComplaintController::class , 'index']);
Route::get('/complaints/{id}', [ComplaintController::class, 'show']);
Route::delete('/complaints/{id}', [ComplaintController::class, 'destroy']);
Route::middleware(['auth:sanctum', 'StudentOnly'])->group(function () {
    Route::post('/complaints', [ComplaintController::class, 'store']);
});
