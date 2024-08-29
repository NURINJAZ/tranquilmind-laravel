<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Appointments;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class AppointmentController extends Controller
{
    public function index()
    {
        $appointments = Appointments::where('doc_id', Auth::user()->id)->get();
        $doctor = User::where('type', 'doctor')->get();
        
        return view('admin.appointments.index', compact('appointments'));
    }

}
