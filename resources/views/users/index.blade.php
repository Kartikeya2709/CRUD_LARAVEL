@extends('layouts.app')

@section('content')
    <div class="row mb-4">
        <div class="col-md-12 d-flex justify-content-between align-items-center">
            <h2>User Comments</h2>
            <div>
                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addUserModal">
                    Add New User
                </button>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Username</th>
                            <th>Email</th>
                            <th>Details</th>
                            <th>Comment</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($users as $user)
                            <tr>
                                <td>{{ $user->name }}</td>
                                <td>{{ $user->username }}</td>
                                <td>{{ $user->email }}</td>
                                <td>
                                    <button type="button" class="btn btn-sm btn-info" data-bs-toggle="modal" data-bs-target="#userDetailsModal{{ $user->email }}">
                                        View Details
                                    </button>
                                </td>
                                <td>
                                    <form action="{{ route('users.update', $user->email) }}" method="POST" class="comment-form">
                                        @csrf
                                        @method('PUT')
                                        <div class="input-group">
                                            <input type="text" name="comment" class="form-control" value="{{ $user->comment->comment ?? '' }}" required>
                                            <button type="submit" class="btn btn-outline-primary">Update</button>
                                        </div>
                                    </form>
                                </td>

                                <td>
                                    <form action="{{ route('users.destroy', $user->email) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure?')">
                                            Delete
                                        </button>
                                    </form>
                                </td>

                                <!-- User Details Modal -->
                                <div class="modal fade" id="userDetailsModal{{ $user->email }}" tabindex="-1" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title">User Details</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <p><strong>Date of Birth:</strong> {{ $user->date_of_birth->format('Y-m-d') }}</p>
                                                <p><strong>Gender:</strong> {{ ucfirst($user->gender) }}</p>
                                                <p><strong>Phone:</strong> {{ $user->phone }}</p>
                                                <p><strong>Address:</strong> {{ $user->address }}</p>
                                                <p><strong>City:</strong> {{ $user->city }}</p>
                                                <p><strong>State:</strong> {{ $user->state }}</p>
                                                <p><strong>Country:</strong> {{ $user->country }}</p>
                                                <p><strong>ZIP:</strong> {{ $user->zip }}</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            
            {{ $users->links() }}
        </div>
    </div>

    <!-- Add User Modal -->
    <div class="modal fade" id="addUserModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Add New User</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('users.store') }}" method="POST">
                        @csrf
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="name" class="form-label">Name</label>
                                <input type="text" class="form-control" id="name" name="name" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="username" class="form-label">Username</label>
                                <input type="text" class="form-control" id="username" name="username" required>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="email" class="form-label">Email</label>
                                <input type="email" class="form-control" id="email" name="email" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="date_of_birth" class="form-label">Date of Birth</label>
                                <input type="date" class="form-control" id="date_of_birth" name="date_of_birth" required>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="gender" class="form-label">Gender</label>
                                <select class="form-select" id="gender" name="gender" required>
                                    <option value="">Select Gender</option>
                                    <option value="male">Male</option>
                                    <option value="female">Female</option>
                                    <option value="other">Other</option>
                                </select>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="phone" class="form-label">Phone</label>
                                <input type="text" class="form-control" id="phone" name="phone" required>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="address" class="form-label">Address</label>
                            <textarea class="form-control" id="address" name="address" required></textarea>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="city" class="form-label">City</label>
                                <input type="text" class="form-control" id="city" name="city" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="state" class="form-label">State</label>
                                <input type="text" class="form-control" id="state" name="state" required>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="country" class="form-label">Country</label>
                                <input type="text" class="form-control" id="country" name="country" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="zip" class="form-label">ZIP</label>
                                <input type="text" class="form-control" id="zip" name="zip" required>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="comment" class="form-label">Comment</label>
                            <textarea class="form-control" id="comment" name="comment" required></textarea>
                        </div>
                        <button type="submit" class="btn btn-primary">Add User</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
