<?php

namespace App\Http\Controllers\api;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;

class loginController extends Controller
{
public function login(Request $request)
{
    // البحث عن المستخدم بواسطة البريد الإلكتروني
    $user = User::where('email', $request->email)->first();

    // التحقق من وجود المستخدم ومطابقة كلمة المرور
    if (!$user || !Hash::check($request->password, $user->password)) {
        return response()->json([
            'message' => 'Invalid credentials'
        ], 401); // 401 Unauthorized
    }

    // إذا كانت البيانات صحيحة، قم بإنشاء توكن للمستخدم
    $token = $user->createToken('api-token')->plainTextToken;

    // إرجاع التوكن وبيانات المستخدم كرد ناجح
    return response()->json([
        'token' => $token,
        'user' => $user
    ]);
}
}
