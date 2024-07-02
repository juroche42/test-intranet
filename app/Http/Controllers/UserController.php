<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class UserController extends Controller
{
    public function index()
    {
        $users = User::with('services:name')
            ->select(['id','prenom', 'nom', 'poste'])
            ->get();
        return response()->json($users);
    }
}
