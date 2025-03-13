<?php

use App\Http\Controllers\AuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Laravel\Sanctum\Http\Controllers\CsrfCookieController;

// Add this route to handle CSRF cookie setting
Route::get('/sanctum/csrf-cookie', [CsrfCookieController::class, 'show']);
Route::get('/csrf-token', function () {
    return response()->json(['csrf_token' => csrf_token()]);
});

// 🔹 Authentication Routes
Route::prefix('auth')->group(function () {

    // ✅ Register (Signup)
    Route::post('/register', [AuthController::class, 'register']);

    // ✅ Login (Signin)
    Route::post('/login', [AuthController::class, 'login']);

    // ✅ Logout

    Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth:sanctum');

    // ✅ Get Authenticated User (Profile)
    Route::get('/user', function (Request $request) {
        return response()->json($request->user()->load('roles'));
    })->middleware('auth:sanctum');

    // ✅ Password Reset Routes
    Route::post('/forgot-password', [AuthController::class, 'forgotPassword']);
    Route::post('/reset-password', [AuthController::class, 'resetPassword']);

    // ✅ Email Verification
    Route::post('/email/verify/{id}/{hash}', [AuthController::class, 'verifyEmail'])->middleware(['auth:sanctum', 'signed']);
    Route::post('/email/resend', [AuthController::class, 'resendVerificationEmail'])->middleware('auth:sanctum');
});

Route::middleware(['auth:sanctum'])->group(function () {

    Route::prefix('admin')->middleware(['role:admin'])->group(function () {
        Route::get('/dashboard', [App\Http\Controllers\Admin\DashboardController::class, 'index']);
        // 🔹 Users Management
        Route::get('/users/{id?}', [App\Http\Controllers\Admin\UserController::class, 'index']);  // List users
        Route::post('/users/{id?}', [App\Http\Controllers\Admin\UserController::class, 'store']); // Create user
        Route::delete('/users/{id}', [App\Http\Controllers\Admin\UserController::class, 'destroy']); // Delete user


        // // 🔹 Schools
        // Route::resource('/schools', [App\Http\Controllers\Admin\SchoolController::class, 'index']);

        // // 🔹 Students
        // Route::resource('/students', StudentController::class);

        // // 🔹 Teachers
        // Route::resource('/teachers', TeacherController::class);

        // // 🔹 Staff Members
        // Route::resource('/staff', StaffController::class);

        // // 🔹 Classes
        // Route::resource('/classes', ClassController::class);

        // // 🔹 Subjects
        // Route::resource('/subjects', SubjectController::class);

        // // 🔹 Exams
        // Route::resource('/exams', ExamController::class);

        // // 🔹 Results
        // Route::resource('/results', ResultController::class);

        // // 🔹 Attendance
        // Route::get('/attendance', [AttendanceController::class, 'index']);
        // Route::post('/attendance', [AttendanceController::class, 'store']);
        // Route::put('/attendance/{id}', [AttendanceController::class, 'update']);
        // Route::delete('/attendance/{id}', [AttendanceController::class, 'destroy']);

        // // 🔹 Fees & Payments
        // Route::resource('/fees', FeeController::class);
        // Route::resource('/payments', PaymentController::class);

        // // 🔹 Reports & Analytics
        // Route::get('/reports', [ReportController::class, 'index']);
        // Route::get('/reports/attendance', [ReportController::class, 'attendanceReport']);
        // Route::get('/reports/results', [ReportController::class, 'resultReport']);
        // Route::get('/reports/fees', [ReportController::class, 'feesReport']);
    });
});

// Public Routes (accessible by all users)
Route::group(['middleware' => 'auth:sanctum'], function () {
    // Public routes
    // Route::get('/schools', [SchoolController::class, 'index']);
    // Route::get('/classes', [ClassController::class, 'index']);
    // Route::get('/subjects', [SubjectController::class, 'index']);
    // Route::get('/exams', [ExamController::class, 'index']);
});

// Admin Routes (accessible only by admins)
Route::group(['middleware' => ['auth:sanctum', 'role:admin']], function () {
    // Admin routes
    // Route::get('/admin/dashboard', [AdminController::class, 'dashboard']);
    // Route::get('/admin/users', [AdminController::class, 'users']);
    // Route::get('/admin/students', [AdminController::class, 'students']);
    // Route::get('/admin/teachers', [AdminController::class, 'teachers']);
    // Route::get('/admin/staff', [AdminController::class, 'staff']);
});

// Student Routes (accessible only by students)
Route::group(['middleware' => ['auth:sanctum', 'role:student']], function () {
    // Student routes
    // Route::get('/student/dashboard', [StudentController::class, 'dashboard']);
    // Route::get('/student/classes', [StudentController::class, 'classes']);
    // Route::get('/student/exams', [StudentController::class, 'exams']);
    // Route::get('/student/results', [StudentController::class, 'results']);
});

// Teacher Routes (accessible only by teachers)
Route::group(['middleware' => ['auth:sanctum', 'role:teacher']], function () {
    // Teacher routes
    // Route::get('/teacher/dashboard', [TeacherController::class, 'dashboard']);
    // Route::get('/teacher/classes', [TeacherController::class, 'classes']);
    // Route::get('/teacher/students', [TeacherController::class, 'students']);
});

// Staff Routes (accessible only by staff)
Route::group(['middleware' => ['auth:sanctum', 'role:staff']], function () {
    // Staff routes
    // Route::get('/staff/dashboard', [StaffController::class, 'dashboard']);
    // Route::get('/staff/students', [StaffController::class, 'students']);
});

// Guardian Routes (accessible only by guardians)
Route::group(['middleware' => ['auth:sanctum', 'role:guardian']], function () {
    // Guardian routes
    // Route::get('/guardian/dashboard', [GuardianController::class, 'dashboard']);
    // Route::get('/guardian/students', [GuardianController::class, 'students']);
});

// Public User Routes (accessible only by public users)
Route::group(['middleware' => ['auth:sanctum', 'role:public']], function () {
    // Public user routes
    // Route::get('/public/dashboard', [PublicUserController::class, 'dashboard']);
});
