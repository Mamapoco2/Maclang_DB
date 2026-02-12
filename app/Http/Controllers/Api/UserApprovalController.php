<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class UserApprovalController extends Controller
{
    // 🔹 List Pending Users
    public function pending()
    {
        $users = User::where('status', 'pending')
            ->with('employee')
            ->get();

        return response()->json($users);
    }

    // 🔹 Approve User
    public function approve($id)
    {
        $user = User::findOrFail($id);

        if ($user->status !== 'pending') {
            return response()->json([
                'message' => 'User is not pending.'
            ], 400);
        }

        $user->update([
            'status' => 'active'
        ]);

        return response()->json([
            'message' => 'User approved successfully.'
        ]);
    }

    // 🔹 Reject User
    public function reject($id)
    {
        $user = User::findOrFail($id);

        if ($user->status !== 'pending') {
            return response()->json([
                'message' => 'User is not pending.'
            ], 400);
        }

        $user->update([
            'status' => 'rejected'
        ]);

        return response()->json([
            'message' => 'User rejected.'
        ]);
    }
}
