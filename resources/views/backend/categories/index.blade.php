@extends('backend.layouts.app')
@section('title', 'Categories')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
  <h4 class="fw-bold py-3 mb-0">
    <span class="text-muted fw-light">Management /</span> Categories
  </h4>
</div>

<div class="row">

  {{-- ── ADD FORM ── --}}
  <div class="col-md-4">
    <div class="card mb-4">
      <div class="card-header">
        <h5 class="mb-0"><i class="bx bx-plus-circle me-2"></i>New Category Add করুন</h5>
      </div>
      <div class="card-body">
        <form action="{{ route('backend.categories.store') }}" method="POST" enctype="multipart/form-data">
          @csrf

          <div class="mb-3">
            <label class="form-label fw-semibold">Category Name <span class="text-danger">*</span></label>
            <input type="text" name="name"
                   class="form-control @error('name') is-invalid @enderror"
                   value="{{ old('name') }}"
                   placeholder="যেমন: Sutki">
            @error('name')
              <div class="invalid-feedback">{{ $message }}</div>
            @enderror
          </div>

          <div class="mb-3">
            <label class="form-label fw-semibold">Image</label>
            <input type="file" name="image" class="form-control" accept="image/*"
                   onchange="previewNew(this)">
            <div id="newPreview" class="mt-2 d-none">
              <img id="newPreviewImg" src="" style="height:80px;border-radius:8px;border:1px solid #ddd;">
            </div>
          </div>

          <div class="mb-3">
            <label class="form-label fw-semibold">Sort Order</label>
            <input type="number" name="sort_order" class="form-control" value="0" min="0">
            <small class="text-muted">ছোট number আগে দেখাবে</small>
          </div>

          <div class="mb-3">
            <div class="form-check form-switch">
              <input class="form-check-input" type="checkbox" name="is_active" id="is_active" checked>
              <label class="form-check-label" for="is_active">Active (Frontend এ দেখাবে)</label>
            </div>
          </div>

          <button type="submit" class="btn btn-primary w-100">
            <i class="bx bx-save me-1"></i> Save Category
          </button>
        </form>
      </div>
    </div>
  </div>

  {{-- ── CATEGORY LIST ── --}}
  <div class="col-md-8">
    <div class="card">
      <div class="card-header">
        <h5 class="mb-0"><i class="bx bx-category me-2"></i>All Categories ({{ $categories->count() }})</h5>
      </div>
      <div class="card-body p-0">
        <div class="table-responsive">
          <table class="table table-hover mb-0">
            <thead class="table-light">
              <tr>
                <th>#</th>
                <th>Image</th>
                <th>Name</th>
                <th>Slug</th>
                <th>Order</th>
                <th>Status</th>
                <th>Action</th>
              </tr>
            </thead>
            <tbody>
              @forelse($categories as $cat)
              <tr>
                <td>{{ $loop->iteration }}</td>
                <td>
                  @if($cat->image)
                    <img src="{{ asset('storage/'.$cat->image) }}"
                         style="height:45px;width:45px;object-fit:cover;border-radius:8px;">
                  @else
                    <div style="height:45px;width:45px;background:#f0f0f0;border-radius:8px;
                                display:flex;align-items:center;justify-content:center;">
                      <i class="bx bx-image text-muted"></i>
                    </div>
                  @endif
                </td>
                <td class="fw-semibold">{{ $cat->name }}</td>
                <td><code>{{ $cat->slug }}</code></td>
                <td>{{ $cat->sort_order }}</td>
                <td>
                  @if($cat->is_active)
                    <span class="badge bg-success">Active</span>
                  @else
                    <span class="badge bg-secondary">Inactive</span>
                  @endif
                </td>
                <td>
                  <button class="btn btn-sm btn-warning me-1"
                          onclick="openEdit({{ $cat->id }}, '{{ $cat->name }}', {{ $cat->sort_order }}, {{ $cat->is_active ? 'true' : 'false' }}, '{{ $cat->image ? asset('storage/'.$cat->image) : '' }}')">
                    <i class="bx bx-edit"></i>
                  </button>
                  <form action="{{ route('backend.categories.destroy', $cat->id) }}"
                        method="POST" style="display:inline;"
                        onsubmit="return confirm('Delete করবেন?')">
                    @csrf @method('DELETE')
                    <button type="submit" class="btn btn-sm btn-danger">
                      <i class="bx bx-trash"></i>
                    </button>
                  </form>
                </td>
              </tr>
              @empty
              <tr>
                <td colspan="7" class="text-center py-4 text-muted">
                  কোনো category নেই। উপরে form থেকে add করুন।
                </td>
              </tr>
              @endforelse
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>

</div>

{{-- ── EDIT MODAL ── --}}
<div class="modal fade" id="editModal" tabindex="-1">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Category Edit করুন</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <form id="editForm" method="POST" enctype="multipart/form-data">
        @csrf @method('PUT')
        <div class="modal-body">

          <div class="mb-3">
            <label class="form-label fw-semibold">Category Name</label>
            <input type="text" name="name" id="editName" class="form-control" required>
          </div>

          <div class="mb-3">
            <label class="form-label fw-semibold">New Image (optional)</label>
            <input type="file" name="image" class="form-control" accept="image/*"
                   onchange="previewEdit(this)">
            <div class="mt-2">
              <img id="editPreviewImg" src="" style="height:80px;border-radius:8px;border:1px solid #ddd;display:none;">
            </div>
          </div>

          <div class="mb-3">
            <label class="form-label fw-semibold">Sort Order</label>
            <input type="number" name="sort_order" id="editOrder" class="form-control" min="0">
          </div>

          <div class="mb-3">
            <div class="form-check form-switch">
              <input class="form-check-input" type="checkbox" name="is_active" id="editActive">
              <label class="form-check-label" for="editActive">Active</label>
            </div>
          </div>

        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
          <button type="submit" class="btn btn-primary">
            <i class="bx bx-save me-1"></i> Update করুন
          </button>
        </div>
      </form>
    </div>
  </div>
</div>

@endsection

@push('scripts')
<script>
  // New category image preview
  function previewNew(input) {
    if (input.files && input.files[0]) {
      const reader = new FileReader();
      reader.onload = e => {
        document.getElementById('newPreviewImg').src = e.target.result;
        document.getElementById('newPreview').classList.remove('d-none');
      };
      reader.readAsDataURL(input.files[0]);
    }
  }

  // Edit modal খোলো
  function openEdit(id, name, order, isActive, imgSrc) {
    document.getElementById('editForm').action = `/admin/categories/${id}`;
    document.getElementById('editName').value = name;
    document.getElementById('editOrder').value = order;
    document.getElementById('editActive').checked = isActive;

    const img = document.getElementById('editPreviewImg');
    if (imgSrc) {
      img.src = imgSrc;
      img.style.display = 'block';
    } else {
      img.style.display = 'none';
    }

    new bootstrap.Modal(document.getElementById('editModal')).show();
  }

  // Edit image preview
  function previewEdit(input) {
    if (input.files && input.files[0]) {
      const reader = new FileReader();
      reader.onload = e => {
        const img = document.getElementById('editPreviewImg');
        img.src = e.target.result;
        img.style.display = 'block';
      };
      reader.readAsDataURL(input.files[0]);
    }
  }
</script>
@endpush