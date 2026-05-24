{{-- resources/views/backend/profile/index.blade.php --}}
@extends('backend.layouts.app')
@section('title', 'Admin Profile')

@push('styles')
<style>
/* ── Page Variables ──────────────────────────────── */
:root {
  --ap-accent:   #696cff;
  --ap-accent2:  #8592ff;
  --ap-soft:     #f0f0ff;
  --ap-border:   #e7e7ff;
  --ap-success:  #71dd37;
  --ap-danger:   #ff3e1d;
  --ap-warning:  #ffab00;
  --ap-muted:    #a1acb8;
}

/* ── Avatar Upload ───────────────────────────────── */
.avatar-upload-wrap {
  position: relative;
  display: inline-block;
}
.avatar-upload-wrap img,
.avatar-upload-wrap .avatar-initial-lg {
  width: 64px;
  height: 64px;
  border-radius: 50%;
  object-fit: cover;
  border: 2px solid var(--ap-border);
}
.avatar-initial-lg {
  background: var(--ap-soft);
  color: var(--ap-accent);
  font-size: 1.5rem;
  font-weight: 700;
  display: flex;
  align-items: center;
  justify-content: center;
}
.avatar-upload-btn {
  position: absolute;
  bottom: 1px;
  right: 1px;
  width: 22px;
  height: 22px;
  border-radius: 50%;
  background: var(--ap-accent);
  color: #fff;
  border: 2px solid #fff;
  display: flex;
  align-items: center;
  justify-content: center;
  cursor: pointer;
  font-size: 12px;
  transition: background .2s;
}
.avatar-upload-btn:hover { background: var(--ap-accent2); }

/* ── Cards ───────────────────────────────────────── */
.profile-card {
  border: 1px solid var(--ap-border);
  border-radius: 12px;
  box-shadow: 0 2px 12px rgba(105,108,255,.06);
}
.profile-card .card-header {
  background: var(--ap-soft);
  border-bottom: 1px solid var(--ap-border);
  border-radius: 12px 12px 0 0;
  padding: 14px 20px;
}
.profile-card .card-header h6 {
  margin: 0;
  font-weight: 700;
  color: var(--ap-accent);
  font-size: .88rem;
  letter-spacing: .4px;
  text-transform: uppercase;
}

