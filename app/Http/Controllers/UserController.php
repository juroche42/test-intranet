<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    public function index()
    {
        $users = User::with('services:name')
            ->select(['id','prenom', 'nom', 'poste', 'username'])
            ->get();
        return response()->json($users);
    }


    public function update(Request $request, int $userId)
    {
        $validator = Validator::make($request->all(), [
            'prenom' => 'required|string|max:255',
            'nom' => 'required|string|max:255',
            'poste' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . $userId,
            'statut' => 'required|int|in:0,1',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $user = User::find($userId);

        if (!$user) {
            return response()->json(['error' => 'User not found'], 404);
        }

        $user->update($request->all());

        return response()->json($user, 200);
    }

    public function delete(int $userId)
    {
        $user = User::find($userId);

        if (!$user) {
            return response()->json(['error' => 'User not found'], 404);
        }

        $user->delete();

        return response()->json(['message' => 'User deleted'], 200);
    }
}
