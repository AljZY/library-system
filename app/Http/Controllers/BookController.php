<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Book;
use Illuminate\Support\Facades\Storage;
use App\Models\Member;
use Illuminate\Support\Facades\DB;

class BookController extends Controller
{
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'isbn' => 'required|unique:books',
            'title' => 'required',
            'author' => 'required',
            'category' => 'required',
            'book_file' => 'nullable|file|mimes:pdf,doc,docx,jpg,jpeg,png|max:2048', // Adjust as needed
        ]);

        if ($request->hasFile('book_file')) {
            $path = $request->file('book_file')->store('books', 'public');
            $validatedData['file_path'] = $path;
        }

        Book::create($validatedData);

        return redirect()->back()->with('success', 'Book added successfully!');
    }

    public function index(Request $request)
    {
        $sortColumn = $request->input('sort_by', 'title');
        $sortDirection = $request->input('sort_direction', 'asc');

        if (!in_array($sortColumn, ['isbn', 'title', 'author', 'category'])) {
            $sortColumn = 'title';
        }
        if (!in_array($sortDirection, ['asc', 'desc'])) {
            $sortDirection = 'asc';
        }

        $books = Book::orderBy($sortColumn, $sortDirection)->paginate(10);

        $books->getCollection()->transform(function ($book) {
            $book->is_borrowed = DB::table('borrows')->where('book_id', $book->id)->exists();
            return $book;
        });

        $members = Member::all();
        return view('admin.books', compact('books', 'members', 'sortColumn', 'sortDirection'));
    }

    public function borrow(Request $request, $id)
    {
        $validatedData = $request->validate([
            'member_id' => 'required|exists:members,id',
            'borrow_date' => 'required|date',
            'due_date' => 'required|date|after:borrow_date',
        ]);

        DB::table('borrows')->insert([
            'book_id' => $id,
            'member_id' => $validatedData['member_id'],
            'borrow_date' => $validatedData['borrow_date'],
            'due_date' => $validatedData['due_date'],
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('borrow_history')->insert([
            'book_id' => $id,
            'member_id' => $validatedData['member_id'],
            'borrow_date' => $validatedData['borrow_date'],
            'due_date' => $validatedData['due_date'],
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return redirect()->back()->with('success', 'Book borrowed and history recorded successfully!');
    }

    public function borrowHistory()
    {
        $history = DB::table('borrow_history')
                    ->join('books', 'borrow_history.book_id', '=', 'books.id')
                    ->join('members', 'borrow_history.member_id', '=', 'members.id')
                    ->select('borrow_history.*', 'books.title as book_title', 'members.name as member_name')
                    ->get();

        return view('admin.borrow-history', compact('history'));
    }

    public function returnBook($id)
    {
        $borrow = DB::table('borrows')->where('book_id', $id)->first();

        if ($borrow) {
            DB::table('borrow_history')
                ->where('book_id', $id)
                ->where('member_id', $borrow->member_id)
                ->whereNull('return_date')
                ->update(['return_date' => now()]);

            DB::table('borrows')->where('book_id', $id)->delete();
        }

        return redirect()->back()->with('success', 'Book returned successfully!');
    }

    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'isbn' => 'required|unique:books,isbn,' . $id,
            'title' => 'required',
            'author' => 'required',
            'category' => 'required',
            'book_file' => 'nullable|file|mimes:pdf,doc,docx,jpg,jpeg,png|max:2048',
        ]);

        $book = Book::findOrFail($id);
        $book->isbn = $validatedData['isbn'];
        $book->title = $validatedData['title'];
        $book->author = $validatedData['author'];
        $book->category = $validatedData['category'];

        if ($request->hasFile('book_file')) {
            if ($book->file_path) {
                Storage::disk('public')->delete($book->file_path);
            }
            $path = $request->file('book_file')->store('books', 'public');
            $book->file_path = $path;
        }

        $book->save();

        return redirect()->back()->with('success', 'Book updated successfully!');
    }

    public function destroy($id)
    {
        $book = Book::findOrFail($id);

        if ($book->file_path && Storage::exists('public/' . $book->file_path)) {
            Storage::delete('public/' . $book->file_path);
        }

        $book->delete();

        return redirect()->back()->with('success', 'Book deleted successfully!');
    }

    public function homepage()
    {
        $bookCount = Book::count();
        $memberCount = Member::count();
        $borrowHistoryCount = DB::table('borrow_history')->count();
        $unreturnedBooksCount = DB::table('borrow_history')->whereNull('return_date')->count();
        $returnedBooksCount = DB::table('borrow_history')->whereNotNull('return_date')->count();

        return view('admin.homepage', compact('bookCount', 'memberCount', 'borrowHistoryCount', 'unreturnedBooksCount', 'returnedBooksCount'));
    }

    public function memberBooks()
    {
        $books = Book::paginate(10);

        $books->getCollection()->transform(function ($book) {
            $book->is_borrowed = DB::table('borrows')->where('book_id', $book->id)->exists();
            return $book;
        });

        return view('member.books', compact('books'));
    }

    public function memberNotReturnedBooks()
    {
        $memberId = session('member_id');

        $notReturnedBooks = DB::table('borrow_history')
                            ->join('books', 'borrow_history.book_id', '=', 'books.id')
                            ->where('borrow_history.member_id', $memberId)
                            ->whereNull('borrow_history.return_date')
                            ->select('books.*')
                            ->get();

        return view('member.homepage', compact('notReturnedBooks'));
    }

}
