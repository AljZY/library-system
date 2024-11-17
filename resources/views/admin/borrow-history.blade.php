@extends('layout.adminLayout')

@section('title', 'Borrow History')

@section('content')
<div class="container mt-5">
    <div class="table-responsive">
        <table class="table table-bordered table-hover">
            <thead class="thead-dark">
                <tr>
                    <th>Book</th>
                    <th>Member</th>
                    <th>Borrow Date</th>
                    <th>Due Date</th>
                    <th>Return Date</th>
                </tr>
            </thead>
            <tbody>
                @foreach($history as $record)
                    <tr>
                        <td>{{ $record->book_title }}</td>
                        <td>{{ $record->member_name }}</td>
                        <td>{{ $record->borrow_date }}</td>
                        <td>{{ $record->due_date }}</td>
                        <td style="background-color: {{ $record->return_date ? '#d4edda' : '#f8d7da' }};">
                            {{ $record->return_date ?? 'Not returned' }}
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
