@extends('layouts.master')

@section('head')
    <link href='/css/students/delete.css' rel='stylesheet'>
@endsection

@section('title')
    Confirm deletion: {{ $student->last_name }}, {{ $student->first_name }}
@endsection

@section('content')
    <h1>Confirm deletion</h1>

    <p>Are you sure you want to delete <strong>{{ $student->last_name }}, {{ $student->first_name }}</strong>?</p>

    <form method='POST' action='/students/{{ $student->id }}'>
        {{ method_field('delete') }}
        {{ csrf_field() }}
        <input type='submit' value='Yes, delete it!' class='btn btn-danger btn-small'>
    </form>

    <p class='cancel'>
        <a href='/students/search'>No, I changed my mind. GO back to Search page.</a>
    </p>

@endsection
