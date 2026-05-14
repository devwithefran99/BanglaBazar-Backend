@extends('backend.layouts.app')
@section('title', 'All Suppliers')

@section('content')

<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h4 class="fw-bold mb-1">
            <span class="text-muted fw-light">Suppliers /</span> All Suppliers
        </h4>
        <p class="text-muted mb-0 small">সকল supplier এর তালিকা ও payment status</p>
    </div>
    <a href="{{ route('backend.suppliers.create') }}" class="btn btn-success">
        <i class="bx bx-plus me-1"></i> Add Supplier
    </a>
</div>

{{-- Stats Cards --}}
<div class="row mb-4">
    <div class="col-lg-3 col-sm-6 mb-4">
        <div class="card h-100">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-start">
                    <div>
                        <p class="text-muted fw-semibold mb-1 small">Total Suppliers</p>
                        <h3 class="fw-bold mb-0">{{ $stats['total'] }}</h3>
                    </div>
                    <div class="avatar flex-shrink-0">
                        <span class="avatar-initial rounded bg-label-success">
                            <i class="bx bx-buildings fs-4"></i>
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-3 col-sm-6 mb-4">
        <div class="card h-100">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-start">
                    <div>
                        <p class="text-muted fw-semibold mb-1 small">Active</p>
                        <h3 class="fw-bold mb-0 text-success">{{ $stats['active'] }}</h3>
                    </div>
                    <div class="avatar flex-shrink-0">
                        <span class="avatar-initial rounded bg-label-success">
                            <i class="bx bx-check-circle fs-4"></i>
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-3 col-sm-6 mb-4">
        <div class="card h-100">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-start">
                    <div>
                        <p class="text-muted fw-semibold mb-1 small">Total Purchase</p>
                        <h3 class="fw-bold mb-0">৳{{ number_format($stats['total_purchase'], 0) }}</h3>
                    </div>
                    <div class="avatar flex-shrink-0">
                        <span class="avatar-initial rounded bg-label-info">
                            <i class="bx bx-cart fs-4"></i>
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-3 col-sm-6 mb-4">
        <div class="card h-100">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-start">
                    <div>
                        <p class="text-muted fw-semibold mb-1 small">Total Due</p>
                        <h3 class="fw-bold mb-0 text-danger">৳{{ number_format($stats['total_due'], 0) }}</h3>
                    </div>
                    <div class="avatar flex-shrink-0">
                        <span class="avatar-initial rounded bg-label-danger">
                            <i class="bx bx-wallet fs-4"></i>
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- Search --}}
<div class="card mb-4">
    <div class="card-body py-3">
        <form method="GET" action="{{ route('backend.suppliers.index') }}">
            <div class="row g-2 align-items-center">
                <div class="col-md-8">
                    <div class="input-group">
                        <span class="input-group-text bg-white border-end-0">
                            <i class="bx bx-search text-muted"></i>
                        </span>
                        <input type="text" name="search"
                               class="form-control border-start-0 ps-0"
                               placeholder="Name, phone বা address দিয়ে খুঁজুন..."
                               value="{{ request('search') }}">
                    </div>
                </div>
                <div class="col-md-4 d-flex gap-2">
                    <button type="submit" class="btn btn-success flex-grow-1">
                        <i class="bx bx-search me-1"></i> Search
                    </button>
                    @if(request('search'))
                        <a href="{{ route('backend.suppliers.index') }}" class="btn btn-outline-secondary">
                            <i class="bx bx-x"></i>
                        </a>
                    @endif
                </div>
            </div>
        </form>
    </div>
</div>

