@extends('partials.home')
@section('content')
<div class="contact-container">
    <div class="row g-4">
        <!-- Left column - Contact information -->
        <div class="col-lg-6 col-md-12 contact-details">
            <h1 class="mb-4">Contact Us</h1>
            <p class="mb-4">We'd love to hear from you! Whether you have questions, need assistance, or simply want to share feedback, reach out to us</p>
            
            <!-- Address -->
            <div class="contact-info-item">
                <div class="contact-icon">
                    <i class="fas fa-map-marker-alt"></i>
                </div>
                <div class="contact-info-text">
                    <h5 class="mb-1">Address</h5>
                    <p class="mb-0">223A Red Street, Bungalows, Jakande<br>LCHE, Isolo, Lagos.</p>
                </div>
            </div>
            
            <!-- Phone -->
            <div class="contact-info-item">
                <div class="contact-icon">
                    <i class="fas fa-phone-alt"></i>
                </div>
                <div class="contact-info-text">
                    <h5 class="mb-1">Phone</h5>
                    <p class="mb-0">+234-705-9987836</p>
                </div>
            </div>
            
            <!-- Email -->
            <div class="contact-info-item">
                <div class="contact-icon">
                    <i class="fas fa-envelope"></i>
                </div>
                <div class="contact-info-text">
                    <h5 class="mb-1">Email</h5>
                    <p class="mb-0">contact@wishlist.ng</p>
                </div>
            </div>
        </div>
        
        <!-- Right column - Contact form -->
        <div class="col-lg-6 col-md-12">
            <div class="contact-form">
                <h2>Send Message</h2>
                 {!! session('message') !!}
                <form action="{{route('contact.us')}}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label for="name" class="form-label">Name</label>
                        <input type="text" class="form-control" id="name" placeholder="Enter full name" name="name">
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label">Email address</label>
                        <input type="email" class="form-control" id="email" placeholder="Enter email address" name="email">
                    </div>
                    <div class="mb-3">
                        <label for="message" class="form-label">Text your message</label>
                        <textarea class="form-control" id="message" rows="5" name="message"></textarea>
                    </div>
                    <button type="submit"  id="contact-btn" class="btn btn-send">Send message</button>
                </form>
            </div>
        </div>
    </div>
    <div class="row mt-5">
        <div class="col-12">
            <div class="second-section-image-wrapper">
                <img src="{{ asset ('images/Banner-Image.png')}}" alt="Birthday celebration with family and friends" class="second-section-image">
            </div>
        </div>
    </div>
</div>
@endsection