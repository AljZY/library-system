@extends('layout.memberLayout')

@section('title', 'Borrow History')

@section('content')
<div class="container mt-5">

    @if($borrowHistory->isEmpty())
        <p>You have no borrow history.</p>
    @else

        <div class="table-responsive">
            <table class="table table-bordered table-hover">
                <thead class="thead-dark">
                    <tr>
                        <th>Title</th>
                        <th>Author</th>
                        <th>Borrow Date</th>
                        <th>Due Date</th>
                        <th>Return Date</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($borrowHistory as $record)
                        <tr>
                            <td>{{ $record->book_title }}</td>
                            <td>{{ $record->book_author }}</td>
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
    @endif
</div>
@endsection
