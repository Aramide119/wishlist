<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Wishlist</title>
    <link rel="shortcut icon" href="{{ asset('logo.png') }}" type="image/x-icon">
    <!-- external CSS -->
    <link href="{{asset('css/wishlist.css')}}" rel="stylesheet">
    <link href="{{asset('css/create-list.css')}}" rel="stylesheet">
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <meta name="csrf-token" content="{{ csrf_token() }}">

</head>
<body>
    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg navbar-light">
        <div class="container">
            <a class="navbar-brand" href="/">
                <img src="{{asset('images/logo.png')}}" alt="MyWishList.ng Logo">
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
                    <a href="{{route('dashboard')}}" class="btn btn-outline-success me-2" id="myAccount">Create Account</a>
                </div>
            </div>
        </div>
    </nav>
    <!-- Wishlist Main body Section -->
    
    <section class="create-wishlist">
        <div class="container" style="padding-top: 50px;">
            <div class="wishlist-form">
                <div class="row">
                    <div class="col-md-4">
                        <div class="upload-area">
                            <div class="camera-icon">
                                <i class="fas fa-camera"></i>
                            </div>

                            <div>
                                <!-- Preview will be inserted here -->
                                @if (isset($wishlist) && $wishlist->image)
                                <img src="{{ asset($wishlist->image) }}">
                                @else
                                <img src="{{ asset('images/wishlist.jpg') }}">
                                @endif
                                            
                            </div>
                        </div>
                    </div>
                    <div class="col-md-8">
                       
                        @if (isset($wishlist))
                            <div class="form-section">
                                <h2 class="form-label">{{$wishlist->title}}</h2>
                            </div>
                        @else 
                            <div class="form-section">
                                <h2 class="form-label">Title (Wishlist Heading)</h2>
                            </div>
                        @endif
                        <div class="form-section">
                            @if (isset($wishlist))
                            <p class="form-label">
                                <i class="fas fa-calendar"></i> {{$wishlist->date}}
                            </p>
                            @else
                            <p class="form-label">
                                <i class="fas fa-calendar"></i> Set date
                            </p>
                            @endif

                        </div>
                        
                        <div class="form-section">
                            @if (isset($wishlist))
                            <p class="form-label">
                                <i class="fas fa-map-marker-alt location-icon"></i> {{$wishlist->addressLine1}}
                            </p>
                            @else
                            <p class="form-label">
                                <i class="fas fa-map-marker-alt location-icon"></i> Set location
                            </p>
                            @endif
                            
                        </div>
                        
                        <div class="form-section">
                            @if (isset($wishlist))
                            <p class="form-label">
                                <i class="fa-solid fa-note-sticky"></i> {{$wishlist->description}}
                            </p>
                            @else
                            <p class="form-label">
                                <i class="fas fa-map-marker-alt intro-icon"></i> Introduce your list
                                <i class="fas fa-edit edit-icon" id="openWishlistModalIntro"></i>
                            </p>
                            @endif
                            
                        </div>
                    </div>
                </div>
            </div>         
            
            <div class="tabs">
                <div class="tab active" data-tab="items">Items</div>
            </div>
            
            <!-- Items Tab Content -->
            <div id="items-content" class="item-section">
                <!-- Sample item -->
                @if (isset($items))
                    @foreach ($items as $item)
                        <div class="item-card">
                            <div class="item-image">
                                @if ($item->image)
                                    <img src="{{ asset($item->image) }}" alt="">
                                @endif
                            </div>
                            <div class="item-details">
                                <h5 class="item-title">{{ $item->name }}</h5>
                                <p class="item-description">{{ $item->note }}</p>
                                <p class="item-price">₦{{ $item->price }}</p>
                            </div>
                            <div class="item-actions">
                                @php
                                    $totalQuantity = $item->quantity;
                                    $reservedQuantity = $item->reservations()->sum('quantity');
                                    $available = $totalQuantity - $reservedQuantity;
                                @endphp

                                @if($available <= 0)
                                    <button disabled class="btn btn-secondary">Reserved</button>
                                @else
                                    <button 
                                        class="btn btn-outline-success reserveBtn"
                                        data-bs-toggle="modal"
                                        data-bs-target="#reserveModal"
                                        data-id="{{$item->id}}"
                                        data-name="{{$item->name}}"
                                        data-description="{{$item->note}}"
                                        data-link="{{$item->website_link}}"
                                        >
                                        Reserve ({{ $available }} left)
                                    </button>
                                @endif
                            </div>
                        </div>
                        
                    
                    @endforeach
                @endif

                            <!-- Sample item -->
            @if (isset($money))
            @foreach ($money as $item)
                <div class="money-card">
                    <div class="money-image">
                        @if ($item->image)
                            <img src="{{ asset($item->image) }}" alt="">
                        @endif
                    </div>
                    <div class="money-details">
                        <h5 class="money-title">{{ $item->name }}</h5>
                        <p class="money-description">{{ $item->description }}</p>
                        <p class="money-price">₦{{ $item->target }}</p>
                    </div>
                    <div class="money-actions">
                            <button type="button" class="action-btn btn btn-outline-success"
                            data-bs-toggle="modal"
                            data-bs-target="#paymentModal"
                            data-id="{{ $item->id }}"
                            data-name="{{ $item->name }}"
                            data-description="{{ $item->description }}"
                            data-target="{{ $item->target }}">
                            Pay
                    </button>
                    </div>
                    
                </div>

            @endforeach

            @endif
            </div>  
            </section>


        <!-- Modal -->
        <div class="modal fade" id="reserveModal" tabindex="-1" aria-labelledby="reserveModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content p-3">
            <div class="modal-header border-0">
                <h5 class="modal-title" id="reserveModalLabel">Reserve item</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body">
                <h6 id="modalItemName" class="mb-1">Item Name Here</h6>
                <p class="text-muted" id="modalItemDescription">Item description goes here.</p>
                <a href="#" id="modalItemLink" target="_blank" class="d-block mb-3" style="text-decoration:none; color:#2e7d32">Link</a>

                <div class="alert alert-warning small" role="alert">
                <i class="fas fa-exclamation-circle me-2"></i>
                Once you reserve this item, others will see it as unavailable. If it’s something physical, you’ll need to buy it on your own.
                </div>
                <input type="hidden" id="itemIdInput" name="item_id">

                <div class="mb-3">
                <input type="text" class="form-control" placeholder="Your Name" id="nameInput">
                <small class="text-muted">Input your name so they know who paid</small>
                </div>

                <div class="mb-3">
                <input type="email" class="form-control" placeholder="Email address" id="emailInput">
                </div>

                <div class="mb-3">
                <input type="number" class="form-control" placeholder="Quantity" id="quantityInput">
                </div>

                <div class="form-check mb-3">
                <input class="form-check-input" type="checkbox" id="termsCheck">
                <label class="form-check-label small" for="termsCheck">
                    I agree to the Terms of Service and acknowledge that my payment will be processed immediately and is non-refundable.
                </label>
                </div>

                <button id="submitReservation" class="btn btn-success w-100">Confirm</button>
            </div>
            </div>
        </div>
        </div>

        <!-- Payment Modal -->
        <div class="modal fade" id="paymentModal" tabindex="-1" aria-labelledby="paymentModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content p-3">
                <div class="modal-header border-0">
                <h5 class="modal-title" id="paymentModalLabel">Make a Payment</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="donationForm" method="POST" action="{{ route('donate.initiate') }}">
                    @csrf
                <div class="modal-body">
                <h6 id="paymentItemName" class="mb-1">Item Name</h6>
                <p class="text-muted" id="paymentItemDescription">Item Description</p>
                <p class="fw-bold">Amount Goal: ₦<span id="paymentTargetAmount"></span></p>
        
                <input type="hidden" name="money_id" id="paymentItemId">
                <div class="mb-3">
                    <input type="text" name="name" class="form-control" id="payerName" placeholder="Your Name" required>
                </div>
                <div class="mb-3">
                    <input type="email" name="email" class="form-control" id="payerEmail" placeholder="Email Address" required>
                </div>
                <div class="mb-3">
                    <textarea class="form-control" name="note" id="payerNote" rows="2" placeholder="Note (optional)"></textarea>
                </div>
                <div class="mb-3">
                    <input type="number" name="amount" class="form-control" id="payerAmount" placeholder="Amount to Give (₦)" required>
                </div>
        
                <button type="submit" class="btn btn-success w-100" id="confirmPaymentBtn">Confirm & Pay</button>
                </div>
                </form>
            </div>
            </div>
        </div>
  
                <!-- Bootstrap JS Bundle with Popper -->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
        <script>
            document.addEventListener("DOMContentLoaded", function () {
                // Reserve Modal
                const reserveModal = document.getElementById('reserveModal');
                reserveModal.addEventListener('show.bs.modal', function (event) {
                    const button = event.relatedTarget;
        
                    const name = button.getAttribute('data-name');
                    const description = button.getAttribute('data-description');
                    const link = button.getAttribute('data-link');
                    const itemId = button.getAttribute('data-id');
        
                    document.getElementById('itemIdInput').value = itemId;
                    reserveModal.querySelector('#modalItemName').textContent = name;
                    reserveModal.querySelector('#modalItemDescription').textContent = description;
                    reserveModal.querySelector('#modalItemLink').textContent = link;
                    reserveModal.querySelector('#modalItemLink').href = link;
                });
        
                // Payment Modal
                const paymentModal = document.getElementById('paymentModal');
                paymentModal.addEventListener('show.bs.modal', function (event) {
                    const button = event.relatedTarget;
        
                    const name = button.getAttribute('data-name');
                    const description = button.getAttribute('data-description');
                    const target = button.getAttribute('data-target');
                    const id = button.getAttribute('data-id');
        
                    console.log("Modal triggered with:", { name, description, target, id }); // Debug log
        
                    document.getElementById('paymentItemId').value = id;
                    paymentModal.querySelector('#paymentItemName').textContent = name;
                    paymentModal.querySelector('#paymentItemDescription').textContent = description;
                    paymentModal.querySelector('#paymentTargetAmount').textContent = target;
                });
        
                // Handle reservation confirmation
                document.getElementById('submitReservation').addEventListener('click', function () {
                    fetch('/reservations', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                        },
                        body: JSON.stringify({
                            name: document.getElementById('nameInput').value,
                            email: document.getElementById('emailInput').value,
                            quantity: document.getElementById('quantityInput').value,
                            item_id: document.getElementById('itemIdInput').value,
                            accepted_terms: document.getElementById('termsCheck').checked ? 1 : 0
                        })
                    })
                    .then(res => res.text())
                     .then(data => {
                        location.reload();
                    })
                    .then(text => {
                        try {
                            const data = JSON.parse(text);
                            alert(data.message);
                            bootstrap.Modal.getInstance(document.getElementById('reserveModal')).hide();
                        } catch (err) {
                            console.error('Server response is not valid JSON:', text);
                        }
                    })
                    .catch(err => console.error('Error submitting reservation:', err));
                });
            });
        </script>
        


</body>