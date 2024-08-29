<?php

namespace App\Http\Controllers;

use App\Models\Appointments;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;


class AppointmentsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //retrieve all appointments from the user
        $appointment = Appointments::where('user_id', Auth::user()->id)->get();
        $doctor = User::where('type', 'doctor')->get();

        //sorting appointment and doctor details
        //and get all related appointment
        foreach($appointment as $data){
            foreach($doctor as $info){
                $details = $info->doctor;
                if($data['doc_id'] == $info['id']){
                    $data['doctor_name'] = $info['name'];
                    $data['doctor_profile'] = $info['profile_photo_url'];
                    $data['category'] = $details['category'];
                }
            }
        }

        return $appointment;
    }

    public function dashboardC()
    {
        $userId = Auth::user()->id;
        $appointmentsCount = Appointments::where('user_id', $userId)->count();

        // Pass the count to the view
        return view('dashboard', compact('appointmentsCount'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //this controller is to store booking details post from mobile app
        $appointment = new Appointments();
        $appointment->user_id = Auth::user()->id;
        $appointment->doc_id = $request->get('doctor_id');
        $appointment->date = $request->get('date');
        $appointment->day = $request->get('day');
        $appointment->time = $request->get('time');
        $appointment->status = 'upcoming'; //new appointment will be saved as 'upcoming' by default
        $appointment->save();

        //if successfully, return status code 200
        return response()->json([
            'success'=>'New Appointment has been made successfully!',
        ], 200);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }


    /**
     * Update the specified resource in storage.
     */
    /**
 * Update the specified resource in storage.
 */
public function reschedule(Request $request)
{
    // Get the appointment ID from the request
    $appointmentId = $request->input('appointment_id');

    // Find the existing appointment by ID
    $appointment = Appointments::find($appointmentId);

    if (!$appointment) {
        return response()->json(['error' => 'Appointment not found'], 404);
    }

    // Update the appointment details
    $appointment->date = $request->input('new_date');
    $appointment->day = $request->input('new_day');
    $appointment->time = $request->input('new_time');

    // You may also want to update the status to 'escheduled' or something similar
    $appointment->status = 'upcoming';

    // Save the updated appointment
    $appointment->save();

    // Return a success response
    return response()->json([
        'success' => 'Appointment has been rescheduled successfully!',
    ], 200);
}

    public function cancel(Request $request)
    {
        //this controller is to cancel booking details post from mobile app
        //this is to update the appointment status from "upcoming" to "complete"
        $appointment = Appointments::where('id', $request->get('appointment_id'))->first();

        //change appointment status
        $appointment->status = 'cancel';
        $appointment->save();

        return response()->json([
            'success'=>'The appointment has been completed and reviewed successfully!',
        ], 200);
    }



    /**
     * Remove the specified resource from storage.
     */
    // Cancel the specified appointment
    public function destroy(string $id)
    {
        
    }
}
