@extends('layout')

@section('content')

    <div class="page">
        <h1>Licensures</h1>

        <form action="/" method="GET">
            <label for="state">State</label>
            <select name="state" id="state">
                <option value="">All</option>
                @foreach ($states as $state)
                <option value="{{ $state->state_name }}" @selected(request()->input('state') === $state->state_name)>{{ $state->state_name }}</option>
                @endforeach
            </select>
            <button type="submit">Filter</button>
        </form>

        @fragment('licensures')

        <table>
            <thead>
                <tr>
                    <th>State</th>
                    <th>School/College</th>
                    <th>Program Name</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($licensures as $licensure)
                <tr>
                    <td>{{ $licensure->state_name }}</td>
                    <td>{{ $licensure->school_college }}</td>
                    <td>{{ $licensure->program_name }}</td>
                    <td>{{ $licensure->status }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>

        @endfragment
    </div>

@endsection