<div class='book cf'>
    <a href='/students/{{ $student->id }}'><h3>{{ $student->last_name }}, {{ $student->first_name }} </h3></a>
    <ul>
        <li>Grade: {{ $student->grade }}</li>
        <li>Added {{ $student->created_at->format('m/d/y g:ia') }}</li>
    </ul>
</div>