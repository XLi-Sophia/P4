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
            <label for='searchTerm'>Search by last name:</label>
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
                {{ count($searchResults) }} Result found with last name:
                <em>“{{ $searchTerm }}”</em>
            </h2>

            @if(count($searchResults) == 0)
                No matches found.
            @else
                <ul>
                    @foreach($searchResults as $student)
                        <li>{{ $student->first_name }} {{ $student->last_name }}, grade ({{ $student->grade }}): has reading level of {{ $student->reading_level }}<a href='/students/{{$student->id}}'> Student Info</a>
                        </li>
                    <!--
                        <li><a href='/students/{{$student->id}}/edit'>{{ $student->last_name }} has reading level of {{ $student->reading_level }}</a>
                        </li>
                    -->

                        <!--
                        <ul class='bookActions'>
                            <li><a href='{{ $student->purchase_url }}'><i class="fas fa-shopping-cart"></i> Purchase</a>
                            <li><a href='/books/{{ $student->id }}/edit'><i class="fas fa-edit"></i> Edit</a>
                            <li><a href='/books/{{ $student->id }}/delete'><i class="fas fa-trash"></i> Delete</a>
                        </ul>
                        -->
                    @endforeach
                </ul>
            @endif
        </div>
    @endif

@endsection