<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class UserController extends Controller
{
    // Show all users in admin panel
    public function index()
    {
        $users = User::orderBy('id', 'desc')->paginate(10); // 10 users per page
        return view('admin.users.index', compact('users'));
    }
}