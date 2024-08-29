@extends('layouts.admin.app')

@section('content')
    <h1>Appointment Details</h1>

    <div>
        <p><strong>ID:</strong> {{ $appointment->id }}</p>
        <p><strong>User:</strong> {{ $appointment->user->name }}</p>
        <p><strong>Doctor:</strong> {{ $appointment->doctor->name }}</p>
        <p><strong>Date:</strong> {{ $appointment->date }}</p>
        <p><strong>Time:</strong> {{ $appointment->time }}</p>
        <p><strong>Status:</strong> {{ $appointment->status }}</p>
    </div>

    <a href="{{ route('admin.appointments.index') }}" class="btn btn-secondary">Back to Appointments</a>
@endsection
