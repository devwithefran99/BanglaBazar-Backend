<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forgot Password | BanglaBazar</title>
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
          <h1>Forgot Password</h1>
          <p>Enter your email and we'll send you a reset link.</p>
        </div>

        @if (session('status'))
          <div class="alert alert-success text-center mb-3" style="border-radius:12px; font-size:14px;">
            <i class="bi bi-check-circle-fill me-1"></i> {{ session('status') }}
          </div>
        @endif

        <form method="POST" action="{{ route('password.email') }}">
          @csrf

          <div class="field">
            <label for="email">Email address</label>
            <div class="input-wrap">
              <svg class="icon" viewBox="0 0 24 24"><rect x="2" y="4" width="20" height="16" rx="2"/><polyline points="2,4 12,13 22,4"/></svg>
              <input type="email" id="email" name="email"
                     placeholder="you@example.com"
                     value="{{ old('email') }}"
                     autocomplete="email">
            </div>
            @error('email')
              <div class="error-msg" style="display:flex;">
                <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
                {{ $message }}
              </div>
            @enderror
          </div>

          <button type="submit" class="btn-login">
            <i class="bi bi-send me-1"></i> Send Reset Link
          </button>

        </form>

        <p class="register-row">
          Remember your password? <a href="{{ route('signin') }}">Sign In</a>
        </p>

      </div>
    </div>
  </div>
</section>
</main>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script src="{{ asset('frontend/js/common.js') }}"></script>

</body>
</html>