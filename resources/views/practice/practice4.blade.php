@extends('layouts.master')

@section('content')
    <select name='day' id='day'>
        <option value='choose'>Choose one...</option>
        <option value='mon' {{ (old('day') == 'mon') ? 'selected' : '' }}>Monday</option>
        <option value='mon' {{ (old('day') == 'tue') ? 'selected' : '' }}>Tuesday</option>
        <option value='mon' {{ (old('day') == 'wed') ? 'selected' : '' }}>Wednesday</option>
        <option value='mon' {{ (old('day') == 'thu') ? 'selected' : '' }}>Thursday</option>
        <option value='mon' {{ (old('day') == 'fri') ? 'selected' : '' }}>Friday</option>
    </select>
@endsection

