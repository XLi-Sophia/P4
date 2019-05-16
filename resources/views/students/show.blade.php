@extends('layouts.master')

@section('title')
    {{ $student->title }}
@endsection

@section('head')
    {{-- Page specific CSS includes should be defined here; this .css file does not exist yet, but we can create it --}}
    <link href='/css/students/show.css' rel='stylesheet'>
@endsection

@section('content')
    <h1>{{ $student->last_name }}, {{ $student->first_name }}</h1>

    <div class='book cf'>
        <p><b>Student Name:</b> {{ $student->last_name }}, {{ $student->first_name }}</p>
        <p><b>Grade:</b> {{ $student->grade }}, <b>Team:</b> {{ $student->team }}, <b>Category:</b> {{ $student->category }}</p>
        <p><b>Fluency Level:</b> {{ $student->fluency_level }}, <b>Reading Level:</b> {{ $student->reading_level }}</p>
        <p><b>Added on:</b> {{ $student->updated_at->format('m/d/y') }}</p>
        <p><b>Last Updated on:</b> {{ $student->updated_at->format('m/d/y') }}</p>

        <ul class='bookActions'>
            <li><a href='/students/{{ $student->id }}/edit'><i class="fas fa-edit"></i> Edit</a>
            <li><a href='/students/{{ $student->id }}/delete'><i class="fas fa-trash"></i> Delete</a>
        </ul>
    </div>
@endsection