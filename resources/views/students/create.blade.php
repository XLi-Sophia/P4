@extends('layouts.master')

@section('title')
    Add New Student
@endsection

@section('head')
    <link href='/css/students/create.css' rel='stylesheet'>
@endsection

@section('content')

    <h1>Add New Student</h1>

    <form method='POST' action='/students'>
        <div class='details'>* Required fields</div>
        {{ csrf_field() }}
        <div>
            <label for='first_name'>* First Name</label>
            <input type='text' name='first_name' id='first_name' value='{{ old('first_name') }}'>
            @include('includes.error-field', ['fieldName' => 'first_name'])

            <label for='last_name'>* Last Name</label>
            <input type='text' name='last_name' size='20' id='last_name' value='{{ old('last_name') }}'>
            @include('includes.error-field', ['fieldName' => 'last_name'])

            <label for='grade'>* Grade</label>
            <input type='number' min='1' max='8' step='1' name='grade' id='grade' size='20' value='{{ old('grade') }}'>
            @include('includes.error-field', ['fieldName' => 'grade'])

            <label for='category'>* Category</label>
            <input type='text' name='category' id='category' size='3' value='{{ old('category') }}'>
            @include('includes.error-field', ['fieldName' => 'category'])

            <label for='team'>* Team</label>
            <input type='text' name='team' id='team' size='20' value='{{ old('team') }}'>
            @include('includes.error-field', ['fieldName' => 'team'])

            <label for='fluency_level'>* Fluency Level</label>
            <input type='number' min='0' max='399' step='1' name='fluency_level' id='fluency_level' value='{{ old('fluency_level') }}'>
            @include('includes.error-field', ['fieldName' => 'fluency_level'])

            <label for='reading_level'>* Reading Level</label>
            <input type='number' min='0' max='2.5' step='0.1' name='reading_level' id='reading_level' value='{{ old('reading_level') }}'>
            @include('includes.error-field', ['fieldName' => 'reading_level'])
        </div>

        <div>
            <input type='submit' class='btn btn-primary' value='Add student'>
        </div>
    </form>

    @if(count($errors) > 0)
        <div class='error globalFormError'>Please fix the errors above.</div>
    @endif

@endsection