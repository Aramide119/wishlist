@extends('partials.app')
@section('content')
    <!-- Wishlist Main body Section -->
    
    <section class="create-wishlist">
        <div class="container" style="padding-top: 50px;">
            <h2>Create wishlist</h2>
            <p class="subtitle">Simply add your favorite items from any online store and organize them in one convenient place</p>
            
            <div class="step-heading">Step 1: Create Wishlist: Give title to your list</div>
            
            <div class="wishlist-form">
                <div class="row">
                    <div class="col-md-4">
                        <div class="upload-area">
                            <div class="camera-icon">
                                <i class="fas fa-camera"></i>
                            </div>
                                    <form action="@if (isset($wishlist)){{route('upload.image', $wishlist->id )}}@endif " enctype='multipart/form-data' method="POST" id="uploadForm">
                                        @csrf
                                        <div class="media-upload-container">
                                            <input type="file" id="media-upload" name="image" class="media-input" accept="image/*,video/*"  onchange="document.getElementById('uploadForm').submit();" hidden>
                                            <label for="media-upload" class="upload-btn" style="display: none;">Upload</label>
                                            <div>
                                              <!-- Preview will be inserted here -->
                                              @if (isset($wishlist) && $wishlist->image)
                                              <!-- Clickable image -->
                                              <img src="{{ asset($wishlist->image) }}" 
                                                   alt="Uploaded Image" 
                                                   style=" cursor: pointer;" 
                                                   onclick="document.getElementById('media-upload').click();">
                                                @else
                                                    <div class="upload-text" 
                                                    style=" cursor: pointer;" onclick="document.getElementById('media-upload').click();">
                                                        Add image or video
                                                    </div>
                                                @endif
                                            </div>
                                          </div>
                                    </form>                         
                           
                        </div>
                    </div>
                    <div class="col-md-8">
                       
                        @if (isset($wishlist))
                            <div class="form-section">
                                <h2 class="form-label">{{$wishlist->title}} <i class="fas fa-edit edit-icon" id="openWishlistModal"></i></h2>
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
                                <i class="fas fa-edit edit-icon" id="openWishlistModalDate"></i>
                            </p>
                            @else
                            <p class="form-label">
                                <i class="fas fa-calendar"></i> Set date
                                <i class="fas fa-edit edit-icon" id="openWishlistModalDate"></i>
                            </p>
                            @endif

                        </div>
                        
                        <div class="form-section">
                            @if (isset($wishlist))
                            <p class="form-label">
                                <i class="fas fa-map-marker-alt location-icon"></i> {{$wishlist->addressLine1}}
                                <i class="fas fa-edit edit-icon" id="openWishlistModalAdd"></i>
                            </p>
                            @else
                            <p class="form-label">
                                <i class="fas fa-map-marker-alt location-icon"></i> Set location
                                <i class="fas fa-edit edit-icon" id="openWishlistModalAdd"></i>
                            </p>
                            @endif
                            
                        </div>
                        
                        <div class="form-section">
                            @if (isset($wishlist))
                            <p class="form-label">
                                <i class="fa-solid fa-note-sticky"></i> {{$wishlist->description}}
                                <i class="fas fa-edit edit-icon" id="openWishlistModalIntro"></i>
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

            <!-- Add wishlist popup form -->
            <!-- <button type="button" class="btn btn-primary" id="openWishlistModal">Create New Wishlist</button> -->

             <!-- The Modal -->
                <div class="modal fade" id="wishlistModal" tabindex="-1" aria-labelledby="wishlistModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="wishlistModalLabel">Add Wishlist</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <form id="wishlistForm" action="@if (isset($wishlist))
                                        {{route('update.wishlist', $wishlist->id)}}}
                                    @endif" enctype='multipart/form-data' method="POST">
                                        @csrf
                                        <div class="form-group mb-3">
                                        <label for="wishlistName">Wishlist Name</label>
                                        <input type="text" id="wishlistName" name="title" class="form-control" placeholder="e.g. My Birthday Wishlist" value="@if (isset($wishlist)) {{$wishlist->title}} @endif" required>
                                        </div>
                            
                                        <div class="form-group mb-3">
                                        <label for="setDate">Set Date</label>
                                        <input type="date" id="setDate" class="form-control" name="date" value="@if (isset($wishlist)) {{$wishlist->date}} @endif" required>
                                        </div>
                            
                                        <div class="form-group address-container mb-3">
                                        <label for="addressLine1">Address</label>
                                        <input type="text" id="addressLine1" class="form-control mb-2" placeholder="Street address" name="addressLine1" value="@if (isset($wishlist)) {{$wishlist->addressLine1}} @endif" required>
                                        
                                        <input type="text" id="addressLine2" class="form-control mb-2" placeholder="Apartment, suite, unit, building, floor, etc. (optional)" value="@if (isset($wishlist)) {{$wishlist->addressLine2}} @endif" name="addressLine2">
                                        
                                        <div class="row mb-2">
                                            <div class="col">
                                            <input type="text" id="city" class="form-control" placeholder="City" name="city" value="@if (isset($wishlist)) {{$wishlist->city}} @endif" required>
                                            </div>
                                            <div class="col">
                                            <input type="text" id="state" class="form-control" placeholder="State/Province" value="@if (isset($wishlist)) {{$wishlist->state}} @endif" name="state" required>
                                            </div>
                                        </div>
                                        
                                        <div class="row">
                                            <div class="col">
                                            <input type="text" id="postalCode" class="form-control" placeholder="Postal/ZIP code" name="postal" value="@if (isset($wishlist)) {{$wishlist->postal}} @endif" required>
                                            </div>
                                            <div class="col">
                                            <input type="text" id="country" class="form-control" placeholder="Country" name="country" value="@if (isset($wishlist)) {{$wishlist->country}} @endif" required>
                                            </div>
                                        </div>
                                        </div>
                                        
                                        <div class="form-group mb-3">
                                        <label for="listDescription">Introduction</label>
                                        <textarea id="listDescription" name="description" class="form-control" rows="4" placeholder="Introduce your list...">@if (isset($wishlist)) {{$wishlist->description}} @endif</textarea>
                                        </div>

                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" style="background-color: #EA4335;" data-bs-dismiss="modal">Close</button>
                                            <button class="btn btn-primary" id="submitWishlist" style="background-color: #2D8C40;">Create Wishlist</button>
                                        </div>
                                    </form>
                                </div>

                        
                    </div>
                    </div>
                </div>
            
            <div class="step-heading">Step 2: Add item to list</div>
            
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
                            <div class="item-actions">
                                <button 
                                    class="editModalBtn action-btn"
                                    data-id="{{ $item->id }}"
                                    data-name="{{ $item->name }}"
                                    data-website_link="{{ $item->website_link }}"
                                    data-note="{{ $item->note }}"
                                    data-price="{{ $item->price }}"
                                    data-quantity="{{ $item->quantity }}"
                                    data-image="{{ asset($item->image) }}"
                                >
                                    <i class="fas fa-edit"></i>
                                </button>

                                <form action="{{ route('items.destroy', $item->id) }}" method="POST" style="display: inline;">
                                    @csrf
                                    @method('DELETE')
                                <button class="action-btn"><i class="fas fa-trash"></i></button>
                                  </form>
                            </div>
                            {{-- <div class="item-actions">
                                <!-- Trigger modal -->
                                <button type="button" data-bs-toggle="modal" data-bs-target="#editModal-{{ $item->id }}">
                                    <i class="fas fa-edit"></i>
                                </button>

                                <!-- Delete button (optional) -->
                                <form action="{{ route('items.destroy', $item->id) }}" method="POST" style="display: inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"><i class="fas fa-trash"></i></button>
                                </form>
                            </div> --}}
                        </div>

                    @endforeach

                @endif
                
                
                <!-- Add new item button -->
                <div class="add-item-container">
                    <div class="add-item-icon">
                        <i class="fas fa-plus-circle"></i>
                    </div>
                    <p class="add-item-text">Add items from any online store</p>
                    <button class="add-item-btn" id="openModalBtn">Add Item</button>
                </div>
            </div>

            <!-- Add new Item form popup -->
              <!-- Create List Form Section -->
                <section class="create-list-section">
                    <div class="container" id="formModal">
                        <div class="form-wrapper">
                            <span class="close-btn">&times;</span>
                            <h1 class="section-title">Add an item</h1>
                            <p class="section-subtitle">Fill in the details below to create your personalized wishlist item</p>
                            
                            <form action="{{route('create.item')}}" id="createListForm" class="modal-content" method="POST" enctype="multipart/form-data">
                                @csrf
                                <div class="form-group">
                                    <label>Item Cover Image</label>
                                    <div class="file-upload">
                                        <input type="file" id="coverImage" accept="image/*" name="image">
                                        <i class="fas fa-cloud-upload-alt"></i>
                                        <p>Click or drag an image here to upload</p>
                                    </div>
                                    <p class="form-text">Recommended size: 800x600px. Max file size: 2MB</p>
                                    <div class="upload-preview" id="imagePreview">
                                        No image selected
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="listTitle">Item Name</label>
                                    <input type="text" id="name" name="name" class="form-control" placeholder="e.g. Chocolates" required>
                                </div>

                                <div class="form-group">
                                    <label for="listTitle">Website Link</label>
                                    <input type="text" id="website_link" name="website_link" class="form-control" placeholder="e.g. https://" required>
                                </div>
                                
                                <div class="form-group">
                                    <label for="listDescription">Note</label>
                                    <textarea id="note" name="note" class="form-control" rows="4" placeholder="Add description..."></textarea>
                                </div>
                                
                                <div class="form-row">
                                    <div class="form-col">
                                        <div class="form-group">
                                            <label for="itemPrice">Price</label>
                                            <input type="number" id="price" class="form-control" placeholder="e.g. ₦50,000" name="price" required>
                                        </div>
                                    </div>
                                    <div class="form-col">
                                        <div class="form-group">
                                            <label for="itemQuantity">Quantity</label>
                                            <input type="number" id="quantity" class="form-control" placeholder="e.g. 5" name="quantity" required>
                                        </div>
                                    </div>
                                </div>

                                    <div class="form-col">
                                        <div class="form-group">
                                            <label for="itemCategory">Category</label>
                                            <select class="form-select" id="itemCategory" name="category">
                                                <option selected> </option>
                                                <option value="1">Create new category</option>
                                                <option value="2">None</option>
                                                <!-- <option value="">add more values</option> -->
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-col">
                                        <div class="form-group">
                                            <label for="newCategory">New category name</label>
                                            <input type="text" name="new_category" id="newCategory" class="form-control" placeholder="e.g. Books">
                                        </div>
                                    </div>
                                    <input type="hidden" id="itemId" name="id">
                                    <input type="hidden" name="wishlist_id" value="@if (isset($wishlist)) {{$wishlist->id}} @endif">
                                <div class="submit-wrapper">
                                    <button type="submit" class="btn" >Add Item</button>
                                </div>
                                <button type="submit" class="form-submit" style="margin-top: 150px;"></button>

                            </form>
                        </div>
                    </div>
                </section>
            <!-- Add new Item form popup END -->
            
        <!-- Money Tab Content -->
        <div id="money-content" class="money-container">
            <!-- Sample item -->
            @if (isset($money))
                @foreach ($money as $item)
                    <div class="item-card">
                        <div class="item-image">
                            @if ($item->image)
                                <img src="{{ asset($item->image) }}" alt="">
                            @endif
                        </div>
                        <div class="item-details">
                            <h5 class="money-title">{{ $item->name }}</h5>
                            <p class="money-description">{{ $item->description }}</p>
                            <p class="money-price">₦{{ $item->target }}</p>
                        </div>
                        <div class="item-actions">
                            <form action="{{ route('money.destroy', $item->id) }}" method="POST" style="display: inline;">
                                @csrf
                                @method('DELETE')
                            <button class="action-btn"><i class="fas fa-trash"></i></button>
                              </form>
                        </div>
                        
                    </div>

                @endforeach

            @endif
            <div class="money-section">
                <i class="fa-solid fa-circle-info"></i><p class="add-item-text">All contributions to your Money Fund are held in wallet until you request a payout. You can initiate the payout anytime from your profile section</p>
                <button class="add-money-btn">Set up a MoneyFund</button>
            </div>
        </div>

        <!-- Setup MoneyFund popup -->

       <!-- Popup overlay -->
