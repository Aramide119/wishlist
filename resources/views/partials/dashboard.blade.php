<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>My Wishlist</title>
    <link rel="shortcut icon" href="{{ asset('logo.png') }}" type="image/x-icon">
    <!-- external CSS -->
    <link href="{{asset('css/wishlist.css')}}" rel="stylesheet">
    <link href="{{asset('css/create-list.css')}}" rel="stylesheet">
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        html, body {
          height: auto !important;
          min-height: 100%;
          overflow-x: hidden;
          overflow-y: auto;
        }
        #profile{
            margin-top: 70px;
        }
        #app{
            margin-bottom: 50px;
        }
      </style>
      

</head>
<body class="min-h-screen">
    <div id="app" class="min-h-screen flex flex-col">
        <nav class="bg-white shadow-md fixed w-full top-0 z-50">
            <div class="max-w-7xl mx-auto px-4 py-3 flex justify-between items-center">
            <!-- Logo -->
            <a href="/" class="flex items-center">
            <img src="{{ asset('images/logo.png') }}" alt="Logo" class="h-8">
            
                
                
            </a>
        
            <!-- Hamburger Icon for Mobile -->
            <button id="nav-toggle" class="md:hidden text-gray-700 focus:outline-none">
                <i class="fas fa-bars text-2xl"></i>
              </button>
        
            <!-- Navigation Links -->
            <div id="nav-menu" class="hidden md:flex flex-col md:flex-row md:space-x-6 mt-3 md:mt-0 items-start md:items-center">
                <a href="{{url('/')}}" class="text-gray-700 hover:text-green-600 block py-2">Home</a>
                <a href="{{route('about')}}" class="text-gray-700 hover:text-green-600 block py-2">About us</a>
        
                <!-- Dropdown -->
                <div class="relative w-full md:w-auto">
                <button id="userDropdownButton" class="text-gray-700 hover:text-green-600 focus:outline-none w-full md:w-auto flex justify-between items-center py-2">
                    @if (isset($user)){{ $user->first_name }} {{ $user->last_name }} @endif
                    <i class="fas fa-chevron-down ml-2 text-sm"></i>
                </button>
                <div id="userDropdown" class="hidden absolute right-0 mt-2 bg-white shadow-md rounded w-40 z-50">
                    <a href="#" class="block px-4 py-2 text-sm hover:bg-gray-100">Profile</a>
                    <form action="{{ route('logout') }}" method="POST" id="signoutForm">
                    @csrf
                    <button type="submit" id="signoutButton" class="w-full text-left px-4 py-2 text-sm hover:bg-gray-100">Logout</button>
                    </form>
                    
                </div>
                </div>
            </div>
            </div>
        </nav>
        
        

        @yield('content')
    </div>
      <!-- Bootstrap JS -->
      <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
      <!-- Bootstrap JS Bundle with Popper -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
    <script src="{{asset('js/dashboard.js')}}"></script> 
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
    </script>
        <script>            
           
        document.addEventListener('DOMContentLoaded', function() {
            // Password change toggle
            const changePasswordToggle = document.getElementById('change-password-toggle');
            const passwordFields = document.getElementById('password-fields');
            
            if (changePasswordToggle) {
                changePasswordToggle.addEventListener('change', function() {
                    passwordFields.classList.toggle('hidden', !this.checked);
                });
            }
            
            // Password visibility toggles
            const toggleButtons = document.querySelectorAll('.toggle-password');
            
            toggleButtons.forEach(button => {
                button.addEventListener('click', function() {
                    const targetId = this.getAttribute('data-target');
                    const passwordInput = document.getElementById(targetId);
                    const icon = this.querySelector('i');
                    
                    // Toggle password visibility
                    if (passwordInput.type === 'password') {
                        passwordInput.type = 'text';
                        icon.classList.remove('fa-eye-slash');
                        icon.classList.add('fa-eye');
                    } else {
                        passwordInput.type = 'password';
                        icon.classList.remove('fa-eye');
                        icon.classList.add('fa-eye-slash');
                    }
                });
            });
        });

        </script>
  </body>
  </html>