@extends('layout.adminLayout')

@section('title', 'Books')

@section('content')
<div class="container mt-5">
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif

    @if($errors->any())
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <ul>
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif

        <div class="d-flex align-items-center my-3">
            <button class="btn btn-primary mr-3" data-toggle="modal" data-target="#addBookModal">Add Book</button>
            <input type="text" id="searchInput" class="form-control" placeholder="Search by ISBN, Title, Author, or Category">
        </div>

        <!-- Add Book Modal -->
        <div class="modal fade" id="addBookModal" tabindex="-1" aria-labelledby="addBookModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="addBookModalLabel">Add Book</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form id="addBookForm" action="{{ route('books.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="form-group">
                                <label for="isbn">ISBN Number:</label>
                                <input type="text" class="form-control" id="isbn" name="isbn" placeholder="ISBN" required autocomplete="off">
                            </div>

                            <div class="form-group">
                                <label for="category">Category:</label>
                                <select class="form-control" name="category" id="category" required>
                                    <option value="000-099 Generalities">000-099 Generalities</option>
                                    <option value="100-199 Philosophy">100-199 Philosophy</option>
                                    <option value="200-299 Religion">200-299 Religion</option>
                                    <option value="300-399 Social Science">300-399 Social Science</option>
                                    <option value="400-499 Language">400-499 Language</option>
                                    <option value="500-599 Science and Math">500-599 Science and Math</option>
                                    <option value="600-699 Technology">600-699 Technology</option>
                                    <option value="700-799 The Arts">700-799 The Arts</option>
                                    <option value="800-899 Literature">800-899 Literature</option>
                                    <option value="900-999 Geography and History">900-999 Geography and History</option>
                                </select>
                            </div>

                            <div class="form-group">
                                <label for="title">Title:</label>
                                <input type="text" class="form-control" id="title" name="title" placeholder="Title" required autocomplete="off">
                            </div>

                            <div class="form-group">
                                <label for="author">Author:</label>
                                <input type="text" class="form-control" id="author" name="author" placeholder="Author" required autocomplete="off">
                            </div>

                            <div class="form-group">
                                <label class="btn btn-primary btn-block mt-3" id="file-label">
                                    Upload Book File or Image
                                    <input type="file" name="book_file" id="book_file" accept=".pdf,.doc,.docx,.jpg,.jpeg,.png" required style="display: none;">
                                </label>
                                <span id="file-name" class="mt-2 text-muted d-block"></span>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary" form="addBookForm">Add Book</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Borrow Modal -->
        @foreach($books as $book)
            <div class="modal fade" id="borrowModal-{{ $book->id }}" tabindex="-1" aria-labelledby="borrowModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="borrowModalLabel">Borrow Book: {{ $book->title }}</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form action="{{ route('books.borrow', ['id' => $book->id]) }}" method="POST">
                                @csrf
                                <div class="form-group">
                                    <label for="member_id">Select Member:</label>
                                    <select name="member_id" id="member_id" class="form-control" required>
                                        <option value="" disabled selected>Select a member</option>
                                        @foreach($members as $member)
                                            <option value="{{ $member->id }}">{{ $member->name }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label for="borrow_date">Borrow Date:</label>
                                    <input type="date" name="borrow_date" id="borrow_date" class="form-control" value="{{ now()->toDateString() }}" readonly>
                                </div>

                                <div class="form-group">
                                    <label for="due_date">Due Date:</label>
                                    <input type="date" name="due_date" id="due_date" class="form-control" required>
                                </div>

                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                    <button type="submit" class="btn btn-primary">Confirm Borrow</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach

        <!-- Edit Book Modal -->
        @foreach($books as $book)
            <div class="modal fade" id="editBookModal-{{ $book->id }}" tabindex="-1" aria-labelledby="editBookModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="editBookModalLabel">Edit Book: {{ $book->title }}</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form id="editBookForm-{{ $book->id }}" action="{{ route('books.update', $book->id) }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                @method('PUT')
                                <div class="form-group">
                                    <label for="isbn">ISBN Number:</label>
                                    <input type="text" class="form-control" id="isbn" name="isbn" value="{{ $book->isbn }}" required>
                                </div>

                                <div class="form-group">
                                    <label for="category">Category:</label>
                                    <select class="form-control" name="category" id="category" required>
                                        <option value="000-099 Generalities" {{ $book->category == '000-099 Generalities' ? 'selected' : '' }}>000-099 Generalities</option>
                                        <option value="100-199 Philosophy" {{ $book->category == '100-199 Philosophy' ? 'selected' : '' }}>100-199 Philosophy</option>
                                        <option value="200-299 Religion" {{ $book->category == '200-299 Religion' ? 'selected' : '' }}>200-299 Religion</option>
                                        <option value="300-399 Social Science" {{ $book->category == '300-399 Social Science' ? 'selected' : '' }}>300-399 Social Science</option>
                                        <option value="400-499 Language" {{ $book->category == '400-499 Language' ? 'selected' : '' }}>400-499 Language</option>
                                        <option value="500-599 Science and Math" {{ $book->category == '500-599 Science and Math' ? 'selected' : '' }}>500-599 Science and Math</option>
                                        <option value="600-699 Technology" {{ $book->category == '600-699 Technology' ? 'selected' : '' }}>600-699 Technology</option>
                                        <option value="700-799 The Arts" {{ $book->category == '700-799 The Arts' ? 'selected' : '' }}>700-799 The Arts</option>
                                        <option value="800-899 Literature" {{ $book->category == '800-899 Literature' ? 'selected' : '' }}>800-899 Literature</option>
                                        <option value="900-999 Geography and History" {{ $book->category == '900-999 Geography and History' ? 'selected' : '' }}>900-999 Geography and History</option>
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label for="title">Title:</label>
                                    <input type="text" class="form-control" id="title" name="title" value="{{ $book->title }}" required>
                                </div>

                                <div class="form-group">
                                    <label for="author">Author:</label>
                                    <input type="text" class="form-control" id="author" name="author" value="{{ $book->author }}" required>
                                </div>

                                <div class="form-group">
                                    <label class="btn btn-primary btn-block mt-3" id="file-label">
                                        Upload New File or Image (optional)
                                        <input type="file" name="book_file" id="edit-book-file-{{ $book->id }}" accept=".pdf,.doc,.docx,.jpg,.jpeg,.png" style="display: none;">
                                    </label>
                                    <span id="file-name-{{ $book->id }}" class="mt-2 text-muted d-block">
                                        {{ basename($book->file_path) }}
                                    </span>
                                </div>
                            </form>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary" form="editBookForm-{{ $book->id }}">Save Changes</button>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach

        <!-- Delete Modal -->
        <div class="modal fade" id="deleteBookModal" tabindex="-1" aria-labelledby="deleteBookModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="deleteBookModalLabel">Confirm Delete</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        Are you sure you want to delete this book?
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                        <form id="deleteBookForm" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger">Delete</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- Books Table -->
        <div class="table-responsive">
            <table class="table table-bordered table-hover">
                <thead class="thead-dark">
                    <tr>
                    <th><a href="{{ route('admin.books', ['sort_by' => 'isbn', 'sort_direction' => ($sortColumn == 'isbn' && $sortDirection == 'asc') ? 'desc' : 'asc']) }}">ISBN</a></th>
                    <th><a href="{{ route('admin.books', ['sort_by' => 'title', 'sort_direction' => ($sortColumn == 'title' && $sortDirection == 'asc') ? 'desc' : 'asc']) }}">Title</a></th>
                    <th><a href="{{ route('admin.books', ['sort_by' => 'author', 'sort_direction' => ($sortColumn == 'author' && $sortDirection == 'asc') ? 'desc' : 'asc']) }}">Author</a></th>
                    <th><a href="{{ route('admin.books', ['sort_by' => 'category', 'sort_direction' => ($sortColumn == 'category' && $sortDirection == 'asc') ? 'desc' : 'asc']) }}">Category</a></th>
                        <th>File</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($books as $book)
                        <tr>
                            <td>{{ $book->isbn }}</td>
                            <td>{{ $book->title }}</td>
                            <td>{{ $book->author }}</td>
                            <td>{{ $book->category }}</td>
                            <td class="text-center align-middle" style="width: 150px; height: 150px;">
                                <div class="d-flex justify-content-center align-items-center" style="width: 100%; height: 100%;">
                                    @if(preg_match('/\.(jpg|jpeg|png)$/i', $book->file_path))
                                        <img src="{{ asset('storage/' . $book->file_path) }}" alt="Book Image" style="max-width: 100%; max-height: 100%; object-fit: contain;">
                                    @else
                                        <a href="{{ asset('storage/' . $book->file_path) }}" download class="btn btn-primary">Download File</a>
                                    @endif
                                </div>
                            </td>
                            <td class="text-center">
                                <div class="d-flex justify-content-center align-items-center">
                                    @if($book->is_borrowed)
                                        <form action="{{ route('books.return', ['id' => $book->id]) }}" method="POST" style="display:inline;">
                                            @csrf
                                            <button type="submit" class="btn btn-sm btn-success mx-1">Return</button>
                                        </form>
                                    @else
                                        <button class="btn btn-sm btn-primary mx-1" data-toggle="modal" data-target="#borrowModal-{{ $book->id }}">Borrow</button>
                                    @endif
                                    <button class="btn btn-sm btn-warning mx-1" data-toggle="modal" data-target="#editBookModal-{{ $book->id }}">Edit</button>
                                    <button type="button" class="btn btn-sm btn-danger mx-1" onclick="showDeleteModal({{ $book->id }})">Delete</button>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <div class="d-flex justify-content-center mt-3">
            {{ $books->appends(['sort_by' => $sortColumn, 'sort_direction' => $sortDirection])->links('pagination::bootstrap-4') }}
        </div>
</div>

    <!-- JavaScript -->
    <script>
        document.getElementById('book_file').addEventListener('change', function(event) {
            const fileName = event.target.files[0].name;
            document.getElementById('file-name').textContent = fileName;
        });

        function openBorrowModal(bookId) {
            document.getElementById('book_id').value = bookId;
            const today = new Date().toISOString().split('T')[0];
            document.getElementById('borrow_date').value = today;
            $('#borrowBookModal').modal('show');
        }

        function showBorrowModal(bookId) {
            $('#borrowBookForm').attr('action', '/admin/books/' + bookId + '/borrow');
            $('#borrowBookModal').modal('show');
        }

        document.querySelectorAll('[id^=edit-book-file-]').forEach(input => {
            input.addEventListener('change', function(event) {
                const fileName = event.target.files[0]?.name;
                if (fileName) {
                    const fileNameDisplay = document.getElementById(`file-name-${event.target.id.split('-').pop()}`);
                    fileNameDisplay.textContent = fileName;
                }
            });
        });

        function showDeleteModal(bookId) {
            const form = document.getElementById('deleteBookForm');
            form.action = `/admin/books/${bookId}`;

            $('#deleteBookModal').modal('show');
        }

        document.getElementById('searchInput').addEventListener('keyup', function() {
            const searchTerm = this.value.toLowerCase();
            const tableRows = document.querySelectorAll('tbody tr');

            tableRows.forEach(row => {
                const isbn = row.querySelector('td:nth-child(1)').textContent.toLowerCase();
                const title = row.querySelector('td:nth-child(2)').textContent.toLowerCase();
                const author = row.querySelector('td:nth-child(3)').textContent.toLowerCase();
                const category = row.querySelector('td:nth-child(4)').textContent.toLowerCase();

                if (isbn.includes(searchTerm) || title.includes(searchTerm) || author.includes(searchTerm) || category.includes(searchTerm)) {
                    row.style.display = '';
                } else {
                    row.style.display = 'none';
                }
            });
        });

    </script>
@endsection
