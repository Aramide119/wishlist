@extends('partials.app')
@section('content')
    <!-- Wishlist Main body Section -->
    
    <section class="create-wishlist">
        <div class="container" style="padding-top: 50px;">
            <h2>{{$wishlist->title}} </h2>
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
                                <!-- Clickable image -->
                                <img src="{{ asset($wishlist->image) }}">
                                @else
                                    <div class="upload-text" 
                                    style=" cursor: pointer;" onclick="document.getElementById('media-upload').click();">
                                        Add image or video
                                    </div>
                                @endif
                                            
                            </div>
                        </div>
                    </div>
                    <div class="col-md-8">
                       
                        @if (isset($wishlist))
                            <div class="form-section">
                                <h2 class="form-label">{{$wishlist->title}} </h2>
                            </div>
                        @else 
                            <div class="form-section">
                                <h2 class="form-label">Title (Wishlist Heading) <i class="fas fa-edit edit-icon" id="openWishlistModal"></i></h2>
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
                            </p>
                            @endif
                            
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="tabs">
                <div class="tab active" data-tab="items">Items</div>
                <div class="tab" data-tab="money">Money</div>
                <div class="tab" data-tab="gift-idea">Gift idea</div>
                <div class="tab" data-tab="share">Share</div>
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
                        </div>

                    @endforeach

                @endif
                
                

            </div>

            
        <!-- Money Tab Content -->
        <div id="money-content" class="money-container">
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
                            </div>
        
                        @endforeach
        
                    @endif
        </div>


            
            <!-- Gift Idea Tab Content -->
            <div id="gift-idea-content" class="gift-idea-container">

            </div>
            
            <!-- Share Tab Content -->
            <div id="share-content" class="share-container">

                <section class="sharing-section">
                    <div class="container text-center">
                        <h3>Share Your Wishlist</h3>
                        <p class="mb-4">Share your wishlist with friends and family so they can contribute to your gifts</p>
                        
                        <div class="input-group mb-3 mx-auto" style="max-width: 500px;">
                            <input type="text" class="form-control" value="@if (isset($wishlist)) {{ url('/wishlist/' . $wishlist->slug) }} @endif" id="shareLink" readonly>
                            <button class="btn btn-primary" type="button" onclick="copyShareLink()">
                                <i class="fas fa-copy"></i> Copy
                            </button>
                        </div>
                        
                        <div class="social-share">
                            <a href="#" class="facebook">
                                <i class="fab fa-facebook-f"></i>
                            </a>
                            <a href="#" class="twitter">
                                <i class="fab fa-twitter"></i>
                            </a>
                            <a href="#" class="whatsapp">
                                <i class="fab fa-whatsapp"></i>
                            </a>
                            <a href="#" class="telegram">
                                <i class="fab fa-telegram-plane"></i>
                            </a>
                            <a href="#" class="email">
                                <i class="fas fa-envelope"></i>
                            </a>
                                        </div>
                                    </div>
                                </section>
                                </div>
                            </div>
                </section>
  
@endsection