@extends('layouts.app')

@section('content')
    <div class="row mb-4">
        <div class="col-md-12">
            <h2>Comment Change Logs</h2>
            <a href="{{ route('users.index') }}" class="btn btn-primary">Back to Users</a>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>User</th>
                            <th>Email</th>
                            <th>Action</th>
                            <th>Old Comment</th>
                            <th>New Comment</th>
                            <th>Changed At</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($logs as $log)
                            <tr>
                                <td>{{ optional($log->userComment)->userProfile->name ?? 'User Deleted' }}</td>
                                <td>{{ $log->email }}</td>
                                <td><span class="badge bg-{{ $log->action === 'create' ? 'success' : ($log->action === 'update' ? 'warning' : 'danger') }}">{{ ucfirst($log->action) }}</span></td>
                                <td>{{ $log->old_comment ?? 'No previous comment' }}</td>
                                <td>{{ $log->new_comment }}</td>
                                <td>{{ $log->created_at->format('Y-m-d H:i:s') }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            
            {{ $logs->links() }}
        </div>
    </div>
@endsection
