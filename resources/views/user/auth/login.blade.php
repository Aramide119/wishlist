<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="shortcut icon" href="{{ asset('logo.png') }}" type="image/x-icon">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
    .password-container {
            position: relative;
        }
        .password-toggle {
            position: absolute;
            right: 10px;
            top: 50%;
            transform: translateY(-50%);
            cursor: pointer;
            color: #6c757d;
        }
        .password-toggle:hover {
            color: #000;
        }

</style>
</head>
<body class="bg-light">

    <div class="d-flex flex-column justify-content-center align-items-center vh-100">
        <div class="mb-3 mt-2 text-center">
            <img src="{{ asset('images/logo.png') }}" alt="MyWishlist Logo" style="height: 50px;">
        </div>
        <div class="bg-white p-4 rounded shadow-lg w-100" style="max-width: 400px;">
            <h2 class="text-center text-success">Get Started</h2>
            
            {{-- <button class="btn btn-light w-100 mt-3 border d-flex align-items-center justify-content-center">
                <img src="{{ asset('images/google-icon.png') }}" alt="Google" class="me-2" style="height: 20px;">
                Continue with Google
            </button> --}}
            
            {{-- <div class="text-center my-3 text-muted">OR</div> --}}
            
            <form action="{{ route('user.login') }}" method="POST">
                @csrf
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <div class="mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" name="email" id="email" class="form-control" placeholder="Email Address" required>
                </div>
                
                <div class="mb-3">
                            <label for="password" class="form-label">Password</label>
                            <div class="password-container">
                                <input type="password" name="password" id="password" class="form-control" required>
                                <span class="password-toggle" id="togglePassword">
                                    <i class="fas fa-eye-slash"></i>
                                </span>
                            </div>
                </div>

                
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <div class="form-check">
                        <input type="checkbox" class="form-check-input" id="remember" name="remember">
                        <label class="form-check-label" for="remember">Remember Me</label>
                    </div>
                    <a href="#" class="text-decoration-none text-success">Forgot password?</a>
                </div>
                
                <button type="submit" class="btn btn-success w-100">Login</button>
            </form>
            
            <div class="text-center mt-3">
                Don't have an account? <a href="{{ url('/register') }}" class="text-success text-decoration-none">Create an account</a>
            </div>
        </div>
    </div>
    <script>
        @if(session('success'))
            Swal.fire({
                icon: 'success',
                title: 'Successful!',
                text: '{{ session('success') }}',
                showConfirmButton: false,
                timer: 5000
            });
        @endif
        @if(session('error'))
            Swal.fire({
                icon: 'error',
                title: 'Error!',
                text: '{{ session('error') }}',
                showConfirmButton: false,
                timer: 5000
            })
        ;@endif

        document.addEventListener('DOMContentLoaded', function() {
          const togglePassword = document.getElementById('togglePassword');
          const passwordInput = document.getElementById('password');

          togglePassword.addEventListener('click', function() {
              // Toggle the type attribute
              const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
              passwordInput.setAttribute('type', type);
              
              // Toggle the eye icon              
              
              this.querySelector('i').classList.toggle('fa-eye-slash');
              this.querySelector('i').classList.toggle('fa-eye');
          });
      });
    </script>
</body>
</html>