/* ── Role Badge ──────────────────────────────────── */
.role-badge {
  display: inline-flex;
  align-items: center;
  gap: 5px;
  padding: 4px 12px;
  border-radius: 20px;
  font-size: .78rem;
  font-weight: 600;
}
.role-badge.super-admin { background: #fff0e0; color: #e08a00; }
.role-badge.admin       { background: var(--ap-soft); color: var(--ap-accent); }
.role-badge.staff       { background: #e8f8e8; color: #2a8c3e; }

/* ── Password Strength Bar ───────────────────────── */
.strength-bar { height: 4px; border-radius: 2px; background: #e9ecef; margin-top: 6px; }
.strength-bar .fill { height: 100%; border-radius: 2px; transition: width .3s, background .3s; }

/* ── Admin List Table ────────────────────────────── */
.admin-table-wrap { overflow-x: auto; }
.admin-table { min-width: 700px; }
.admin-table th {
  font-size: .75rem;
  text-transform: uppercase;
  letter-spacing: .5px;
  color: var(--ap-muted);
  font-weight: 600;
  background: var(--ap-soft);
  border-bottom: 1px solid var(--ap-border);
  padding: 12px 16px;
}
.admin-table td {
  padding: 13px 16px;
  vertical-align: middle;
  border-bottom: 1px solid #f3f3f3;
  font-size: .875rem;
}
.admin-table tr:last-child td { border-bottom: none; }
.admin-table tr:hover td { background: #fafafe; }

/* ── Status Pill ─────────────────────────────────── */
.status-pill {
  display: inline-block;
  padding: 3px 10px;
  border-radius: 20px;
  font-size: .75rem;
  font-weight: 600;
}
.status-pill.active   { background: #e8f8e8; color: #2a8c3e; }
.status-pill.inactive { background: #ffeaea; color: #d0331e; }

/* ── Mini Avatar ─────────────────────────────────── */
.mini-avatar {
  width: 32px; height: 32px;
  border-radius: 50%;
  object-fit: cover;
  border: 2px solid var(--ap-border);
}
.mini-avatar-initial {
  width: 32px; height: 32px;
  border-radius: 50%;
  background: var(--ap-soft);
  color: var(--ap-accent);
  font-weight: 700;
  font-size: .78rem;
  display: inline-flex;
  align-items: center;
  justify-content: center;
  border: 2px solid var(--ap-border);
}

/* ── Action Buttons ──────────────────────────────── */
.btn-icon-sm {
  width: 32px; height: 32px;
  border-radius: 8px;
  display: inline-flex;
  align-items: center;
  justify-content: center;
  font-size: .9rem;
  border: 1px solid transparent;
  transition: all .18s;
}
.btn-edit  { background: var(--ap-soft);  color: var(--ap-accent); border-color: var(--ap-border); }
.btn-edit:hover  { background: var(--ap-accent);  color: #fff; }
.btn-del   { background: #fff0ef; color: var(--ap-danger); border-color: #ffd9d5; }
.btn-del:hover   { background: var(--ap-danger);  color: #fff; }

/* ── Password toggle ─────────────────────────────── */
.pw-wrap { position: relative; }
.pw-wrap .pw-toggle {
  position: absolute; right: 12px; top: 50%;
  transform: translateY(-50%);
  cursor: pointer; color: var(--ap-muted);
  background: none; border: none; padding: 0; line-height: 1;
}
.pw-wrap input { padding-right: 38px; }

/* ── Section Divider ─────────────────────────────── */
.section-label {
  font-size: .7rem;
  font-weight: 700;
  letter-spacing: .8px;
  text-transform: uppercase;
  color: var(--ap-muted);
  margin-bottom: 6px;
}
</style>
@endpush

@section('content')

{{-- ── Page Header ─────────────────────────────────────── --}}
<div class="d-flex align-items-center justify-content-between mb-4 flex-wrap gap-2">
  <div>
    <h4 class="fw-bold mb-1" style="color:#333">Admin Profile</h4>
    <nav aria-label="breadcrumb">
      <ol class="breadcrumb mb-0" style="font-size:.82rem">
        <li class="breadcrumb-item">
          <a href="{{ route('backend.dashboard') }}" class="text-decoration-none" style="color:var(--ap-accent)">Dashboard</a>
        </li>
        <li class="breadcrumb-item active">Profile Management</li>
      </ol>
    </nav>
  </div>
  {{-- Online indicator --}}
  <div class="d-flex align-items-center gap-2 px-3 py-2 rounded-pill"
       style="background:var(--ap-soft);border:1px solid var(--ap-border)">
    <span class="badge rounded-pill bg-success p-1"></span>
    <span style="font-size:.82rem;color:#555;font-weight:500">
      Logged in as <strong>{{ auth()->user()->name }}</strong>
    </span>
  </div>
</div>

<div class="row g-4">

  {{-- ════════════════════════════════════════════
       LEFT COLUMN : Profile Info + Change Password
  ════════════════════════════════════════════ --}}
  <div class="col-lg-5 col-xl-4">

    {{-- ── Profile Information Card ──────────────── --}}
    <div class="card profile-card mb-4">
      <div class="card-header">
        <h6><i class="bx bx-user me-2"></i>Profile Information</h6>
      </div>
      <div class="card-body pt-4">

       {{-- Avatar --}}
<div class="d-flex align-items-center gap-3 mb-4 p-3 rounded-3"
     style="background:var(--ap-soft);border:1px solid var(--ap-border)">
  <div class="avatar-upload-wrap" style="flex-shrink:0">
    @if(auth()->user()->avatar)
      <img src="{{ asset('storage/' . auth()->user()->avatar) }}"
           alt="avatar" id="previewImg"
           style="width:48px;height:48px;border-radius:50%;object-fit:cover;border:2px solid var(--ap-border);display:block">
    @else
      <div id="previewInitial"
           style="width:48px;height:48px;border-radius:50%;background:var(--ap-soft);color:var(--ap-accent);font-size:1.2rem;font-weight:700;display:flex;align-items:center;justify-content:center;border:2px solid var(--ap-border)">
        {{ strtoupper(substr(auth()->user()->name ?? 'A', 0, 1)) }}
      </div>
    @endif
    <label for="avatarInput" title="Change photo"
           style="position:absolute;bottom:1px;right:1px;width:20px;height:20px;border-radius:50%;background:var(--ap-accent);color:#fff;border:2px solid #fff;display:flex;align-items:center;justify-content:center;cursor:pointer;font-size:9px">
      <i class="bx bx-camera"></i>
    </label>
  </div>
  <div>
    <div class="fw-semibold" style="font-size:.85rem">{{ auth()->user()->name }}</div>
    <div class="text-muted" style="font-size:.75rem">{{ auth()->user()->email }}</div>
    <label for="avatarInput" class="mt-1 d-inline-block"
           style="font-size:.72rem;color:var(--ap-accent);cursor:pointer;text-decoration:underline">
      Change photo
    </label>
    <span class="text-muted" style="font-size:.72rem"> — JPG, PNG max 2MB</span>
  </div>
</div>

        {{-- Profile Form --}}
        <form action="{{ route('backend.profile.update') }}" method="POST"
              enctype="multipart/form-data" id="profileForm">
          @csrf
          @method('PUT')

          {{-- Hidden avatar input --}}
          <input type="file" id="avatarInput" name="avatar"
                 class="d-none" accept="image/*">

          {{-- Full Name --}}
          <div class="mb-3">
            <label class="form-label fw-semibold" style="font-size:.83rem">Full Name</label>
            <div class="input-group">
              <span class="input-group-text bg-light border-end-0">
                <i class="bx bx-user text-muted"></i>
              </span>
              <input type="text" name="name" class="form-control border-start-0 @error('name') is-invalid @enderror"
                     value="{{ old('name', auth()->user()->name) }}"
                     placeholder="Your full name" required>
              @error('name')
                <div class="invalid-feedback">{{ $message }}</div>
              @enderror
            </div>
          </div>

          {{-- Username --}}
          <div class="mb-3">
            <label class="form-label fw-semibold" style="font-size:.83rem">Username</label>
            <div class="input-group">
              <span class="input-group-text bg-light border-end-0">@</span>
              <input type="text" name="username" class="form-control border-start-0 @error('username') is-invalid @enderror"
                     value="{{ old('username', auth()->user()->username ?? '') }}"
                     placeholder="username">
              @error('username')
                <div class="invalid-feedback">{{ $message }}</div>
              @enderror
            </div>
          </div>

          {{-- Email --}}
          <div class="mb-3">
            <label class="form-label fw-semibold" style="font-size:.83rem">Email Address</label>
            <div class="input-group">
              <span class="input-group-text bg-light border-end-0">
                <i class="bx bx-envelope text-muted"></i>
              </span>
              <input type="email" name="email" class="form-control border-start-0 @error('email') is-invalid @enderror"
                     value="{{ old('email', auth()->user()->email) }}"
                     placeholder="admin@example.com" required>
              @error('email')
                <div class="invalid-feedback">{{ $message }}</div>
              @enderror
            </div>
          </div>

          {{-- Phone --}}
          <div class="mb-3">
            <label class="form-label fw-semibold" style="font-size:.83rem">Phone Number</label>
            <div class="input-group">
              <span class="input-group-text bg-light border-end-0">
                <i class="bx bx-phone text-muted"></i>
              </span>
              <input type="text" name="phone" class="form-control border-start-0 @error('phone') is-invalid @enderror"
                     value="{{ old('phone', auth()->user()->phone) }}"
                     placeholder="01XXXXXXXXX">
              @error('phone')
                <div class="invalid-feedback">{{ $message }}</div>
              @enderror
            </div>
          </div>

          {{-- Role --}}
          <div class="mb-4">
            <label class="form-label fw-semibold" style="font-size:.83rem">Role</label>
            <select name="role" class="form-select @error('role') is-invalid @enderror"
                    {{ auth()->user()->role !== 'super_admin' ? 'disabled' : '' }}>
              <option value="super_admin" {{ auth()->user()->role === 'super_admin' ? 'selected' : '' }}>
                ⭐ Super Admin
              </option>
              <option value="admin" {{ auth()->user()->role === 'admin' ? 'selected' : '' }}>
                🛡 Admin
              </option>
              <option value="staff" {{ auth()->user()->role === 'staff' ? 'selected' : '' }}>
                👤 Staff
              </option>
            </select>
            @if(auth()->user()->role !== 'super_admin')
              <small class="text-muted" style="font-size:.75rem">
                <i class="bx bx-lock-alt me-1"></i>Only Super Admin can change roles.
              </small>
            @endif
            @error('role')
              <div class="invalid-feedback">{{ $message }}</div>
            @enderror
          </div>

          <button type="submit" class="btn btn-primary w-100" style="border-radius:8px">
            <i class="bx bx-save me-1"></i> Save Changes
          </button>
        </form>

      </div>
    </div>

    {{-- ── Change Password Card ───────────────────── --}}
    <div class="card profile-card">
      <div class="card-header">
        <h6><i class="bx bx-lock-alt me-2"></i>Change Password</h6>
      </div>
      <div class="card-body pt-3">

        <form action="{{ route('backend.profile.password') }}" method="POST" id="passwordForm">
          @csrf
          @method('PUT')

          {{-- Current Password --}}
          <div class="mb-3">
            <label class="form-label fw-semibold" style="font-size:.83rem">Current Password</label>
            <div class="pw-wrap">
              <input type="password" name="current_password" id="currentPw"
                     class="form-control @error('current_password') is-invalid @enderror"
                     placeholder="Enter current password">
              <button type="button" class="pw-toggle" onclick="togglePw('currentPw','currentPwIcon')">
                <i class="bx bx-show" id="currentPwIcon"></i>
              </button>
              @error('current_password')
                <div class="invalid-feedback">{{ $message }}</div>
              @enderror
            </div>
          </div>

          {{-- New Password --}}
          <div class="mb-3">
            <label class="form-label fw-semibold" style="font-size:.83rem">New Password</label>
            <div class="pw-wrap">
              <input type="password" name="password" id="newPw"
                     class="form-control @error('password') is-invalid @enderror"
                     placeholder="Min 8 characters"
                     oninput="checkStrength(this.value)">
              <button type="button" class="pw-toggle" onclick="togglePw('newPw','newPwIcon')">
                <i class="bx bx-show" id="newPwIcon"></i>
              </button>
              @error('password')
                <div class="invalid-feedback">{{ $message }}</div>
              @enderror
            </div>
            {{-- Strength bar --}}
            <div class="strength-bar mt-2">
              <div class="fill" id="strengthFill" style="width:0%;background:#e9ecef"></div>
            </div>
            <small id="strengthLabel" class="text-muted" style="font-size:.75rem"></small>
          </div>

          {{-- Confirm Password --}}
          <div class="mb-4">
            <label class="form-label fw-semibold" style="font-size:.83rem">Confirm New Password</label>
            <div class="pw-wrap">
              <input type="password" name="password_confirmation" id="confirmPw"
                     class="form-control"
                     placeholder="Re-enter new password">
              <button type="button" class="pw-toggle" onclick="togglePw('confirmPw','confirmPwIcon')">
                <i class="bx bx-show" id="confirmPwIcon"></i>
              </button>
            </div>
            <small id="matchMsg" style="font-size:.75rem"></small>
          </div>

          <button type="submit" class="btn btn-outline-primary w-100" style="border-radius:8px">
            <i class="bx bx-key me-1"></i> Update Password
          </button>
        </form>

      </div>
    </div>

  </div>{{-- /left column --}}


  {{-- ════════════════════════════════════════════
       RIGHT COLUMN : Admin List Table
  ════════════════════════════════════════════ --}}
  <div class="col-lg-7 col-xl-8">
    <div class="card profile-card">
      <div class="card-header d-flex align-items-center justify-content-between gap-2 flex-wrap">
        <h6 class="mb-0"><i class="bx bx-group me-2"></i>Admin Team</h6>
        @if(auth()->user()->role === 'super_admin')
          <button class="btn btn-sm btn-primary px-3" data-bs-toggle="modal" data-bs-target="#addAdminModal"
                  style="border-radius:8px;font-size:.82rem">
            <i class="bx bx-plus me-1"></i> Add Admin
          </button>
        @endif
      </div>

      {{-- Search + Filter bar --}}
      <div class="px-3 py-2 border-bottom d-flex align-items-center gap-2 flex-wrap"
           style="background:#fafafe">
        <div class="input-group input-group-sm" style="max-width:240px">
          <span class="input-group-text bg-white"><i class="bx bx-search text-muted"></i></span>
          <input type="text" class="form-control border-start-0 bg-white"
                 id="adminSearch" placeholder="Search admin…">
        </div>
        <select class="form-select form-select-sm" id="roleFilter" style="max-width:160px">
          <option value="">All Roles</option>
          <option value="super_admin">Super Admin</option>
          <option value="admin">Admin</option>
          <option value="staff">Staff</option>
        </select>
        <select class="form-select form-select-sm" id="statusFilter" style="max-width:140px">
          <option value="">All Status</option>
          <option value="active">Active</option>
          <option value="inactive">Inactive</option>
        </select>
      </div>

      <div class="card-body p-0">
        <div class="admin-table-wrap">
          <table class="table admin-table mb-0" id="adminTable">
            <thead>
              <tr>
                <th>Photo</th>
                <th>Name</th>
                <th>Email</th>
                <th>Role</th>
                <th>Status</th>
                <th>Last Login</th>
                <th class="text-center">Actions</th>
              </tr>
            </thead>
            <tbody>
              @forelse($admins as $admin)
              <tr data-role="{{ $admin->role }}"
                  data-status="{{ $admin->status ?? 'active' }}"
                  data-search="{{ strtolower($admin->name . ' ' . $admin->email) }}">

                {{-- Photo --}}
                <td style="width:48px">
                  @if($admin->avatar)
                    <img src="{{ asset('storage/' . $admin->avatar) }}"
                         alt=""
                         style="width:32px;height:32px;border-radius:50%;object-fit:cover;border:2px solid var(--ap-border);display:block">
                  @else
                    <span style="width:32px;height:32px;border-radius:50%;background:var(--ap-soft);color:var(--ap-accent);font-weight:700;font-size:.78rem;display:inline-flex;align-items:center;justify-content:center;border:2px solid var(--ap-border)">
                      {{ strtoupper(substr($admin->name ?? 'A', 0, 1)) }}
                    </span>
                  @endif
                </td>

                {{-- Name --}}
                <td>
                  <span class="fw-semibold d-block" style="font-size:.88rem">
                    {{ $admin->name }}
                    @if($admin->id === auth()->id())
                      <span class="badge bg-label-primary ms-1" style="font-size:.68rem">You</span>
                    @endif
                  </span>
                  <small class="text-muted" style="font-size:.75rem">
                    {{ $admin->username ?? '—' }}
                  </small>
                </td>

                {{-- Email --}}
                <td>
                  <a href="mailto:{{ $admin->email }}"
                     class="text-decoration-none text-dark" style="font-size:.85rem">
                    {{ $admin->email }}
                  </a>
                </td>

                {{-- Role --}}
                <td>
                  @if($admin->role === 'super_admin')
                    <span class="role-badge super-admin">
                      <i class="bx bxs-star" style="font-size:.8rem"></i> Super Admin
                    </span>
                  @elseif($admin->role === 'admin')
                    <span class="role-badge admin">
                      <i class="bx bxs-shield" style="font-size:.8rem"></i> Admin
                    </span>
                  @else
                    <span class="role-badge staff">
                      <i class="bx bxs-user" style="font-size:.8rem"></i> Staff
                    </span>
                  @endif
                </td>

                {{-- Status --}}
                <td>
                  @php $st = $admin->status ?? 'active'; @endphp
                  <span class="status-pill {{ $st }}">
                    {{ ucfirst($st) }}
                  </span>
                </td>

                {{-- Last Login --}}
                <td>
                  <span style="font-size:.83rem">
                    {{ $admin->last_login_at
                        ? \Carbon\Carbon::parse($admin->last_login_at)->diffForHumans()
                        : '—' }}
                  </span>
                </td>

                {{-- Actions --}}
                <td class="text-center">
                  <div class="d-flex align-items-center justify-content-center gap-1">

                    {{-- Edit --}}
                    <button class="btn-icon-sm btn-edit"
                            title="Edit"
                            onclick="openEditModal(
                              {{ $admin->id }},
                              '{{ addslashes($admin->name) }}',
                              '{{ addslashes($admin->email) }}',
                              '{{ $admin->phone }}',
                              '{{ $admin->role }}',
                              '{{ $admin->status ?? 'active' }}'
                            )">
                      <i class="bx bx-edit-alt"></i>
                    </button>

                    {{-- Delete (cannot delete yourself) --}}
                    @if($admin->id !== auth()->id() && auth()->user()->role === 'super_admin')
                      <form action="{{ route('backend.profile.admin.destroy', $admin) }}"
                            method="POST" class="delete-form d-inline">
                        @csrf @method('DELETE')
                        <button type="submit" class="btn-icon-sm btn-del"
                                title="Delete"
                                onclick="return confirm('Delete {{ $admin->name }}? This cannot be undone.')">
                          <i class="bx bx-trash-alt"></i>
                        </button>
                      </form>
                    @else
                      <span class="btn-icon-sm" style="opacity:.3;cursor:not-allowed" title="Cannot delete">
                        <i class="bx bx-trash-alt"></i>
                      </span>
                    @endif

                  </div>
                </td>

              </tr>
              @empty
              <tr>
                <td colspan="7" class="text-center py-5 text-muted">
                  <i class="bx bx-user-x d-block mb-2" style="font-size:2rem"></i>
                  No admin accounts found.
                </td>
              </tr>
              @endforelse
            </tbody>
          </table>
        </div>

        {{-- Pagination --}}
        @if($admins->hasPages())
          <div class="px-3 py-3 border-top">
            {{ $admins->links() }}
          </div>
        @endif

      </div>
    </div>
  </div>{{-- /right column --}}

</div>{{-- /row --}}


{{-- ═══════════════════════════════════════════════════
     MODAL : Add New Admin
═══════════════════════════════════════════════════ --}}
<div class="modal fade" id="addAdminModal" tabindex="-1">
  <div class="modal-dialog modal-dialog-centered" style="max-width:480px">
    <div class="modal-content" style="border-radius:14px;border:1px solid var(--ap-border)">
      <div class="modal-header" style="background:var(--ap-soft);border-bottom:1px solid var(--ap-border)">
        <h5 class="modal-title fw-bold" style="font-size:.95rem;color:var(--ap-accent)">
          <i class="bx bx-user-plus me-2"></i>Add New Admin
        </h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <form action="{{ route('backend.profile.admin.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="modal-body px-4 py-3">

          <div class="mb-3">
            <label class="form-label fw-semibold" style="font-size:.83rem">Full Name <span class="text-danger">*</span></label>
            <input type="text" name="name" class="form-control" placeholder="Full name" required>
          </div>

          <div class="mb-3">
            <label class="form-label fw-semibold" style="font-size:.83rem">Email Address <span class="text-danger">*</span></label>
            <input type="email" name="email" class="form-control" placeholder="admin@example.com" required>
          </div>

          <div class="mb-3">
            <label class="form-label fw-semibold" style="font-size:.83rem">Phone</label>
            <input type="text" name="phone" class="form-control" placeholder="01XXXXXXXXX">
          </div>

          <div class="row g-3">
            <div class="col-6">
              <label class="form-label fw-semibold" style="font-size:.83rem">Role <span class="text-danger">*</span></label>
              <select name="role" class="form-select" required>
                <option value="admin">Admin</option>
                <option value="staff">Staff</option>
                <option value="super_admin">Super Admin</option>
              </select>
            </div>
            <div class="col-6">
              <label class="form-label fw-semibold" style="font-size:.83rem">Status</label>
              <select name="status" class="form-select">
                <option value="active">Active</option>
                <option value="inactive">Inactive</option>
              </select>
            </div>
          </div>

          <div class="mt-3">
            <label class="form-label fw-semibold" style="font-size:.83rem">Password <span class="text-danger">*</span></label>
            <div class="pw-wrap">
              <input type="password" name="password" id="modalPw" class="form-control"
                     placeholder="Min 8 characters" required>
              <button type="button" class="pw-toggle" onclick="togglePw('modalPw','modalPwIcon')">
                <i class="bx bx-show" id="modalPwIcon"></i>
              </button>
            </div>
          </div>

          <div class="mt-3">
            <label class="form-label fw-semibold" style="font-size:.83rem">Profile Photo</label>
            <div class="d-flex align-items-center gap-3">
              <div id="modalAvatarPreviewWrap" style="display:none;flex-shrink:0">
                <img id="modalAvatarPreview" src="" alt="preview"
                     style="width:48px;height:48px;border-radius:50%;object-fit:cover;border:2px solid var(--ap-border)">
              </div>
              <input type="file" name="avatar" id="modalAvatarInput"
                     class="form-control form-control-sm" accept="image/*"
                     onchange="previewModalAvatar(this)">
            </div>
            <small class="text-muted" style="font-size:.73rem">JPG, PNG — max 2MB</small>
          </div>

        </div>
        <div class="modal-footer border-top px-4 py-3">
          <button type="button" class="btn btn-outline-secondary btn-sm" data-bs-dismiss="modal">Cancel</button>
          <button type="submit" class="btn btn-primary btn-sm px-4">
            <i class="bx bx-plus me-1"></i> Create Admin
          </button>
        </div>
      </form>
    </div>
  </div>
</div>


{{-- ═══════════════════════════════════════════════════
     MODAL : Edit Admin
═══════════════════════════════════════════════════ --}}
<div class="modal fade" id="editAdminModal" tabindex="-1">
  <div class="modal-dialog modal-dialog-centered" style="max-width:480px">
    <div class="modal-content" style="border-radius:14px;border:1px solid var(--ap-border)">
      <div class="modal-header" style="background:var(--ap-soft);border-bottom:1px solid var(--ap-border)">
        <h5 class="modal-title fw-bold" style="font-size:.95rem;color:var(--ap-accent)">
          <i class="bx bx-edit me-2"></i>Edit Admin
        </h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <form id="editAdminForm" method="POST">
        @csrf @method('PUT')
        <div class="modal-body px-4 py-3">

          <div class="mb-3">
            <label class="form-label fw-semibold" style="font-size:.83rem">Full Name</label>
            <input type="text" name="name" id="editName" class="form-control" required>
          </div>

          <div class="mb-3">
            <label class="form-label fw-semibold" style="font-size:.83rem">Email Address</label>
            <input type="email" name="email" id="editEmail" class="form-control" required>
          </div>

          <div class="mb-3">
            <label class="form-label fw-semibold" style="font-size:.83rem">Phone</label>
            <input type="text" name="phone" id="editPhone" class="form-control">
          </div>

          <div class="row g-3">
            <div class="col-6">
              <label class="form-label fw-semibold" style="font-size:.83rem">Role</label>
              <select name="role" id="editRole" class="form-select">
                <option value="super_admin">Super Admin</option>
                <option value="admin">Admin</option>
                <option value="staff">Staff</option>
              </select>
            </div>
            <div class="col-6">
              <label class="form-label fw-semibold" style="font-size:.83rem">Status</label>
              <select name="status" id="editStatus" class="form-select">
                <option value="active">Active</option>
                <option value="inactive">Inactive</option>
              </select>
            </div>
          </div>

        </div>
        <div class="modal-footer border-top px-4 py-3">
          <button type="button" class="btn btn-outline-secondary btn-sm" data-bs-dismiss="modal">Cancel</button>
          <button type="submit" class="btn btn-primary btn-sm px-4">
            <i class="bx bx-save me-1"></i> Save Changes
          </button>
        </div>
      </form>
    </div>
  </div>
</div>

@endsection


@push('scripts')
<script>
/* ── Modal Avatar Preview (Add Admin) ───────────────── */
function previewModalAvatar(input) {
  if (!input.files || !input.files[0]) return;
  const reader = new FileReader();
  reader.onload = e => {
    document.getElementById('modalAvatarPreview').src = e.target.result;
    document.getElementById('modalAvatarPreviewWrap').style.display = 'block';
  };
  reader.readAsDataURL(input.files[0]);
}

/* ── Avatar Preview (Own Profile) ───────────────────── */
document.getElementById('avatarInput').addEventListener('change', function () {
  const file = this.files[0];
  if (!file) return;
  const reader = new FileReader();
  reader.onload = e => {
    // Remove initial placeholder if exists
    const initial = document.getElementById('previewInitial');
    if (initial) initial.remove();

    let img = document.getElementById('previewImg');
    if (!img) {
      img = document.createElement('img');
      img.id = 'previewImg';
      img.alt = 'avatar';
      document.querySelector('.avatar-upload-wrap').prepend(img);
    }
    img.src = e.target.result;
  };
  reader.readAsDataURL(file);
});

/* ── Password Toggle ─────────────────────────────────── */
function togglePw(inputId, iconId) {
  const input = document.getElementById(inputId);
  const icon  = document.getElementById(iconId);
  if (input.type === 'password') {
    input.type = 'text';
    icon.classList.replace('bx-show', 'bx-hide');
  } else {
    input.type = 'password';
    icon.classList.replace('bx-hide', 'bx-show');
  }
}

/* ── Password Strength ───────────────────────────────── */
function checkStrength(pw) {
  const fill  = document.getElementById('strengthFill');
  const label = document.getElementById('strengthLabel');
  let score = 0;
  if (pw.length >= 8)        score++;
  if (/[A-Z]/.test(pw))     score++;
  if (/[0-9]/.test(pw))     score++;
  if (/[^A-Za-z0-9]/.test(pw)) score++;

  const levels = [
    { pct: '0%',   color: '#e9ecef', text: '' },
    { pct: '25%',  color: '#ff3e1d', text: 'Weak' },
    { pct: '50%',  color: '#ffab00', text: 'Fair' },
    { pct: '75%',  color: '#696cff', text: 'Good' },
    { pct: '100%', color: '#71dd37', text: 'Strong' },
  ];
  const lvl = levels[score] || levels[0];
  fill.style.width    = lvl.pct;
  fill.style.background = lvl.color;
  label.textContent   = lvl.text;
  label.style.color   = lvl.color;
}

/* ── Password Match Check ────────────────────────────── */
document.getElementById('confirmPw')?.addEventListener('input', function () {
  const pw   = document.getElementById('newPw').value;
  const msg  = document.getElementById('matchMsg');
  if (!this.value) { msg.textContent = ''; return; }
  if (this.value === pw) {
    msg.textContent = '✓ Passwords match';
    msg.style.color = '#71dd37';
  } else {
    msg.textContent = '✗ Passwords do not match';
    msg.style.color = '#ff3e1d';
  }
});

/* ── Admin Table : Search + Filter ──────────────────── */
function filterTable() {
  const search = document.getElementById('adminSearch').value.toLowerCase();
  const role   = document.getElementById('roleFilter').value;
  const status = document.getElementById('statusFilter').value;

  document.querySelectorAll('#adminTable tbody tr[data-search]').forEach(row => {
    const matchSearch = row.dataset.search.includes(search);
    const matchRole   = !role   || row.dataset.role   === role;
    const matchStatus = !status || row.dataset.status === status;
    row.style.display = (matchSearch && matchRole && matchStatus) ? '' : 'none';
  });
}
document.getElementById('adminSearch').addEventListener('input',  filterTable);
document.getElementById('roleFilter').addEventListener('change',  filterTable);
document.getElementById('statusFilter').addEventListener('change', filterTable);

/* ── Edit Modal : Populate ───────────────────────────── */
const editBaseUrl = '{{ route('backend.profile.admin.update', ['admin' => '__ID__']) }}';

function openEditModal(id, name, email, phone, role, status) {
  document.getElementById('editName').value   = name;
  document.getElementById('editEmail').value  = email;
  document.getElementById('editPhone').value  = phone || '';
  document.getElementById('editRole').value   = role;
  document.getElementById('editStatus').value = status;
  document.getElementById('editAdminForm').action = editBaseUrl.replace('__ID__', id);

  new bootstrap.Modal(document.getElementById('editAdminModal')).show();
}
</script>
@endpush