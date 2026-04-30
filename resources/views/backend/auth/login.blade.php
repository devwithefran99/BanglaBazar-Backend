<!DOCTYPE html>
<html lang="en" class="light-style customizer-hide" dir="ltr" data-theme="theme-default">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no"/>
  <title>Admin Login | BanglaBazar</title>
  <link rel="icon" type="image/x-icon" href="{{ asset('backend/assets/img/favicon/favicon.ico') }}" />
  <link href="https://fonts.googleapis.com/css2?family=Public+Sans:wght@300;400;500;600;700&display=swap" rel="stylesheet"/>
  <link rel="stylesheet" href="{{ asset('backend/assets/vendor/fonts/boxicons.css') }}" />
  <link rel="stylesheet" href="{{ asset('backend/assets/vendor/css/core.css') }}" />
  <link rel="stylesheet" href="{{ asset('backend/assets/vendor/css/theme-default.css') }}" />
  <link rel="stylesheet" href="{{ asset('backend/assets/css/demo.css') }}" />
  <link rel="stylesheet" href="{{ asset('backend/assets/vendor/css/pages/page-auth.css') }}" />
  <script src="{{ asset('backend/assets/vendor/js/helpers.js') }}"></script>
  <script src="{{ asset('backend/assets/js/config.js') }}"></script>
</head>
<body>
  <div class="container-xxl">
    <div class="authentication-wrapper authentication-basic container-p-y">
      <div class="authentication-inner">
        <div class="card">
          <div class="card-body">

            <div class="app-brand justify-content-center mb-4">
              <a href="{{ route('home') }}">
                <img src="{{ asset('frontend/image/Logo.png') }}" alt="BanglaBazar" height="40">
              </a>
            </div>

            <h4 class="mb-2">Welcome Back Admin! 👋</h4>
            <p class="mb-4">Admin panel এ login করুন</p>

            {{-- Error --}}
            @if($errors->any())
              <div class="alert alert-danger mb-3">
                {{ $errors->first() }}
              </div>
            @endif

            <form action="{{ route('login.post') }}" method="POST" class="mb-3">
              @csrf
              <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" class="form-control" id="email" name="email"
                       value="{{ old('email') }}" placeholder="admin@example.com" required autofocus/>
              </div>
              <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <div class="input-group input-group-merge">
                  <input type="password" class="form-control" id="password"
                         name="password" placeholder="············" required/>
                  <span class="input-group-text cursor-pointer" id="togglePw">
                    <i class="bx bx-hide"></i>
                  </span>
                </div>
              </div>
              <div class="mb-3">
                <div class="form-check">
                  <input class="form-check-input" type="checkbox" name="remember" id="remember"/>
                  <label class="form-check-label" for="remember">Remember Me</label>
                </div>
              </div>
              <button class="btn btn-primary d-grid w-100" type="submit">Sign In</button>
            </form>

            <p class="text-center">
              <a href="{{ route('signin') }}">Customer হলে এখানে Login করুন →</a>
            </p>

          </div>
        </div>
      </div>
    </div>
  </div>

  <script src="{{ asset('backend/assets/vendor/libs/jquery/jquery.js') }}"></script>
  <script src="{{ asset('backend/assets/vendor/js/bootstrap.js') }}"></script>
  <script src="{{ asset('backend/assets/js/main.js') }}"></script>
  <script>
    document.getElementById('togglePw').addEventListener('click', function() {
      const pw = document.getElementById('password');
      const icon = this.querySelector('i');
      if (pw.type === 'password') {
        pw.type = 'text';
        icon.className = 'bx bx-show';
      } else {
        pw.type = 'password';
        icon.className = 'bx bx-hide';
      }
    });
  </script>
</body>
</html>