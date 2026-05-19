{{-- resources/views/backend/messages/show.blade.php --}}
@extends('backend.layouts.app')

@section('title', 'Message Detail')

@section('content')

<h4 class="fw-bold py-3 mb-4">
    <span class="text-muted fw-light">Admin / <a href="{{ route('backend.messages.index') }}">Messages</a> /</span> Detail
</h4>

<div class="row justify-content-center">
    <div class="col-lg-8">
        <div class="card shadow-sm">
            <div class="card-header d-flex align-items-center justify-content-between py-3">
                <h5 class="mb-0">
                    <i class="bx bx-envelope-open me-2 text-primary"></i>
                    Message Detail
                </h5>
                <a href="{{ route('backend.messages.index') }}" class="btn btn-sm btn-outline-secondary">
                    <i class="bx bx-arrow-back me-1"></i> Back
                </a>
            </div>
            <div class="card-body p-4">

                {{-- Sender Info --}}
                <div class="d-flex align-items-center gap-3 mb-4">
                    <div class="avatar avatar-lg">
                        <span class="avatar-initial rounded-circle bg-label-primary fs-4">
                            {{ strtoupper(substr($message->name, 0, 1)) }}
                        </span>
                    </div>
                    <div>
                        <h5 class="mb-0 fw-semibold">{{ $message->name }}</h5>
                        <a href="mailto:{{ $message->email }}" class="text-muted small">
                            <i class="bx bx-envelope me-1"></i>{{ $message->email }}
                        </a>
                    </div>
                    <div class="ms-auto text-end">
                        <small class="text-muted d-block">
                            <i class="bx bx-time me-1"></i>
                            {{ $message->created_at->format('d M Y, h:i A') }}
                        </small>
                        <span class="badge bg-success mt-1">
                            <i class="bx bx-check me-1"></i> Read
                        </span>
                    </div>
                </div>

                <hr>

                {{-- Subject --}}
                <div class="mb-3">
                    <label class="text-muted small fw-semibold text-uppercase">Subject</label>
                    <p class="fw-semibold fs-6 mb-0">{{ $message->subject }}</p>
                </div>

                {{-- Message --}}
                <div class="mb-3">
                    <label class="text-muted small fw-semibold text-uppercase">Message</label>
                    <div class="bg-light rounded p-3 mt-1" style="white-space: pre-wrap; line-height: 1.8;">{{ $message->message }}</div>
                </div>

                <hr>

                {{-- Actions --}}
                <div class="d-flex gap-2 justify-content-end">
                   <a href="{{ route('backend.emails.index', ['to' => $message->email, 'to_name' => $message->name]) }}" 
   class="btn btn-primary">
    <i class="bx bx-reply me-1"></i> Reply via Email
</a>
                    <form action="{{ route('backend.messages.destroy', $message) }}"
                          method="POST"
                          onsubmit="return confirm('এই বার্তাটি মুছে ফেলবেন?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">
                            <i class="bx bx-trash me-1"></i> Delete
                        </button>
                    </form>
                </div>

            </div>
        </div>
    </div>
</div>

@endsection