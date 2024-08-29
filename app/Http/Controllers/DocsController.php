<?php

namespace App\Http\Controllers;

use App\Models\Appointments;
use App\Models\Reviews;
use App\Models\Doctor; // Adjusted import statement
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DocsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //get doctor's appointment, patients and display on dashboard
        $doctor = Auth::user();
        $appointments = Appointments::where('doc_id', $doctor->id)->where('status', 'upcoming')->get();
        $reviews = Reviews::where('doc_id', $doctor->id)->where('status', 'active')->get();

        // Count distinct patients for the doctor
            $patientsCount = Appointments::where('doc_id', $doctor->id)
            ->distinct('user_id')
            ->count('user_id');

        // Update the patients column in the doctors table
        $doctorRecord = Doctor::where('doc_id', $doctor->id)->first();
        if ($doctorRecord) {
        $doctorRecord->patients = $patientsCount;
        $doctorRecord->save();
        }

        // Retrieve the distinct patients for the doctor
        $patients = Appointments::where('doc_id', $doctor->id)
        ->distinct('user_id')
        ->get();

        //return all data to dashboard
        return view('dashboard')->with(['doctor'=>$doctor, 'appointments'=>$appointments, 'reviews'=>$reviews, 'patients'=>$patients]);
    }

    public function index123()
    {
        //get doctor's appointment, patients and display on dashboard
        $doctor = Auth::user();
        $appointments = Appointments::where('doc_id', $doctor->id)->where('status', 'upcoming')->get();
        $reviews = Reviews::where('doc_id', $doctor->id)->where('status', 'active')->get();

        //return all data to dashboard
        return view('admin/appointments/index')->with(['doctor'=>$doctor, 'appointments'=>$appointments, 'reviews'=>$reviews]);
    }

    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:upcoming,complete,cancel',
        ]);

        $appointment = Appointments::findOrFail($id);
        $appointment->status = $request->status;
        $appointment->save();

        return redirect()->route('admin.appointments.index')->with('success', 'Appointment status updated successfully.');
    }

    public function updateStatusPatient(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:upcoming,complete,cancel',
        ]);

        $appointment = Appointments::findOrFail($id);
        $appointment->status = $request->status;
        $appointment->save();

        return redirect()->route('admin.patients.index')->with('success', 'Appointment status updated successfully.');
    }

    public function getDoctorRating($docId)
    {
        $reviews = Reviews::where('doc_id', $docId)->get();
        $totalRatings = $reviews->sum('ratings');
        $totalReviews = $reviews->count();
        $averageRating = $totalReviews > 0 ? $totalRatings / $totalReviews : 0;

        return response()->json([
            'average_rating' => $averageRating,
            'total_reviews' => $totalReviews,
        ]);
    }



    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //this controller is to store booking details post from mobile app
        $reviews = new Reviews();
        //this is to update the appointment status from "upcoming" to "complete"
        $appointment = Appointments::where('id', $request->get('appointment_id'))->first();

        //save the ratings and reviews from user
        $reviews->user_id = Auth::user()->id;
        $reviews->doc_id = $request->get('doctor_id');
        $reviews->ratings = $request->get('ratings');
        $reviews->reviews = $request->get('reviews');
        $reviews->reviewed_by = Auth::user()->name;
        $reviews->status = 'active';
        $reviews->save();

        //change appointment status
        $appointment->status = 'complete';
        $appointment->save();

        return response()->json([
            'success'=>'The appointment has been completed and reviewed successfully!',
        ], 200);
    }

    public function getAdminLocation(Request $request, $docId)
{
    $doctor = Doctor::where('doc_id', $docId)->first();

    if (!$doctor) {
        return response()->json([
            'error' => 'Doctor not found',
        ], 404);
    }

    $location = [
        'coordinate' => $doctor->coordinate,
        'latitude' => explode(',', $doctor->coordinate)[0],
        'longitude' => explode(',', $doctor->coordinate)[1],
    ];

    return response()->json($location, 200);
}


    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
