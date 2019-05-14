@extends('layouts.master')

@section('title')
    Your Books
@endsection

@section('head')
    <link href='/css/books/index.css' rel='stylesheet'>
    <link href='/css/books/_book.css' rel='stylesheet'>
@endsection

@section('content')
    <section id='newBooks'>
        <h2>Recently added books</h2>
        @foreach($newBooks as $book)
            @include('books._book')
        @endforeach
    </section>

    <section id='allBooks'>
        <h2>All books</h2>
        @foreach($books as $book)
            @include('books._book')
        @endforeach
    </section>
@endsection


