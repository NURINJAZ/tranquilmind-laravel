@extends('layouts.admin.app')

@section('content')
    <x-header>
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('List of Upcoming Appointment') }}
        </h2>
    </x-header>

    <div class="my-6"></div> 

    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto|Varela+Round">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="{{ asset('css/custom.css') }}">

    <style>
        th {
            color: #780E8E;
        }

        thead {
            background-color: #F1CAF9;
        }
    </style>

    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>
    <script>
        $(document).ready(function(){
            $('[data-toggle="tooltip"]').tooltip();
        });
    </script>

    <div class="container-xl">
        <div class="table-responsive">
            <div class="table-wrapper">
                <table class="table table-striped table-hover">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>User</th>
                            <th>Doctor</th>
                            <th>Date</th>
                            <th>Time</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($appointments as $appointment)
                            <tr>
                                <td>{{ $appointment->id }}</td>
                                <td>{{ $appointment->user->name }}</td>
                                <td>{{ $appointment->doc_id }}</td>
                                <td>{{ $appointment->date }}</td>
                                <td>{{ $appointment->time }}</td>
                                <td>
                                    <form action="{{ route('admin.appointments.updateStatus', $appointment->id) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('PATCH')
                                        <select name="status" onchange="this.form.submit()" class="form-control">
                                            <option value="upcoming" {{ $appointment->status == 'upcoming' ? 'selected' : '' }}>Upcoming</option>
                                            <option value="complete" {{ $appointment->status == 'complete' ? 'selected' : '' }}>Complete</option>
                                            <option value="cancel" {{ $appointment->status == 'cancel' ? 'selected' : '' }}>Cancel</option>
                                        </select>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