{{-- Table --}}
<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center py-3">
        <h5 class="mb-0 fw-semibold">
            Supplier List
            <span class="badge bg-label-success ms-2">{{ $suppliers->total() }}</span>
        </h5>
        <a href="{{ route('backend.purchases.create') }}" class="btn btn-sm btn-outline-success">
            <i class="bx bx-plus me-1"></i> New Purchase
        </a>
    </div>

    <div class="table-responsive">
        <table class="table table-hover align-middle mb-0">
            <thead class="table-light">
                <tr>
                    <th class="ps-4">#</th>
                    <th>Supplier Name</th>
                    <th>Phone</th>
                    <th>Address</th>
                    <th>Total Purchase</th>
                    <th>Due Amount</th>
                    <th class="text-center">Status</th>
                    <th class="text-center">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($suppliers as $supplier)
                <tr>
                    <td class="ps-4 text-muted small">{{ $suppliers->firstItem() + $loop->index }}</td>
                    <td>
                        <div class="d-flex align-items-center gap-3">
                            <div class="avatar avatar-sm flex-shrink-0">
                                <span class="avatar-initial rounded-circle bg-label-success fw-bold"
                                      style="font-size:12px;">
                                    {{ $supplier->initials }}
                                </span>
                            </div>
                            <div>
                                <div class="fw-semibold text-dark">{{ $supplier->name }}</div>
                                @if($supplier->notes)
                                    <small class="text-muted">{{ Str::limit($supplier->notes, 30) }}</small>
                                @endif
                            </div>
                        </div>
                    </td>
                    <td>
                        @if($supplier->phone)
                            <a href="tel:{{ $supplier->phone }}" class="text-body">
                                <i class="bx bx-phone text-success me-1"></i>{{ $supplier->phone }}
                            </a>
                        @else
                            <span class="text-muted">—</span>
                        @endif
                    </td>
                    <td>
                        <span class="text-muted small">
                            {{ $supplier->address ? Str::limit($supplier->address, 35) : '—' }}
                        </span>
                    </td>
                    <td>
                        <span class="fw-semibold">৳{{ number_format($supplier->total_purchase, 2) }}</span>
                    </td>
                    <td>
                        @if($supplier->due_amount > 0)
                            <span class="fw-bold text-danger">৳{{ number_format($supplier->due_amount, 2) }}</span>
                        @else
                            <span class="text-success fw-semibold">
                                <i class="bx bx-check-circle me-1"></i>Paid
                            </span>
                        @endif
                    </td>
                    <td class="text-center">
                        @php $st = $supplier->payment_status; @endphp
                        @if($st === 'paid')
                            <span class="badge bg-label-success px-3 py-2">Paid</span>
                        @elseif($st === 'partial')
                            <span class="badge bg-label-warning px-3 py-2">Partial</span>
                        @else
                            <span class="badge bg-label-danger px-3 py-2">Due</span>
                        @endif
                    </td>
                    <td class="text-center">
                        <div class="d-flex justify-content-center gap-1">
                            <a href="{{ route('backend.suppliers.edit', $supplier) }}"
                               class="btn btn-sm btn-icon btn-text-success" title="Edit">
                                <i class="bx bx-edit fs-5"></i>
                            </a>
                            <form action="{{ route('backend.suppliers.destroy', $supplier) }}"
                                  method="POST" class="d-inline"
                                  onsubmit="return confirm('{{ $supplier->name }} কে delete করবেন?')">
                                @csrf @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-icon btn-text-danger" title="Delete">
                                    <i class="bx bx-trash fs-5"></i>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="8" class="text-center py-5">
                        <i class="bx bx-buildings bx-lg text-muted mb-3 d-block"></i>
                        <p class="text-muted mb-3">কোনো supplier পাওয়া যায়নি।</p>
                        <a href="{{ route('backend.suppliers.create') }}" class="btn btn-success btn-sm">
                            <i class="bx bx-plus me-1"></i> প্রথম Supplier যোগ করুন
                        </a>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($suppliers->hasPages())
    <div class="card-footer d-flex justify-content-between align-items-center py-3">
        <small class="text-muted">
            Showing {{ $suppliers->firstItem() }}–{{ $suppliers->lastItem() }} of {{ $suppliers->total() }}
        </small>
        {{ $suppliers->links() }}
    </div>
    @endif
</div>

@endsection