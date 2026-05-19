{{-- resources/views/backend/messages/index.blade.php --}}
@extends('backend.layouts.app')

@section('title', 'Messages')

@section('content')

<h4 class="fw-bold py-3 mb-4">
    <span class="text-muted fw-light">Admin /</span> Customer Messages
</h4>

<div class="card">
    <div class="card-header d-flex align-items-center justify-content-between py-3">
        <h5 class="mb-0">
            <i class="bx bx-envelope me-2 text-primary"></i>
            All Messages
            @php $unread = \App\Models\ContactMessage::where('is_read', false)->count(); @endphp
            @if($unread > 0)
                <span class="badge bg-danger ms-2">{{ $unread }} unread</span>
            @endif
        </h5>
    </div>

    <div class="table-responsive">
        <table class="table table-hover align-middle">
            <thead class="table-light">
                <tr>
                    <th>#</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Subject</th>
                    <th>Date</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @forelse($messages as $msg)
                <tr class="{{ !$msg->is_read ? 'table-warning fw-semibold' : '' }}">
                    <td>{{ $loop->iteration }}</td>
                    <td>
                        <div class="d-flex align-items-center gap-2">
                            <div class="avatar avatar-sm">
                                <span class="avatar-initial rounded-circle bg-label-primary">
                                    {{ strtoupper(substr($msg->name, 0, 1)) }}
                                </span>
                            </div>
                            {{ $msg->name }}
                        </div>
                    </td>
                    <td><a href="mailto:{{ $msg->email }}">{{ $msg->email }}</a></td>
                    <td>{{ Str::limit($msg->subject, 40) }}</td>
                    <td>{{ $msg->created_at->format('d M, Y') }}</td>
                    <td>
                        @if(!$msg->is_read)
                            <span class="badge bg-warning text-dark">
                                <i class="bx bx-envelope me-1"></i> Unread
                            </span>
                        @else
                            <span class="badge bg-success">
                                <i class="bx bx-envelope-open me-1"></i> Read
                            </span>
                        @endif
                    </td>
                    <td>
                        <div class="d-flex gap-1">
                            <a href="{{ route('backend.messages.show', $msg) }}"
                               class="btn btn-sm btn-primary">
                                <i class="bx bx-show"></i>
                            </a>
                            <form action="{{ route('backend.messages.destroy', $msg) }}"
                                  method="POST"
                                  onsubmit="return confirm('এই বার্তাটি মুছে ফেলবেন?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger">
                                    <i class="bx bx-trash"></i>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="text-center py-5 text-muted">
                        <i class="bx bx-envelope-open fs-1 d-block mb-2"></i>
                        কোনো বার্তা নেই।
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- Pagination --}}
    @if($messages->hasPages())
    <div class="card-footer d-flex justify-content-center">
        {{ $messages->links() }}
    </div>
    @endif
</div>

@endsection