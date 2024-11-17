@extends('layout.memberLayout')

@section('title', 'Change Password')

@section('content')
<div class="container mt-5">
    <div class="mx-auto bg-light border rounded p-4" style="max-width: 400px;">
        <form method="POST" action="{{ route('member.changePassword') }}">
            @csrf
            <div class="form-group mb-3">
                <label for="current_password">Current Password</label>
                <input type="password" name="current_password" id="current_password" class="form-control" placeholder="Enter current password" required />
                @error('current_password')
                    <div class="text-danger mt-1">{{ $message }}</div>
                @enderror
            </div>
            <div class="form-group mb-3">
                <label for="new_password">New Password</label>
                <input type="password" name="new_password" id="new_password" class="form-control" placeholder="Enter new password" required />
                @error('new_password')
                    <div class="text-danger mt-1">{{ $message }}</div>
                @enderror
            </div>
            <div class="form-group mb-3">
                <label for="confirm_password">Confirm New Password</label>
                <input type="password" name="confirm_password" id="confirm_password" class="form-control" placeholder="Confirm new password" required />
                @error('confirm_password')
                    <div class="text-danger mt-1">{{ $message }}</div>
                @enderror
            </div>
            <button type="submit" class="btn btn-primary w-100">Submit</button>
            @if(session('success'))
                <div class="alert alert-success mt-3">{{ session('success') }}</div>
            @endif
        </form>
    </div>
</div>
@endsection
