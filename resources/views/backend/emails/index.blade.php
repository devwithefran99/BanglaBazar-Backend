@extends('backend.layouts.app')

@section('title', 'Email Center')

@section('content')

<h4 class="fw-bold py-3 mb-4">
    <span class="text-muted fw-light">Admin /</span> 📧 Email Center
</h4>

<div class="row g-4">

    {{-- LEFT: COMPOSE --}}
    <div class="col-12 col-lg-5">

        <div class="card mb-4">
            <div class="card-header d-flex align-items-center gap-2">
                <i class="bx bx-send text-primary fs-5"></i>
                <h5 class="mb-0">Compose Email</h5>
            </div>
            <div class="card-body">

                @if(session('success'))
                <div class="alert alert-success alert-dismissible mb-3">
                    <i class="bx bx-check-circle me-2"></i>{{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
                @endif
                @if(session('error'))
                <div class="alert alert-danger alert-dismissible mb-3">
                    <i class="bx bx-error-circle me-2"></i>{{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
                @endif

                <form action="{{ route('backend.emails.send') }}" method="POST">
                    @csrf

                    <div class="mb-3">
                        <label class="form-label fw-semibold small">Quick Select Customer</label>
                        <select class="form-select form-select-sm" onchange="fillCustomer(this)">
                            <option value="">— Select a customer —</option>
                            @foreach($customers as $c)
                            <option value="{{ $c->email }}" data-name="{{ $c->name }}">
                                {{ $c->name }} ({{ $c->email }})
                            </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="row g-2 mb-3">
                        <div class="col-7">
                            <label class="form-label small">To Email <span class="text-danger">*</span></label>
                            <input type="email" name="to" id="toEmail" class="form-control"
              placeholder="customer@email.com" 
             value="{{ request('prefill_to', request('to')) }}"
              required>
                        </div>
                        <div class="col-5">
                            <label class="form-label small">Name</label>
                          <input type="text" name="to_name" id="toName" class="form-control"
       placeholder="Customer Name"
    value="{{ request('prefill_to_name', request('to_name')) }}">
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label small">Subject <span class="text-danger">*</span></label>
                        <input type="text" name="subject" class="form-control"
                               placeholder="Email subject..." value="{{ request('prefill_subject') }}" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label small">Message <span class="text-danger">*</span></label>
                        <textarea name="body" class="form-control" rows="6"
                                  placeholder="Write your message..." required> {{ request('prefill_body') }}</textarea>
                    </div>

                    <button type="submit" class="btn btn-primary w-100">
                        <i class="bx bx-send me-1"></i> Send Email
                    </button>
                </form>
            </div>
        </div>

        {{-- Re-send Order Email --}}
        <div class="card">
            <div class="card-header d-flex align-items-center gap-2">
                <i class="bx bx-refresh text-warning fs-5"></i>
                <h5 class="mb-0">Re-send Order Email</h5>
            </div>
            <div class="card-body">
                <form action="" method="POST" id="resendForm">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label small">Select Order</label>
                        <select class="form-select" onchange="setResendAction(this)">
                            <option value="">— Select order —</option>
                            @foreach($orders as $ord)
                            <option value="{{ $ord->id }}"
                                    data-email="{{ $ord->user->email ?? '' }}"
                                    data-name="{{ $ord->user->name ?? 'N/A' }}">
                                #{{ str_pad($ord->id,4,'0',STR_PAD_LEFT) }} —
                                {{ $ord->user->name ?? 'Unknown' }}
                                ({{ ucfirst($ord->status) }})
                            </option>
                            @endforeach
                        </select>
                    </div>

                    <div id="resendCustomerInfo" style="display:none;" class="mb-3">
                        <div class="alert alert-info py-2 px-3 small mb-0" id="resendInfo"></div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label small">Email Type</label>
                        <select name="mail_type" class="form-select">
                            <option value="placed">✅ Order Placed</option>
                            <option value="confirmed">🎉 Confirmed</option>
                            <option value="shipped">🚚 Shipped</option>
                            <option value="delivered">📦 Delivered</option>
                            <option value="cancelled">❌ Cancelled</option>
                        </select>
                    </div>

                    <button type="submit" class="btn btn-warning w-100">
                        <i class="bx bx-mail-send me-1"></i> Re-send Email
                    </button>
                </form>
            </div>
        </div>

    </div>

    {{-- RIGHT: EMAIL LOGS --}}
    <div class="col-12 col-lg-7">
        <div class="card">
            <div class="card-header d-flex align-items-center justify-content-between">
                <div class="d-flex align-items-center gap-2">
                    <i class="bx bx-list-ul text-primary fs-5"></i>
                    <h5 class="mb-0">Sent Email Log</h5>
                </div>
                <span class="badge bg-label-primary">{{ $logs->total() }} emails</span>
            </div>

            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>To</th>
                            <th>Subject</th>
                            <th>Type</th>
                            <th>Status</th>
                            <th>Date</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($logs as $log)
                        <tr>
                            <td>
                                <div class="fw-semibold small">{{ $log->to_name ?: '—' }}</div>
                                <small class="text-muted">{{ $log->to_email }}</small>
                            </td>
                            <td><span class="small">{{ Str::limit($log->subject, 35) }}</span></td>
                            <td>
                                <span class="badge bg-label-secondary">
                                    {{ ucfirst(str_replace('_', ' ', $log->type)) }}
                                </span>
                            </td>
                            <td>
                                @if($log->status === 'sent')
                                <span class="badge bg-success"><i class="bx bx-check me-1"></i>Sent</span>
                                @else
                                <span class="badge bg-danger"><i class="bx bx-x me-1"></i>Failed</span>
                                @endif
                            </td>
                            <td><small class="text-muted">{{ $log->created_at->format('d M, h:i A') }}</small></td>
                            <td>
                                <form action="{{ route('backend.emails.destroy', $log) }}"
                                      method="POST"
                                      onsubmit="return confirm('Delete this log?')">
                                    @csrf @method('DELETE')
                                    <button class="btn btn-sm btn-outline-danger">
                                        <i class="bx bx-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="text-center py-5 text-muted">
                                <i class="bx bx-envelope-open fs-1 d-block mb-2"></i>
                                No emails sent yet.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if($logs->hasPages())
            <div class="card-footer d-flex justify-content-center">
                {{ $logs->links() }}
            </div>
            @endif
        </div>
    </div>

</div>

@push('scripts')
<script>
function fillCustomer(sel) {
    const opt = sel.options[sel.selectedIndex];
    document.getElementById('toEmail').value = opt.value;
    document.getElementById('toName').value  = opt.dataset.name || '';
}

function setResendAction(sel) {
    const orderId = sel.value;
    const opt     = sel.options[sel.selectedIndex];
    const form    = document.getElementById('resendForm');
    const info    = document.getElementById('resendInfo');
    const infoBox = document.getElementById('resendCustomerInfo');

    if (orderId) {
        form.action = `/orders/${orderId}/resend-mail`;
        info.innerHTML = `📧 Will send to: <strong>${opt.dataset.email}</strong> (${opt.dataset.name})`;
        infoBox.style.display = 'block';
    } else {
        infoBox.style.display = 'none';
    }
}
</script>
@endpush

@endsection