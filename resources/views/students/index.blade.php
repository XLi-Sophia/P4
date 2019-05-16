@extends('layouts.master')

@section('title')
    Your Books
@endsection

@section('head')
    <link href='/css/students/index.css' rel='stylesheet'>
    <link href='/css/students/_book.css' rel='stylesheet'>
@endsection

@section('content')

    <section id='newBooks'>
        <h2>Recently Added Students</h2>
        @foreach($students as $student)
            @include('students._book')
        @endforeach
    </section>

    <section id='allBooks'>
        <h2>All Students</h2>
        @foreach($students as $student)
            @include('students._book')
        @endforeach
    </section>
@endsection