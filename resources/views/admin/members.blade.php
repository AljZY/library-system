@extends('layout.adminLayout')

@section('title', 'Members')

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

    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#addMemberModal">
        Add Member
    </button>

    <!-- Search Bar -->
    <div class="mt-4 mb-3">
        <input type="text" id="searchInput" class="form-control" placeholder="Search by name, address, or contact number">
    </div>

    <!-- Add Member Modal -->
    <div class="modal fade" id="addMemberModal" tabindex="-1" aria-labelledby="addMemberModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addMemberModalLabel">Add Member</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="addMemberForm" action="{{ route('members.store') }}" method="POST">
                        @csrf
                        <div class="form-group">
                            <label for="memberName">Name</label>
                            <input type="text" class="form-control" id="memberName" name="name" placeholder="Enter name" required>
                        </div>
                        <div class="form-group">
                            <label for="memberAddress">Address</label>
                            <input type="text" class="form-control" id="memberAddress" name="address" placeholder="Enter address" required>
                        </div>
                        <div class="form-group">
                            <label for="memberContact">Contact Number</label>
                            <input type="text" class="form-control" id="memberContact" name="contact_number" placeholder="Enter contact number" required>
                        </div>
                        <div class="form-group">
                            <label for="memberPassword">Password</label>
                            <input type="text" class="form-control" id="memberPassword" name="password" readonly>
                            <button type="button" class="btn btn-secondary mt-2" onclick="generatePassword()">Generate Password</button>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary" form="addMemberForm">Save Member</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Edit Member Modal -->
    <div class="modal fade" id="editMemberModal" tabindex="-1" aria-labelledby="editMemberModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editMemberModalLabel">Edit Member</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="editMemberForm" method="POST">
                        @csrf
                        <div class="form-group">
                            <label for="editMemberName">Name</label>
                            <input type="text" class="form-control" id="editMemberName" name="name" required>
                        </div>
                        <div class="form-group">
                            <label for="editMemberAddress">Address</label>
                            <input type="text" class="form-control" id="editMemberAddress" name="address" required>
                        </div>
                        <div class="form-group">
                            <label for="editMemberContact">Contact Number</label>
                            <input type="text" class="form-control" id="editMemberContact" name="contact_number" required>
                        </div>
                        <div class="form-group">
                            <label for="editMemberPassword">Password (Leave blank to keep current password)</label>
                            <input type="text" class="form-control" id="editMemberPassword" name="password">
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary" form="editMemberForm">Save Changes</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Delete Modal -->
    <div class="modal fade" id="deleteMemberModal" tabindex="-1" aria-labelledby="deleteMemberModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteMemberModalLabel">Delete Member</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p>Are you sure you want to delete this member?</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    <form id="deleteMemberForm" method="POST" style="display:inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">Delete</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Members Table -->
    <div class="table-responsive">
        <table class="table table-bordered table-hover">
        <thead class="thead-dark">
            <tr>
                <th scope="col">
                    <a href="{{ route('admin.members', ['sort_column' => 'name', 'sort_direction' => $sortColumn == 'name' && $sortDirection == 'asc' ? 'desc' : 'asc']) }}">
                        Name
                    </a>
                </th>
                <th scope="col">
                    <a href="{{ route('admin.members', ['sort_column' => 'address', 'sort_direction' => $sortColumn == 'address' && $sortDirection == 'asc' ? 'desc' : 'asc']) }}">
                        Address
                    </a>
                </th>
                <th scope="col">
                    <a href="{{ route('admin.members', ['sort_column' => 'contact_number', 'sort_direction' => $sortColumn == 'contact_number' && $sortDirection == 'asc' ? 'desc' : 'asc']) }}">
                        Contact Number
                    </a>
                </th>
                <th scope="col">Actions</th>
            </tr>
        </thead>

            <tbody id="membersTableBody">
            @foreach($members as $member)
                <tr>
                    <td>{{ $member->name }}</td>
                    <td>{{ $member->address }}</td>
                    <td>{{ $member->contact_number }}</td>
                    <td class="text-center">
                        <button type="button" class="btn btn-sm btn-warning mx-1" style="width: 75px;"
                                onclick="openEditModal({{ json_encode($member) }})">
                            Edit
                        </button>
                        <button type="button" class="btn btn-sm btn-danger mx-1" style="width: 75px;"
                                onclick="openDeleteModal({{ $member->id }})">
                            Delete
                        </button>
                    </td>
                </tr>
            @endforeach

            </tbody>
        </table>
    </div>

    <div class="d-flex justify-content-center mt-3">
        {{ $members->appends(['search' => $search])->links('pagination::bootstrap-4') }}
    </div>
</div>

    <!-- JavaScript -->
    <script>
        function generatePassword() {
            const length = 8;
            const charset = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789!@#$%^&*()";
            let password = "";
            for (let i = 0; i < length; i++) {
                const randomIndex = Math.floor(Math.random() * charset.length);
                password += charset[randomIndex];
            }
            document.getElementById('memberPassword').value = password;
        }

        function openEditModal(member) {
            $('#editMemberForm').attr('action', `/admin/members/${member.id}/update`);
            $('#editMemberName').val(member.name);
            $('#editMemberAddress').val(member.address);
            $('#editMemberContact').val(member.contact_number);
            $('#editMemberPassword').val(''); // Clear password field

            $('#editMemberModal').modal('show');
        }

        function openDeleteModal(memberId) {
            const deleteForm = document.getElementById('deleteMemberForm');
            deleteForm.action = `/admin/members/${memberId}`;

            $('#deleteMemberModal').modal('show');
        }

        document.getElementById('searchInput').addEventListener('input', function() {
            let query = this.value;

            fetch(`/admin/members/search?q=${query}`, {
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                }
            })
            .then(response => response.json())
            .then(data => {
                let tableBody = document.getElementById('membersTableBody');
                tableBody.innerHTML = '';

                data.forEach(member => {
                    tableBody.innerHTML += `
                        <tr>
                            <td>${member.id}</td>
                            <td>${member.name}</td>
                            <td>${member.address}</td>
                            <td>${member.contact_number}</td>
                            <td class="text-center">
                                <button type="button" class="btn btn-sm btn-warning mx-1" style="width: 75px;" onclick="openEditModal(${JSON.stringify(member)})">Edit</button>
                                <button type="button" class="btn btn-sm btn-danger mx-1" style="width: 75px;" onclick="openDeleteModal(${member.id})">Delete</button>
                            </td>
                        </tr>`;
                });
            });
        });
    </script>
@endsection