<div class="popup-overlay" id="moneyFundPopup">
    <div class="popup-container">
        <div class="popup-header">
            <h2>Set Up a Money Fund</h2>
            <button class="close-btn" id="closeBtn">✕</button>
        </div>
        
        <div class="notice-box">
            <div class="info-icon">ⓘ</div>
            <p>A processing fee of 3.9% applies to all contributions.</p>
        </div>
        
        <div class="popup-body">
           
            
            
            <form id="moneyFundForm" action="{{route('create.money')}}" enctype="multipart/form-data" method="POST">
                @csrf
                <input type="hidden" name="wishlist_id" value="@if (isset($wishlist)) {{$wishlist->id}} @endif">
                <div class="image-upload-container">
                    <div class="image-preview-container" id="moneyimagePreview">
                        <div class="camera-icon">📷</div>
                    </div>
                    <button class="upload-btn" id="uploadBtn2" type="button">Upload</button>
                    <input type="file" name="image" id="actualFileInput" accept="image/*">
                </div>
                <div class="form-group">
                    <label for="name" class="form-label">Name</label>
                    <input type="text" name="name" id="name" class="form-control" placeholder="Enter full name" required>
                </div>
                
                <div class="form-group">
                    <label for="description" class="form-label">Description</label>
                    <textarea id="description" name="description" class="form-control" placeholder="Add description"></textarea>
                </div>
                
                <div class="currency-target-container">
                    <div class="currency-container form-group">
                        <label for="currency" class="form-label">Currency</label>
                        <select id="currency" class="form-control">
                            <option value="NGN">NGN</option>
                        </select>
                    </div>
                    
                    <div class="target-container form-group">
                        <label for="target" class="form-label">Target</label>
                        <input type="text" name="target" id="target" class="form-control" placeholder="e.g 10000.00" required>
                    </div>
                </div>
                
                <div class="checkbox-container">
                    <input type="checkbox" id="termsCheckbox" required>
                    <label for="termsCheckbox">I agree to the Terms of Service and acknowledge that my payment will be processed immediately and is non-refundable.</label>
                </div>
                
                <button type="submit" class="save-btn">Save Changes</button>
            </form>
        </div>
    </div>
