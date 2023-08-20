<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class LogsController extends Controller
{
    public function index()
    {
        $user = User::all();
        return view('/admin/logs/logs', compact('user'));
    }
}
