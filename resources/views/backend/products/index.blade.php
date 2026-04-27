@extends('backend.layouts.app')

@section('title', 'All Products')

@section('content')

  <div class="d-flex justify-content-between align-items-center mb-4">
    <h4 class="fw-bold py-3 mb-0">
      <span class="text-muted fw-light">Products /</span> All Products
    </h4>
    <a href="{{ route('backend.products.create') }}" class="btn btn-primary">
      <i class="bx bx-plus me-1"></i> Add Product
    </a>
  </div>

  <div class="card">
    <div class="table-responsive text-nowrap">
      <table class="table table-hover">
        <thead>
          <tr>
            <th>#</th>
            <th>Image</th>
            <th>Name</th>
            <th>Category</th>
            <th>Price</th>
            <th>Stock</th>
            <th>Featured</th>
            <th>Status</th>
            <th>Actions</th>
          </tr>
        </thead>
        <tbody>
          @forelse($products as $product)
          <tr>
            <td>{{ $loop->iteration }}</td>
            <td>
              @if($product->image)
                <img src="{{ asset('storage/' . $product->image) }}"
                     width="50" height="50" class="rounded" style="object-fit:cover;">
              @else
                <span class="badge bg-label-secondary">No Image</span>
              @endif
            </td>
            <td><strong>{{ $product->name }}</strong></td>
            <td>
              @if($product->category)
                <span class="badge bg-label-info">{{ $product->category }}</span>
              @else
                <span class="text-muted">—</span>
              @endif
            </td>
            <td>
              ৳{{ number_format($product->price, 2) }}
              @if($product->old_price)
                <br><small class="text-muted text-decoration-line-through">
                  ৳{{ number_format($product->old_price, 2) }}
                </small>
                <span class="badge bg-danger ms-1">-{{ $product->salePercent() }}%</span>
              @endif
            </td>
            <td>
              @if($product->stock == 0)
                <span class="badge bg-danger">Out of Stock</span>
              @elseif($product->isLowStock())
                <span class="badge bg-warning">Low ({{ $product->stock }})</span>
              @else
                <span class="badge bg-success">{{ $product->stock }}</span>
              @endif
            </td>
            <td>
              @if($product->is_featured)
                <span class="badge bg-label-primary"><i class="bx bx-star"></i> Yes</span>
              @else
                <span class="badge bg-label-secondary">No</span>
              @endif
            </td>
            <td>
              @if($product->is_active)
                <span class="badge bg-label-success">Active</span>
              @else
                <span class="badge bg-label-danger">Inactive</span>
              @endif
            </td>
            <td>
              <a href="{{ route('backend.products.edit', $product->id) }}"
                 class="btn btn-sm btn-outline-primary me-1" title="Edit">
                <i class="bx bx-edit"></i>
              </a>
              <form action="{{ route('backend.products.destroy', $product->id) }}"
                    method="POST" class="d-inline"
                    onsubmit="return confirm('এই product টি delete করবেন?')">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-sm btn-outline-danger" title="Delete">
                  <i class="bx bx-trash"></i>
                </button>
              </form>
            </td>
          </tr>
          @empty
          <tr>
            <td colspan="9" class="text-center py-5">
              <i class="bx bx-package fs-1 text-muted d-block mb-2"></i>
              <span class="text-muted">কোনো product পাওয়া যায়নি।</span>
              <br>
              <a href="{{ route('backend.products.create') }}" class="btn btn-primary btn-sm mt-2">
                প্রথম Product যোগ করুন
              </a>
            </td>
          </tr>
          @endforelse
        </tbody>
      </table>
    </div>

    <!-- Pagination -->
    @if($products->hasPages())
    <div class="card-footer">
      {{ $products->links() }}
    </div>
    @endif
  </div>

@endsection