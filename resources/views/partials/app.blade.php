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
    
   <!-- Font Awesome for icons -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
   <!-- Google Fonts -->
   <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
   <!-- Bootstrap CSS -->
   <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
   <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script> 

    <style>
        body {
            font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Oxygen-Sans, Ubuntu, Cantarell, "Helvetica Neue", sans-serif;
            margin: 20px;
        }
        
        .add-money-btn {
            background-color: #4CAF50;
            color: white;
            border: none;
            border-radius: 5px;
            padding: 10px 20px;
            font-size: 16px;
            cursor: pointer;
        }
        
        .add-money-btn:hover {
            background-color: #3e8e41;
        }
        
        .popup-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
            display: none;
            justify-content: center;
            align-items: center;
            z-index: 1000;
        }
        
        .popup-container {
            background-color: white;
            border-radius: 5px;
            width: 100%;
            max-width: 650px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
            position: relative;
        }
        
        .popup-header {
            padding: 20px 25px;
            border-bottom: 1px solid #eee;
            position: relative;
        }
        
        .popup-header h2 {
            margin: 0;
            font-size: 24px;
            font-weight: 400;
        }
        
        .close-btn {
            position: absolute;
            right: 20px;
            top: 20px;
            background: none;
            border: none;
            font-size: 20px;
            cursor: pointer;
            width: 30px;
            height: 30px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        
        .close-btn:hover {
            background-color: #f5f5f5;
        }
        
        .notice-box {
            background-color: #fdc3c3;
            padding: 10px 20px;
            margin: 15px 25px;
            border-radius: 5px;
            display: flex;
            align-items: center;
        }
        
        .notice-box .info-icon {
            margin-right: 10px;
            color: #812626;
        }
        
        .notice-box p {
            margin: 0;
            font-size: 14px;
            color: #333;
        }
        
        .popup-body {
            padding: 0 25px 25px;
        }
        
        .image-upload-container {
            background-color: #f0f8f0;
            padding: 25px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            border-radius: 5px;
            margin-bottom: 20px;
        }
        
        .image-preview-container {
            width: 70px;
            height: 70px;
            border: 1px dashed #ccc;
            border-radius: 5px;
            display: flex;
            align-items: center;
            justify-content: center;
            overflow: hidden;
            background-size: cover;
            background-position: center;
        }
        
        .camera-icon {
            font-size: 26px;
            color: #666;
        }
        
        .upload-btn {
            background-color: #4CAF50;
            color: white;
            border: none;
            border-radius: 5px;
            padding: 8px 15px;
            cursor: pointer;
            font-size: 14px;
        }
        
        .upload-btn:hover {
            background-color: #3e8e41;
        }
        
        .form-group {
            margin-bottom: 20px;
        }
        
        .form-label {
            display: block;
            margin-bottom: 8px;
            font-size: 15px;
            color: #555;
        }
        
        .form-control {
            width: 100%;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 5px;
            font-size: 14px;
        }
        
        .form-control:focus {
            outline: none;
            border-color: #4CAF50;
        }
        
        .currency-target-container {
            display: flex;
            gap: 15px;
        }
        
        .currency-container, .target-container {
            flex: 1;
        }
        
        .checkbox-container {
            margin-top: 10px;
            display: flex;
            align-items: flex-start;
        }
        
        .checkbox-container input {
            margin-top: 3px;
            margin-right: 10px;
        }
        
        .checkbox-container label {
            font-size: 14px;
            color: #555;
            line-height: 1.4;
        }
        
        .save-btn {
            background-color: #4CAF50;
            color: white;
            border: none;
            border-radius: 5px;
            padding: 12px;
            width: 100%;
            cursor: pointer;
            font-size: 16px;
            margin-top: 15px;
        }
        
        .save-btn:hover {
            background-color: #3e8e41;
        }
        
        #actualFileInput {
            display: none;
        }
        
        textarea.form-control {
            min-height: 100px;
            resize: vertical;
        }
        
        </style>
        
</head>

<body>
    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg navbar-light sticky-top">
        <div class="container">
            <a class="navbar-brand" href="/">
                <img src="{{ asset('images/logo.png') }}" alt="MyWishList.ng Logo">
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto me-4">
                    <li class="nav-item">
                        <a class="nav-link" href="{{url('/')}}">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{route('about')}}">About Us</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('contact')}}">Contact</a>
                    </li>
                </ul>
                
                <div class="d-flex">
                    @auth
                    <!-- Show if user is logged in -->
                    <a href="{{ route('dashboard') }}" class="btn btn-outline-success me-2">My Account</a>
                    <form action="{{ route('logout') }}" method="POST" style="display: inline;" id="signoutForm">
                        @csrf
                        <button type="submit" id="signoutButton" class="btn btn-success">Logout</button>
                    </form>
                @else
                    <!-- Show if user is NOT logged in -->
                    <a href="{{ route('login') }}" class="btn btn-success me-2" id="login">Login</a>
                    <a href="{{ route('register') }}" class="btn btn-outline-success" id="register">Register</a>
                @endauth
                </div>
            </div>
        </div>
    </nav>
    @yield('content')

   
    <!-- Footer -->
    <!-- CTA Section -->
    <section class="cta-section">
        <div class="container">
            <h1 class="cta-heading">Create, Share, and Manage<br>Your Perfect Wishlist</h1>
            <a href="{{ route('create.wishlist')}}" class="create-btn">Create Wishlist</a>
        </div>
    </section>

    <!-- Footer Section -->
    <footer class="footer">
        <div class="footer-content">
            <div class="copyright">
                Copyright © 2025, All rights reserved
            </div>
            <div class="social-icons">
                <a href="#" class="social-icon"><i class="fab fa-facebook-f"></i></a>
                <a href="#" class="social-icon"><i class="fab fa-twitter"></i></a>
                <a href="#" class="social-icon"><i class="fab fa-instagram"></i></a>
            </div>
        </div>
    </footer>

  
      <!-- Bootstrap JS Bundle with Popper -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
    <script src="{{asset('js/script.js')}}"></script> 
     <script>
        document.getElementById('signoutButton').addEventListener('click', function(event) {
                event.preventDefault(); // Prevent the default button action
                Swal.fire({
                    title: 'Are you sure?',
                    text: "Do you want to logout?",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, logout!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        document.getElementById('signoutForm').submit();
                    }
            });
        });

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
               const tabs = document.querySelectorAll('.tab');
               
               tabs.forEach(tab => {
                   tab.addEventListener('click', function() {
                       // Remove active class from all tabs
                       tabs.forEach(t => t.classList.remove('active'));
                       
                       // Add active class to clicked tab
                       this.classList.add('active');
                       
                       // Hide all content sections
                       document.getElementById('items-content').style.display = 'none';
                       document.getElementById('money-content').style.display = 'none';
                       document.getElementById('gift-idea-content').style.display = 'none';
                       document.getElementById('share-content').style.display = 'none';
                       
                       // Show the selected content section
                       const tabName = this.getAttribute('data-tab');
                       document.getElementById(tabName + '-content').style.display = 'block';
                   });
               });
               
               // Show the Items tab by default
               document.getElementById('items-content').style.display = 'block';
           });
       </script>
   
  </body>
  </html>