<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="{{ asset('logo.png') }}" type="image/x-icon">
    <title>MyWishList.ng - Make a Wish, Get It Delivered</title>
    <!-- External css file-->
    <link rel="stylesheet" href="{{ asset ('css/style.css')}}" link>
    <!-- Font Awesome for icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script> 

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
                    <a href="{{ route('dashboard') }}" class="btn btn-outline-success me-2" id="myAccount">My Account</a>
                    <form action="{{ route('logout') }}" method="POST" style="display: inline;" id="signoutForm">
                        @csrf
                        <button type="submit" id="signoutButton" class="btn btn-success">Logout</button>
                    </form>
                @else
                    <!-- Show if user is NOT logged in -->
                    <a href="{{ route('login') }}" class="btn btn-success me-2" id="login">Login</a>
                    <a href="{{ url('/register') }}" class="btn btn-outline-success" id="register">Register</a>
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

            // Make sure Bootstrap JS is loaded and initialized properly
            document.addEventListener('DOMContentLoaded', function() {
                // Initialize all accordions
                var accordionButtons = document.querySelectorAll('.accordion-button');
                
                accordionButtons.forEach(function(button) {
                    button.addEventListener('click', function() {
                        // Toggle the expanded state
                        var expanded = this.getAttribute('aria-expanded') === 'true';
                        this.setAttribute('aria-expanded', !expanded);
                        
                        // Find the target collapse element
                        var targetId = this.getAttribute('data-bs-target').replace('#', '');
                        var targetCollapse = document.getElementById(targetId);
                        
                        if (targetCollapse) {
                            // Toggle the show class
                            if (expanded) {
                                targetCollapse.classList.remove('show');
                            } else {
                                targetCollapse.classList.add('show');
                            }
                        }
                    });
                });
            });
        </script>
</body>
</html>