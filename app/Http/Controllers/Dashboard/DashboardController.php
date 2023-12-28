<?php

namespace App\Http\Controllers\Dashboard;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;

class DashboardController extends Controller
{
    
    public function index ( ) {

        $user = Auth::user();
        

        return view ('dashboard.index', [
            'name' => 'anas habbal',
        ]);

    }
}
