@extends('layout.memberLayout')

@section('title', 'Member Homepage')

@section('content')
    @php
        $member = \App\Models\Member::find(session('member_id'));
    @endphp

    <div class="container mt-5">
        @if ($member)
            <div class="card">
                <div class="card-body">
                    <h1 class="card-title">Welcome, {{ $member->name }}!</h1>
                    <p class="card-text"><strong>Address:</strong> {{ $member->address }}</p>
                    <p class="card-text"><strong>Contact Number:</strong> {{ $member->contact_number }}</p>
                </div>
            </div>

            <div class="card mt-4">
                <div class="card-body">
                    <h2 class="card-title">Books Not Yet Returned</h2>
                    @if($notReturnedBooks->isEmpty())
                        <p class="card-text">You have no books that are yet to be returned.</p>
                    @else
                        <div class="table-responsive">
                            <table class="table table-bordered table-hover">
                                <thead class="thead-dark">
                                    <tr>
                                        <th>ISBN</th>
                                        <th>Title</th>
                                        <th>Author</th>
                                        <th>Category</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($notReturnedBooks as $book)
                                        <tr>
                                            <td>{{ $book->isbn }}</td>
                                            <td>{{ $book->title }}</td>
                                            <td>{{ $book->author }}</td>
                                            <td>{{ $book->category }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @endif
                </div>
            </div>
        @else
            <div class="alert alert-warning mt-3" role="alert">
                No member information found.
            </div>
        @endif
    </div>
@endsection
