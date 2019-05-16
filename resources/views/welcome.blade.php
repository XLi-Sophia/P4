@extends('layouts.master')

@section('content')
    <section>
        <table id="keywords" role="grid" cellspacing="0" cellpadding="0">
            <thead>
            <tr role="row">
                <th>
                </th>
                <th>
                    <div><span>Name</span></div>
                </th>
                <th>
                    <div><span>Grade</span></div>
                </th>
                <th>
                    <div><span>Category</span></div>
                </th>
                <th>
                    <div><span>Team</span></div>
                </th>
                <th>
                    <div><span>Fluency</span></div>
                </th>
                <th>
                    <div><span>Reading</span></div>
                </th>
            </tr>
            </thead>

            <tbody>
                @foreach($students as $student)
                    @include('students._student')
                @endforeach
            </tbody>
        </table>
    </section>
@endsection