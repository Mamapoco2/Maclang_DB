<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use App\Models\Employee;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\Controller;

class AuthController extends Controller
{
    // 🔹 REGISTER (Employee-based)
    public function register(Request $request)
    {
        $request->validate([
            'employee_no' => 'required|exists:employees,employee_no',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6|confirmed',
        ]);

        $employee = Employee::where('employee_no', $request->employee_no)->first();

        // Prevent double registration
        if (User::where('employee_id', $employee->id)->exists()) {
            return response()->json([
                'message' => 'Employee already registered.'
            ], 400);
        }

        $user = User::create([
            'name' => $employee->first_name . ' ' . $employee->last_name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'employee_id' => $employee->id,
            'department_id' => $employee->department_id,
            'status' => 'pending',
        ]);

        // Assign default role
        $user->assignRole('DEPARTMENT_STAFF');

        return response()->json([
            'message' => 'Registration successful. Await HR approval.'
        ], 201);
    }

    // 🔹 LOGIN
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        if (!Auth::attempt($request->only('email', 'password'))) {
            return response()->json([
                'message' => 'Invalid credentials'
            ], 401);
        }

        $user = Auth::user();

        if ($user->status !== 'active') {
            Auth::logout();
            return response()->json([
                'message' => 'Account not yet approved by HR.'
            ], 403);
        }

        $token = $user->createToken('hris_token')->plainTextToken;

        return response()->json([
            'token' => $token,
            'user' => $this->userResponse($user)
        ]);
    }

    // 🔹 CURRENT USER
    public function me(Request $request)
    {
        return $this->userResponse($request->user());
    }

    // 🔹 LOGOUT
    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();

        return response()->json([
            'message' => 'Logged out successfully'
        ]);
    }

    // 🔹 Helper Response
    private function userResponse($user)
    {
        return [
            'id' => $user->id,
            'name' => $user->name,
            'email' => $user->email,
            'status' => $user->status,
            'roles' => $user->getRoleNames(),
            'permissions' => $user->getAllPermissions()->pluck('name'),
            'employee_id' => $user->employee_id,
            'department_id' => $user->department_id,
        ];
    }
}
