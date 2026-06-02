<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password | BanglaBazar</title>
    <link rel="icon" type="image/png" href="{{ asset('frontend/image/favIcon.png') }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;500;600;700;800&display=swap" rel="stylesheet"/>
    <link rel="stylesheet" href="{{ asset('frontend/css/common.css') }}">
    <link rel="stylesheet" href="{{ asset('frontend/css/pages.css') }}">
</head>
<body>

<div id="preloader">
  <div class="loader">
    <img src="{{ asset('frontend/image/favIcon.png') }}" width="80px" alt="logo">
    <p class="mt-5">Loading...</p>
  </div>
</div>

<main>
<section>
  <div class="container">
    <div class="row justify-content-center">
      <div class="card">

        <div class="brand">
          <img src="{{ asset('frontend/image/Logo.png') }}" alt="">
        </div>

        <div class="heading">
          <h1>Reset Password</h1>
          <p>Enter your new password below.</p>
        </div>

        <form method="POST" action="{{ route('password.update') }}">
          @csrf

          {{-- Hidden token --}}
          <input type="hidden" name="token" value="{{ $token }}">

          {{-- Email --}}
          <div class="field">
            <label for="email">Email address</label>
            <div class="input-wrap">
              <svg class="icon" viewBox="0 0 24 24"><rect x="2" y="4" width="20" height="16" rx="2"/><polyline points="2,4 12,13 22,4"/></svg>
              <input type="email" id="email" name="email"
                     placeholder="you@example.com"
                     value="{{ old('email', request('email')) }}"
                     autocomplete="email">
            </div>
            @error('email')
              <div class="error-msg" style="display:flex;">
                <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
                {{ $message }}
              </div>
            @enderror
          </div>

          {{-- New Password --}}
          <div class="field">
            <label for="password">New Password</label>
            <div class="input-wrap">
              <svg class="icon" viewBox="0 0 24 24"><rect x="3" y="11" width="18" height="11" rx="2"/><path d="M7 11V7a5 5 0 0 1 10 0v4"/></svg>
              <input type="password" id="password" name="password"
                     placeholder="Minimum 8 characters"
                     autocomplete="new-password">
              <button class="eye-btn" id="toggle-pw" type="button">
                <svg id="eye-icon" viewBox="0 0 24 24"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>
              </button>
            </div>
            @error('password')
              <div class="error-msg" style="display:flex;">
                <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
                {{ $message }}
              </div>
            @enderror
          </div>

          {{-- Confirm Password --}}
          <div class="field">
            <label for="password_confirmation">Confirm Password</label>
            <div class="input-wrap">
              <svg class="icon" viewBox="0 0 24 24"><rect x="3" y="11" width="18" height="11" rx="2"/><path d="M7 11V7a5 5 0 0 1 10 0v4"/></svg>
              <input type="password" id="password_confirmation" name="password_confirmation"
                     placeholder="Re-enter new password"
                     autocomplete="new-password">
              <button class="eye-btn" id="toggle-pw2" type="button">
                <svg viewBox="0 0 24 24"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>
              </button>
            </div>
          </div>

          <button type="submit" class="btn-login">
            <i class="bi bi-check-circle me-1"></i> Reset Password
          </button>

        </form>

        <p class="register-row">
          Back to <a href="{{ route('signin') }}">Sign In</a>
        </p>

      </div>
    </div>
  </div>
</section>
</main>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script src="{{ asset('frontend/js/common.js') }}"></script>
<script>
  // Eye toggle - New Password
  document.getElementById('toggle-pw')?.addEventListener('click', function () {
    const input = document.getElementById('password');
    const icon = document.getElementById('eye-icon');
    if (input.type === 'password') {
      input.type = 'text';
      icon.innerHTML = '<path d="M17.94 17.94A10.07 10.07 0 0 1 12 20c-7 0-11-8-11-8a18.45 18.45 0 0 1 5.06-5.94"/><path d="M9.9 4.24A9.12 9.12 0 0 1 12 4c7 0 11 8 11 8a18.5 18.5 0 0 1-2.16 3.19"/><line x1="1" y1="1" x2="23" y2="23"/>';
    } else {
      input.type = 'password';
      icon.innerHTML = '<path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/>';
    }
  });

  // Eye toggle - Confirm Password
  document.getElementById('toggle-pw2')?.addEventListener('click', function () {
    const input = document.getElementById('password_confirmation');
    const svg = this.querySelector('svg');
    if (input.type === 'password') {
      input.type = 'text';
      svg.innerHTML = '<path d="M17.94 17.94A10.07 10.07 0 0 1 12 20c-7 0-11-8-11-8a18.45 18.45 0 0 1 5.06-5.94"/><path d="M9.9 4.24A9.12 9.12 0 0 1 12 4c7 0 11 8 11 8a18.5 18.5 0 0 1-2.16 3.19"/><line x1="1" y1="1" x2="23" y2="23"/>';
    } else {
      input.type = 'password';
      svg.innerHTML = '<path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/>';
    }
  });
</script>

</body>
</html>