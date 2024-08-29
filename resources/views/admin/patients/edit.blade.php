@extends('layouts.admin.app')

@section('content')
    <h1>Edit Appointment</h1>

    <form action="{{ route('admin.appointments.update', $appointment->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="form-group">
            <label for="user_id">User:</label>
            <select name="user_id" id="user_id" class="form-control">
                @foreach ($users as $user)
                    <option value="{{ $user->id }}" {{ $user->id == $appointment->user_id ? 'selected' : '' }}>{{ $user->name }}</option>
                @endforeach
            </select>
        </div>

        <div class="form-group">
            <label for="doc_id">Doctor:</label>
            <select name="doc_id" id="doc_id" class="form-control">
                @foreach ($doctors as $doctor)
                    <option value="{{ $doctor->id }}" {{ $doctor->id == $appointment->doc_id ? 'selected' : '' }}>{{ $doctor->name }}</option>
                @endforeach
            </select>
        </div>

        <div class="form-group">
            <label for="date">Date:</label>
            <input type="date" name="date" id="date" class="form-control" value="{{ $appointment->date }}">
        </div>

        <div class="form-group">
            <label for="time">Time:</label>
            <input type="time" name="time" id="time" class="form-control" value="{{ $appointment->time }}">
        </div>

        <div class="form-group">
            <label for="status">Status:</label>
            <input type="text" name="status" id="status" class="form-control" value="{{ $appointment->status }}">
        </div>

        <button type="submit" class="btn btn-primary">Update</button>
    </form>
@endsection
