<?php

namespace App\Http\Controllers;

use App\Models\Appointments;
use App\Models\User;
use App\Models\Doctor;
use App\Models\UserDetails;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class UsersController extends Controller
{
    /**
     * Display a listing of the resource.
     * 
     * @return\Illuminate\Http\Response
     */
    public function index()
    {
        $user = array(); //this will return a set of user and doctor data
        $user = Auth::user();
        $doctor = User::where('type', 'doctor')->get();
        $details = $user->user_details;
        $doctorData = Doctor::all();
        //this is the date format without leading
        $date = now()->format('n/j/Y'); //change date format to suit the format in database

        //make this appointment filter only status is "upcoming"
        $appointment = Appointments::where('status', 'upcoming')->where('date', $date)->first();

        //collect user data and all doctor details
        foreach($doctorData as $data){
            //sorting doctor name and doctor details
            foreach($doctor as $info){
                if($data['doc_id'] == $info['id']){
                    $data['doctor_name'] = $info['name'];
                    $data['doctor_profile'] = $info['profile_photo_url'];
                    if(isset($appointment) && $appointment['doc_id'] == $info['id']){
                        $data['appointments'] = $appointment;
                    }
                }
            }
        }

        // Adding user age and gender to the response
    $userData = [
        'name' => $user->name,
        'age' => $user->age, // Access age directly from the users table
        'gender' => $user->gender, // Access gender directly from the users table
        'profile_photo_url' => $user->profile_photo_path, // Access profile photo URL directly
    ];

    $user['doctor'] = $doctorData;
    $user['details'] = $details; // return user details here together with doctor list
    $user['user_data'] = $userData; // Add user data to response

    return $user; // return all data
    }

    /**
     * login.
     *
     * @return \Illuminate\Http\Response
     */
    public function login(Request $request)
    {
        //validate incoming inputs
        $request->validate([
            'email'=>'required|email',
            'password'=>'required',
        ]);

        //check matching user
        $user = User::where('email', $request->email)->first();

        //check password
        if(!$user || ! Hash::check($request->password, $user->password)){
            throw ValidationException::withMessages([
                'email'=>['The provided credentials are incorrect'],
            ]);
        }

        //then return generated token
        return $user->createToken($request->email)->plainTextToken;
    }

    /**
     * register.
     *
     * @return \Illuminate\Http\Response
     */
    public function register(Request $request)
    {
        //validate incoming inputs
        $request->validate([
            'name'=>'required|string',
            'email'=>'required|email',
            'password'=>'required',
        ]);

        $user = User::create([
            'name'=>$request->name,
            'email'=>$request->email,
            'type'=>'user',
            'password'=>Hash::make($request->password),
        ]);

        $userInfo = UserDetails::create([
            'user_id'=>$user->id,
            'status'=>'active',
        ]);

        return $user;


    }

    public function updateProfile(Request $request)
    {
        $user = auth()->user(); // Assuming user is authenticated
        
        // Validate incoming data
        $request->validate([
            'name' => 'required|string|max:255',
            'age' => 'nullable|integer',
            'gender' => 'nullable|string|max:10',
            'photo' => ['nullable', 'mimes:jpg,jpeg,png', 'max:1024'],
        ]);

        // Update user's profile fields
        $user->name = $request->name;
        $user->age = $request->age;
        $user->gender = $request->gender;

        // Handle profile photo update if included in request
        if ($request->hasFile('profile_photo')) {
            // Store the uploaded photo and update the profile_photo_path in user table
            $path = $request->file('profile_photo')->store('profile-photos', 'public');
            $user->profile_photo_path = $path;
        }

        /*if (isset($input['photo'])) {
            $user->updateProfilePhoto($input['photo']);
        }*/

        $user->save();

        return response()->json(['message' => 'Profile updated successfully', 'user' => $user]);
    }

    /**
     * update favorite doctor list
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function storeFavDoc(Request $request)
    {

        $saveFav = UserDetails::where('user_id',Auth::user()->id)->first();

        $docList = json_encode($request->get('favList'));

        //update fav list into database
        $saveFav->fav = $docList;  //and remember update this as well
        $saveFav->save();

        return response()->json([
            'success'=>'The Favorite List is updated',
        ], 200);
    }

    /**
     * logout.
     *
     * @return \Illuminate\Http\Response
     */
    public function logout(){
        $user = Auth::user();
        $user->currentAccessToken()->delete();

        return response()->json([
            'success'=>'Logout successfully!',
        ], 200);
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
        //
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