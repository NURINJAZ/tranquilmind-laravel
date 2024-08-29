<?php

namespace App\Http\Controllers;
use App\Models\Dass;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DassController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
        // Validate incoming data
        $validatedData = $request->validate([
            'depression_score' => 'required|integer',
            'anxiety_score' => 'required|integer',
            'stress_score' => 'required|integer',
            'category' => 'required|integer', // Assuming 'category' is an integer in your database
        ]);

        // Create a new Dass instance
        $dasses = new Dass();

        // Assign validated data to the Dass instance
        $dasses->user_id = Auth::user()->id;
        $dasses->depression_score = $validatedData['depression_score'];
        $dasses->anxiety_score = $validatedData['anxiety_score'];
        $dasses->stress_score = $validatedData['stress_score'];
        $dasses->category = $validatedData['category']; // Assign validated category

        // Save the instance to the database
        $dasses->save();

        // Return a JSON response indicating success
        return response()->json([
            'success' => 'The DASS results have been stored successfully!',
        ], 200);
    }

    public function getUserDassResults()
    {
        $userId = Auth::id();
        $dassResults = Dass::where('user_id', $userId)->get();

        return response()->json($dassResults);
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
