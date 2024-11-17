<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Models\Member;
use Illuminate\Support\Facades\DB;

class MemberController extends Controller
{
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:100',
            'address' => 'required|string|max:255',
            'contact_number' => 'required|string|max:15',
            'password' => 'required|string|min:8',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $member = new Member();
        $member->name = $request->input('name');
        $member->address = $request->input('address');
        $member->contact_number = $request->input('contact_number');
        $member->password = Hash::make($request->input('password'));
        $member->save();

        return redirect()->back()->with('success', 'Member added successfully!');
    }

    public function index(Request $request)
    {
        $search = $request->input('search');
        $sortColumn = $request->input('sort_column', 'name');
        $sortDirection = $request->input('sort_direction', 'asc');

        $query = Member::query();

        if ($search) {
            $query->where('name', 'LIKE', "%{$search}%")
                ->orWhere('address', 'LIKE', "%{$search}%")
                ->orWhere('contact_number', 'LIKE', "%{$search}%");
        }

        $query->orderBy($sortColumn, $sortDirection);

        $members = $query->paginate(10);

        return view('admin.members', compact('members', 'sortColumn', 'sortDirection', 'search'));
    }


    public function edit($id)
    {
        $member = Member::findOrFail($id);

        return view('admin.members-edit', compact('member'));
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:100',
            'address' => 'required|string|max:255',
            'contact_number' => 'required|string|max:15',
            'password' => 'nullable|string|min:8',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $member = Member::findOrFail($id);
        $member->name = $request->input('name');
        $member->address = $request->input('address');
        $member->contact_number = $request->input('contact_number');

        if ($request->input('password')) {
            $member->password = Hash::make($request->input('password'));
        }

        $member->save();

        return redirect()->route('admin.members')->with('success', 'Member updated successfully!');
    }

    public function destroy($id)
    {
        $member = Member::findOrFail($id);
        $member->delete();

        return redirect()->route('admin.members')->with('success', 'Member deleted successfully!');
    }

    public function search(Request $request)
    {
        $query = $request->input('q');

        $members = Member::where('name', 'LIKE', "%$query%")
            ->orWhere('address', 'LIKE', "%$query%")
            ->orWhere('contact_number', 'LIKE', "%$query%")
            ->get();

        return response()->json($members);
    }

    public function login(Request $request)
    {
        $request->validate([
            'contact_number' => 'required|string',
            'password' => 'required|string',
        ]);

        $member = Member::where('contact_number', $request->contact_number)->first();

        if ($member && Hash::check($request->password, $member->password)) {
            session(['member_id' => $member->id]);

            return redirect()->route('member.homepage');
        } else {
            return redirect()->back()->withErrors(['loginError' => 'Invalid credentials.']);
        }
    }

    public function changePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required|string',
            'new_password' => [
                'required',
                'string',
                'min:8',
                'regex:/[a-z]/',
                'regex:/[A-Z]/',
                'regex:/[0-9]/',
                'regex:/[@$!%*?&#]/',
                'different:current_password'
            ],
            'confirm_password' => 'required|same:new_password',
        ]);

        $member = Member::find(session('member_id'));

        if (!Hash::check($request->current_password, $member->password)) {
            return redirect()->back()->withErrors(['current_password' => 'Current password is incorrect.']);
        }

        $member->password = Hash::make($request->new_password);
        $member->save();

        return redirect()->back()->with('success', 'Password changed successfully!');
    }

    public function borrowHistory()
    {
        $memberId = session('member_id');

        $borrowHistory = DB::table('borrow_history')
            ->join('books', 'borrow_history.book_id', '=', 'books.id')
            ->where('borrow_history.member_id', $memberId)
            ->select('borrow_history.*', 'books.title as book_title', 'books.author as book_author')
            ->orderBy('borrow_history.borrow_date', 'desc')
            ->get();

        return view('member.borrow-history', ['borrowHistory' => $borrowHistory]);
    }

}
