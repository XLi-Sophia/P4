{{-- /resources/views/books/search.blade.php --}}
@extends('layouts.master')

@section('title')
    Search
@endsection

@section('head')
    <link href='/css/students/search.css' rel='stylesheet'>
@endsection

@section('content')
    <h1>Search</h1>

    <form method='GET' action='/students/search-process'>

        <fieldset>
            <label for='searchTerm'>Search by title:</label>
            <input type='text' name='searchTerm' id='searchTerm' value='{{ $searchTerm }}'>
            @include('includes.error-field', ['fieldName' => 'searchTerm'])

            <input type='checkbox' name='caseSensitive' {{ (old('caseSensitive') or $caseSensitive) ? 'checked' : '' }}>
            <label>case sensitive</label>
        </fieldset>

        <input type='submit' value='Search' class='btn btn-primary'>
    </form>

    @if($searchTerm)
        <div id='results'>
            <h2>
                {{ count($searchResults) }} {{ str_plural('Result', count($searchResults)) }} for
                <em>“{{ $searchTerm }}”</em>
            </h2>

            @if(count($searchResults) == 0)
                No matches found.
            @else
                <ul>
                    @foreach($searchResults as $book)
                        <li><a href='/students/{{$book->id}}'>{{ $book->title }} by {{ $book->author->getFullname() }}</a>
                        </li>
                    @endforeach
                </ul>
            @endif
        </div>
    @endif

@endsection