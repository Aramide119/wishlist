<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
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
    <div class="mb-3 mt-5 text-center">
        <img src="{{ asset('images/logo.png') }}" alt="MyWishlist Logo" style="height: 50px;">
    </div>
        <div class="d-flex flex-column justify-content-center align-items-center vh-90">
            <div class="bg-white p-4 rounded shadow-lg w-100" style="max-width: 500px;">
                <h2 class="text-center text-success">Get Started</h2>
                
                {{-- <button class="btn btn-light w-100 mt-3 border d-flex align-items-center justify-content-center">
                    <img src="{{ asset('images/google-icon.png') }}" alt="Google" class="me-2" style="height: 20px;">
                    Continue with Google
                </button>
                
                <div class="text-center my-3 text-muted">OR</div> --}}
                
                <form action="{{ route('register') }}" method="POST">
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
                        <label for="first_name" class="form-label">First Name</label>
                        <input type="text" name="first_name" id="first_name" class="form-control" placeholder="John" required>
                    </div>
                    
                    <div class="mb-3">
                        <label for="last_name" class="form-label">Last Name</label>
                        <input type="text" name="last_name" id="last_name" class="form-control" placeholder="Doe" required>
                    </div>
                    
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
                    
                    <div class="mb-3">
                        <label for="password_confirmation" class="form-label">Confirm Password</label>
                        <div class="password-container">
                            <input type="password" name="password_confirmation" id="confirmPassword" class="form-control" required>
                            <span class="password-toggle" id="toggleConfirmPassword">
                            <i class="fas fa-eye-slash"></i>
                            </span>
                        </div>
                        
                    </div>
                    
                    <button type="submit" class="btn btn-success w-100">Register</button>
                    <p class="text-center">By clicking "Create account" or "Continue with Google", you agree to the Mywishlist TOS and Privacy Policy.</p>
                    <p class="text-center">Don’t have an account? <a class="text-success" href="{{url('/login')}}" style="text-decoration: none">Sign in</a></p>
                </form>
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

                     const toggleConfirmPassword = document.getElementById('toggleConfirmPassword');
          const confirmPasswordInput = document.getElementById('confirmPassword');

          toggleConfirmPassword.addEventListener('click', function() {
              // Toggle the type attribute
              const type = confirmPasswordInput.getAttribute('type') === 'password' ? 'text' : 'password';
              confirmPasswordInput.setAttribute('type', type);
              
              // Toggle the eye icon
              this.querySelector('i').classList.toggle('fa-eye-slash');
              this.querySelector('i').classList.toggle('fa-eye');

                  });
      });
    </script>
</body>
</html>