</div>
            
            <!-- Gift Idea Tab Content -->
            <div id="gift-idea-content" class="gift-idea-container">
                <div class="add-item-icon">
                    <i class="fas fa-gift"></i>
                </div>
                <p class="add-item-text">Suggest gift ideas for your friends and family</p>
                <button type="button" class="add-item-btn" data-bs-toggle="modal" data-bs-target="#giftIdeasModal">
                    Add Gift Ideas
                </button>
            </div>
            
            <!-- Modal -->
            <div class="modal fade" id="giftIdeasModal" tabindex="-1" aria-labelledby="giftIdeasModalLabel" aria-hidden="true">
              <div class="modal-dialog">
                <div class="modal-content">
                  
                  <div class="modal-header">
                    <h5 class="modal-title" id="giftIdeasModalLabel">Generate Gift Ideas</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                  </div>
            
                  <div class="modal-body">
                    <!-- Gift Ideas Form -->
                    <form id="giftIdeasForm">
                        <div class="mb-3">
                            <label for="genderSelect" class="form-label">Select Gender</label>
                            <select id="genderSelect" class="form-control">
                                <option value="female">Female</option>
                                <option value="male">Male</option>
                                <option value="non-binary">Non-binary</option>
                            </select>
                        </div>
            
                        <div class="mb-3">
                            <label for="occasionInput" class="form-label">Enter Occasion</label>
                            <input type="text" id="occasionInput" class="form-control" placeholder="e.g. Birthday, Graduation" required>
                        </div>
            
                        <button type="button" id="generateGiftIdeasBtn" class="btn btn-primary w-100">
                            Generate Gift Ideas
                        </button>
                    </form>
            
                    <div id="giftIdeasContainer" class="mt-3"></div>
                  </div>
            
                </div>
              </div>
            </div>
            
            <!-- Share Tab Content -->
            <div id="share-content" class="share-container">
                <!-- <div class="add-item-icon">
                    <i class="fas fa-share-alt"></i>
                </div>
                <p class="add-item-text">Share your wishlist with friends and family</p>
                <button class="add-item-btn">Share Wishlist</button> -->
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