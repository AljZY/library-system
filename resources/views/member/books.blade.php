@extends('layout.memberLayout')

@section('title', 'Books')

@section('content')
<div class="container mt-5">
    <div class="table-responsive">
        <table class="table table-bordered table-hover">
            <thead class="thead-dark">
                <tr>
                    <th>ISBN</th>
                    <th>Title</th>
                    <th>Author</th>
                    <th>Category</th>
                    <th>Image</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                @foreach($books as $book)
                <tr>
                    <td>{{ $book->isbn }}</td>
                    <td>{{ $book->title }}</td>
                    <td>{{ $book->author }}</td>
                    <td>{{ $book->category }}</td>
                    <td>
                        @if($book->file_path)
                            <img src="{{ asset('storage/' . $book->file_path) }}" alt="{{ $book->title }}" width="50">
                        @else
                            <span>No Image</span>
                        @endif
                    </td>
                    <td style="background-color: {{ $book->is_borrowed ? '#f8d7da' : '#d4edda' }};">
                        {{ $book->is_borrowed ? 'Borrowed' : 'Available' }}
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="d-flex justify-content-center">
        {{ $books->links('pagination::bootstrap-4') }}
    </div>
</div>
@endsection
