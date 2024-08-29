@extends('layouts.admin.app')

@section('content')
    <h1>Create New Appointment</h1>

    <form action="{{ route('admin.patients.store') }}" method="POST">
        @csrf

        <div class="form-group">
            <label for="patient_name">Patient Name:</label>
            <input type="text" name="patient_name" id="patient_name" class="form-control" required>
        </div>

        <div class="form-group">
            <label for="date">Date:</label>
            <input type="date" name="date" id="date" class="form-control">
        </div>

        <div class="form-group">
            <label for="time">Time:</label>
            <input type="time" name="time" id="time" class="form-control">
        </div>

        <div class="form-group">
            <label for="status">Status:</label>
            <input type="text" name="status" id="status" class="form-control">
        </div>

        <button type="submit" class="btn btn-primary">Submit</button>
    </form>
@endsection
