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
            <h2 class="text-center text-success">Reset Password</h2> 
            <form action="{{ route('password.reset') }}" method="POST">
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
                    <input type="hidden" name="email" id="email" class="form-control" value="{{$user->email}}" required>
                </div>
                
                <div class="mb-3">
                    <label for="password" class="form-label">New Password</label>
                    <div class="password-container">
                        <input type="password" name="password" id="password" class="form-control" required>
                        <span class="password-toggle" id="togglePassword">
                            <i class="fas fa-eye-slash"></i>
                        </span>
                    </div>
                </div>
                <div class="mb-3">
                    <button type="submit" class="btn btn-success">save</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        // Function to initialize password toggle
        function initPasswordToggle() {
            const togglePassword = document.getElementById('togglePassword');
            const passwordInput = document.getElementById('password');
            
            if (togglePassword && passwordInput) {
                // Remove any existing event listeners to prevent duplicates
                togglePassword.removeEventListener('click', togglePasswordVisibility);
                // Add new event listener
                togglePassword.addEventListener('click', togglePasswordVisibility);
            }
        }

        // Function to toggle password visibility
        function togglePasswordVisibility() {
            const passwordInput = document.getElementById('password');
            // Toggle the type attribute
            const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
            passwordInput.setAttribute('type', type);
            
            // Toggle the eye icon
            this.querySelector('i').classList.toggle('fa-eye-slash');
            this.querySelector('i').classList.toggle('fa-eye');
        }

        // Initialize on DOMContentLoaded
        document.addEventListener('DOMContentLoaded', initPasswordToggle);

        // Also initialize immediately to handle redirects
        initPasswordToggle();

        // Handle Sweet Alert notifications
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
            });
        @endif
    </script>
</body>
</html>