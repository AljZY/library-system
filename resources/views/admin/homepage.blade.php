@extends('layout.adminLayout')

@section('title', 'Admin Homepage')

@section('content')
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-4 mb-4">
            <div class="card text-white bg-primary">
                <div class="card-body text-center">
                    <div class="d-flex align-items-center justify-content-center mb-3">
                        <i class="bi bi-book-fill display-4"></i>
                    </div>
                    <h5 class="card-title">Total Books</h5>
                    <p class="card-text display-4">{{ $bookCount }}</p>
                </div>
            </div>
        </div>

        <div class="col-md-4 mb-4">
            <div class="card text-white bg-success">
                <div class="card-body text-center">
                    <div class="d-flex align-items-center justify-content-center mb-3">
                        <i class="bi bi-people-fill display-4"></i>
                    </div>
                    <h5 class="card-title">Total Members</h5>
                    <p class="card-text display-4">{{ $memberCount }}</p>
                </div>
            </div>
        </div>

        <div class="col-md-4 mb-4">
            <div class="card text-white bg-warning">
                <div class="card-body text-center">
                    <div class="d-flex align-items-center justify-content-center mb-3">
                        <i class="bi bi-journal-bookmark-fill display-4"></i>
                    </div>
                    <h5 class="card-title">Borrow History Records</h5>
                    <p class="card-text display-4">{{ $borrowHistoryCount }}</p>
                </div>
            </div>
        </div>

        <div class="col-md-4 mb-4">
            <div class="card text-white bg-danger">
                <div class="card-body text-center">
                    <div class="d-flex align-items-center justify-content-center mb-3">
                        <i class="bi bi-exclamation-circle-fill display-4"></i>
                    </div>
                    <h5 class="card-title">Books Not Returned</h5>
                    <p class="card-text display-4">{{ $unreturnedBooksCount }}</p>
                </div>
            </div>
        </div>

        <div class="col-md-4 mb-4">
            <div class="card text-white bg-info">
                <div class="card-body text-center">
                    <div class="d-flex align-items-center justify-content-center mb-3">
                        <i class="bi bi-check-circle-fill display-4"></i>
                    </div>
                    <h5 class="card-title">Books Returned</h5>
                    <p class="card-text display-4">{{ $returnedBooksCount }}</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
