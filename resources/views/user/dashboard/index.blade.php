@extends('partials.dashboard')
@section('content')
    <!-- Wishlist Main body Section -->
    
    <section class="create-wishlist">
        <div class="container" style="padding-top: 50px;">

            <div class="bg-white shadow-md rounded-2xl p-6 flex flex-col md:flex-row justify-between items-start md:items-center gap-4 mb-6" id="profile">
                <!-- Profile Left -->
                <div class="flex items-center gap-4">
                    @if ($user->profile_picture)
                        <img src="{{ asset('user/image/'.$user->profile_picture ?? 'images/profile.jpg') }}" alt="Profile Image" class="w-16 h-16 rounded-full object-cover">
                        @else
                        <img src="{{ asset('images/profile.jpg') }}" alt="Profile Image" class="w-16 h-16 rounded-full object-cover">
                    @endif

                    <div>
                        <h2 class="text-xl font-semibold">{{ $user->first_name." ". $user->last_name }}</h2>
                        <a href="" onclick="toggleProfileModal(true)" class="mt-1 inline-flex items-center gap-2 text-sm text-green-600 border border-green-600 px-3 py-1 rounded-full hover:bg-green-50">
                            <i class="bi bi-pencil-square"></i> Edit profile
                        </a>
                    </div>
                </div>
            
                <!-- Right Stats -->
                <div class="text-center md:text-end w-full md:w-auto">
                    <p class="text-2xl font-bold text-center"><b>{{ $wishlists->count() }}</b></p>
                    <p class="text-sm text-gray-500">Wishlist created</p>
                </div>
            </div>
            
           <!-- Edit Profile Modal -->
            <div id="edit-profile-modal" class="fixed inset-0 bg-black bg-opacity-50 hidden z-50 flex items-center justify-center">
                <div class="bg-white w-full max-w-md p-6 rounded-xl shadow-lg overflow-y-auto max-h-screen" onclick="event.stopPropagation()">
                    <!-- Modal Header -->
                    <div class="flex justify-between items-center mb-4">
                        <h3 class="text-xl font-semibold">Edit Profile</h3>
                        <button onclick="toggleProfileModal(false)" class="text-gray-500 hover:text-gray-700">
                            <i class="fas fa-times"></i>
                        </button>
                    </div>

                    <!-- Profile Form -->
                    <form id="profileForm" method="POST" action="{{ route('user.profile.update') }}" enctype="multipart/form-data" class="space-y-4">
                        @csrf
                        @method('PUT')
                        
                        <!-- Profile Image -->
                        <div class="text-center mb-4">
                            <div class="relative inline-block">
                                @if ($user->profile_picture)
                                    <img id="profile-preview" src="{{ asset('user/image/'.$user->profile_picture) }}" alt="Profile Image" class="w-24 h-24 rounded-full object-cover mx-auto border-2 border-green-600">
                                    @else
                                    <img id="profile-preview" src="{{ asset('images/profile.jpg') }}" alt="Profile Image" class="w-24 h-24 rounded-full object-cover mx-auto border-2 border-green-600">
                                @endif
                                <label for="profile-image" class="absolute bottom-0 right-0 bg-green-600 text-white rounded-full p-1 cursor-pointer">
                                    <i class="fas fa-pen"></i>
                                    <input type="file" id="profile-image" name="profile_picture" class="hidden"">
                                </label>
                            </div>
                        </div>
                        
                        <!-- Name Fields -->
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label for="first-name" class="block text-sm font-medium text-gray-700 mb-1">First Name</label>
                                <input type="text" id="first-name" name="first_name" value="{{ $user->first_name }}" class="w-full border px-3 py-2 rounded" required>
                            </div>
                            <div>
                                <label for="last-name" class="block text-sm font-medium text-gray-700 mb-1">Last Name</label>
                                <input type="text" id="last-name" name="last_name" value="{{ $user->last_name }}" class="w-full border px-3 py-2 rounded" required>
                            </div>
                        </div>
                        
                        <!-- Email -->
                        <div>
                            <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email Address</label>
                            <input type="email" id="email" name="email" value="{{ $user->email }}" class="w-full border px-3 py-2 rounded bg-gray-100" readonly>
                            <p class="text-xs text-gray-500 mt-1">Email cannot be changed</p>
                        </div>
                        <!-- Change Password Toggle -->
                        <div>
                            <div class="flex items-center">
                                <input type="checkbox" id="change-password-toggle" class="mr-2">
                                <label for="change-password-toggle" class="text-sm font-medium text-gray-700">Change Password</label>
                            </div>
                        </div>
                        
                        <!-- Password Fields (initially hidden) -->
                        <div id="password-fields" class="hidden space-y-4">
                            <div class="relative">
                                <label for="current-password" class="block text-sm font-medium text-gray-700 mb-1">Current Password</label>
                                <input type="password" id="current-password" name="current_password" class="w-full border px-3 py-2 rounded">
                                <button type="button" class="toggle-password absolute right-3 top-9 cursor-pointer" data-target="current-password">
                                    <i class="fas fa-eye-slash text-gray-500 hover:text-green-500"></i>
                                </button>
                            </div>
                            <div class="relative">
                                <label for="new-password" class="block text-sm font-medium text-gray-700 mb-1">New Password</label>
                                <input type="password" id="new-password" name="new_password" class="w-full border px-3 py-2 rounded">
                                <button type="button" class="toggle-password absolute right-3 top-9 cursor-pointer" data-target="new-password">
                                    <i class="fas fa-eye-slash text-gray-500 hover:text-green-500"></i>
                                </button>
                            </div>
                            <div class="relative">
                                <label for="confirm-password" class="block text-sm font-medium text-gray-700 mb-1">Confirm New Password</label>
                                <input type="password" id="confirm-password" name="new_password_confirmation" class="w-full border px-3 py-2 rounded">
                                <button type="button" class="toggle-password absolute right-3 top-9 cursor-pointer" data-target="confirm-password">
                                    <i class="fas fa-eye-slash text-gray-500 hover:text-green-500"></i>
                                </button>
                            </div>
                        </div>
                        
                        <!-- Submit Button -->
                        <div class="mt-6">
                            <button type="submit" id="profile-submit-button" class="bg-green-600 text-white px-4 py-2 rounded w-full hover:bg-green-700">
                                Save Changes
                            </button>
                        </div>
                    </form>
                </div>
            </div>

           <!-- Tabs Header -->
           <div class="flex space-x-4 mb-6 border-b overflow-x-auto whitespace-nowrap">
                <button class="tab active-tab px-4 py-2 text-gray-700 border-b-2 border-green-600" data-tab="list">List</button>
                <button class="tab px-4 py-2 text-gray-500 hover:text-gray-700 border-b-2" data-tab="wallet">Wallet</button>
                <button class="tab px-4 py-2 text-gray-500 hover:text-gray-700 border-b-2" data-tab="referral">Reserved</button>
            </div>
        

            @if(session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
                <strong class="font-bold">Success!</strong>
                <span class="block sm:inline">{{ session('success') }}</span>
                <span onclick="this.parentElement.style.display='none';"
                      class="absolute top-0 bottom-0 right-0 px-4 py-3 cursor-pointer text-green-700">
                    &times;
                </span>
            </div>
            @endif
            @if(session('error'))
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
                <strong class="font-bold">Error!</strong>
                <span class="block sm:inline">{{ session('error') }}</span>
                <span onclick="this.parentElement.style.display='none';"
                      class="absolute top-0 bottom-0 right-0 px-4 py-3 cursor-pointer text-red-700">
                    &times;
                </span>
            </div>
            @endif
            @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            @endif
        
                <!-- Wishlist Grid (List Tab) -->
                <div id="list-content" class="tab-content block">
                                            
                    <!-- Search and Add Button -->
                    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-4 gap-4">
                        <div class="relative w-full sm:w-72">
                            <input type="text" placeholder="Search" class="w-full border rounded-full pl-10 pr-4 py-2" />
                            <i class="bi bi-search absolute top-2.5 left-3 text-gray-400"></i>
                        </div>
                        <a href="{{route('create.wishlist')}}" class="bg-green-600 text-white px-5 py-2 rounded-full hover:bg-green-700 w-full sm:w-auto text-center">Add Wishlist</a>
                    </div>
                    
                    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
                        @foreach ($wishlists as $wishlist)
                            <div class="bg-white p-4 rounded-xl shadow hover:shadow-md transition-all">
                                <a href="{{ route('wishlist.view', $wishlist->slug)}}">
                                 <img src="{{ asset($wishlist->image) }}" alt="Item Image" class="w-full h-40 object-cover rounded-lg mb-3">
                                </a>
                                <h3 class="text-lg font-medium mb-1">{{ $wishlist->title }}</h3>
                                <p class="text-sm text-gray-600">Items: {{ $wishlist->items_count }}</p>

                                <div class="mt-2 flex justify-end gap-2">
                                    <button onclick="toggleShareMenu()" class="hover:underline">
                                        <i class="fas fa-share"></i>
                                    </button>
                                    <a href="{{ route('wishlist.view', $wishlist->slug) }}" class="hover:underline"><i class="fas fa-eye"></i></a>
                                    <a href="{{ route('wishlist.show', $wishlist->slug) }}" class="hover:underline"><i class="fas fa-edit"></i></a>
                                    <form class="deleteWishlist" action="{{ route('wishlist.destroy', $wishlist->id) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="button" class="deleteWishlistbutton text-red-500"><i class="fas fa-trash"></i></button>
                                    </form>

                                      <!-- Social share menu -->
                                    <div id="shareMenu" class="absolute z-10 hidden bg-white border rounded shadow p-4 space-y-4 mt-2">
                                        <h5>Share to your friends on</h5>
                                        {{-- <button value="copyShareLink('{{ url('wishlist/' . $wishlist->slug) }}')" id="shareLink">
                                            <i class="fab fa-instagram text-pink-500"></i>
                                        </button> --}}
                                        <a href="https://wa.me/?text={{ urlencode(url('wishlist/' . $wishlist->slug)) }}" target="_blank">
                                            <i class="fab fa-whatsapp text-green-500"></i> 
                                        </a>
                                        <a href="https://twitter.com/intent/tweet?url={{ urlencode(url('wishlist/' . $wishlist->slug)) }}" target="_blank">
                                            <i class="fab fa-twitter text-blue-400"></i> 
                                        </a>
                                        <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(url('wishlist/' . $wishlist->slug)) }}" target="_blank">
                                            <i class="fab fa-facebook-f text-blue-600"></i>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>

                <!-- Wallet Tab -->
                    <div id="wallet-content" class="tab-content hidden">
                        <div class="bg-red-100 text-red-800 text-sm p-4 rounded mb-4">
                            A small fee of 3.9% will be automatically deducted whenever you receive a money gift from someone or a loved one. This helps us keep the platform running smoothly and securely.
                        </div>

                        <div class="grid grid-cols-1 sm:grid-cols-3 gap-6 mb-6 max-w-lg">
                            <div class="bg-green-200 text-green-800 p-6 rounded shadow text-center">
                                <h3 class="text-lg font-semibold mb-2">Total Amount received</h3>
                                <p class="text-2xl font-bold text-gray-800">₦{{$totalwalletBalance ?? '0'}}</p>
                            </div>
                            <div class="bg-gray-100 p-6 rounded shadow text-center">
                                <h3 class="text-lg font-semibold mb-2">Total Amount withdrawn</h3>
                                <p class="text-2xl font-bold text-gray-800">₦{{$amountWithdrawn}}</p>
                            </div>
                            <div class="bg-green-100 p-6 rounded shadow text-center">
                                <h3 class="text-lg font-semibold mb-2">Current Balance</h3>
                                <p class="text-2xl font-bold text-gray-800">₦{{$currentBalance}}</p>
                            </div>
                        </div>

                        <div class="flex justify-between items-center mb-4">
                            <h3 class="text-lg font-semibold">Payout history</h3>
                            <button class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700 withdraw" >Withdraw funds</button>
                        </div>

                        <div class="overflow-x-auto bg-white shadow rounded-lg">
                            <table class="min-w-full text-sm text-left text-gray-500">
                                <thead class="bg-gray-50 text-xs text-gray-700 uppercase">
                                    <tr>
                                        <th class="px-4 py-3">Reference Id</th>
                                        <th class="px-4 py-3">Beneficiary</th>
                                        <th class="px-4 py-3">Bank</th>
                                        <th class="px-4 py-3">Amount (NGN)</th>
                                        <th class="px-4 py-3">Transfer Fee</th>
                                        <th class="px-4 py-3">Date</th>
                                        <th class="px-4 py-3">Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr class="border-b">
                                        @if ($withdrawals)
                                        @foreach ($withdrawals as $withdrawal)
                                            <td class="px-4 py-6">{{$withdrawal->reference}}</td>
                                                                                    <td class="px-4 py-6">{{$withdrawal->bankAccount->account_name}}</td>
                                            <td class="px-4 py-6">{{$withdrawal->bankAccount->bank_name}}</td>
                                            <td class="px-4 py-6">{{$withdrawal->amount}}</td>
                                            <td class="px-4 py-6">{{ \Carbon\Carbon::parse($withdrawal->created_at)->format('d M, Y') }}</td>                                            <td class="px-4 py-6 text-success">{{$withdrawal->status}}</td>

@endforeach
                                            @else
                                        <td colspan="7" class="px-4 py-6 text-center text-gray-400">
                                            You don't have any transaction
                                        </td>
                                        @endif
                                       
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <!-- Sidebar Overlay -->
                    <div id="withdraw-sidebar" class="fixed inset-0 bg-black bg-opacity-50 hidden z-40" onclick="toggleSidebar(false)">
                        <div class="absolute top-0 right-0 h-full bg-white w-80 p-6 shadow-lg overflow-y-auto max-h-screen" onclick="event.stopPropagation()">

                            <h3 class="text-xl font-semibold mb-4">Withdraw Funds</h3>
                            <p class="text-sm text-gray-600 mb-4">Add your account information to withdraw funds.</p>

                            <button onclick="toggleForm(true)" class="bg-green-600 text-white px-4 py-2 rounded mb-4 hover:bg-green-700">
                                Add Payout
                            </button>

                            <!-- Account Form (Initially Hidden) -->
                            <div id="account-form" class="hidden">
                                <form id="bankForm" method="POST" action="{{route('account.details.store')}}" class="space-y-3">
                                    @csrf
                                    <select name="bank_name" id="bank-select" class="w-full border px-3 py-2 rounded mb-3" required>
                                        <option value="">Select Bank</option>
                                    </select>
                                
                                    <input type="hidden" name="bank_name_text" id="bank-name-text">
                                
                                    <input type="text" name="account_number" id="account-number" placeholder="Enter account number" class="w-full border px-3 py-2 rounded mb-3" required />
                                
                                    <input type="hidden" name="account_name" id="account-name-hidden">
                                    <p id="account-name" class="text-green-600 text-sm font-medium hidden"></p>
                                    <!-- Spinner -->
                                        <div id="spinner" class="flex items-center space-x-2 text-sm text-gray-600 hidden">
                                            <svg class="animate-spin h-5 w-5 text-green-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                                <path class="opacity-75" fill="currentColor"
                                                    d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"></path>
                                            </svg>
                                            <span>Verifying account...</span>
                                        </div>
                                    <div id="form-spinner" class="hidden flex items-center gap-2 text-sm text-gray-600">
                                        <svg class="animate-spin h-5 w-5 text-green-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                            <path class="opacity-75" fill="currentColor"
                                                d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z">
                                            </path>
                                        </svg>
                                        <span>Saving bank details...</span>
                                    </div>

                                    <button type="submit" id="submit-button" class="bg-green-600 text-white px-4 py-2 rounded hidden">
                                        Save Account Details
                                    </button>
                                </form>
                                
                            </div>
                                <label class="block text-sm font-medium text-gray-700 mb-2 mt-2">Use Saved Account</label>
                                <div class="space-y-2">
                                        
                                </div>
                            <!-- Withdraw Form -->
                            <form class="mt-6" action="{{route('wallet.withdraw')}}" method="POST">
                                @csrf
                                <input type="hidden" name="account_id" id="selected-account-id">

                                <label for="withdraw-amount" class="block text-sm font-medium text-gray-700 mb-1">Amount to withdraw (₦)</label>
                                <input type="number" id="withdraw-amount" name="amount" class="w-full border px-3 py-2 rounded mb-3" placeholder="Enter amount" required>

                                <button type="submit" class="bg-green-600 text-white px-4 py-2 rounded w-full hover:bg-green-700">
                                    Withdraw Now
                                </button>
                            </form>

                        </div>
                        

                    </div>


                <!-- Referral Tab -->
                <div id="referral-content" class="tab-content hidden">
                    <div class="overflow-x-auto bg-white shadow rounded-lg">
                        <table class="min-w-full text-sm text-left text-gray-500">
                            <thead class="bg-gray-50 text-xs text-gray-700 uppercase">
                                <tr>
                                    <th class="px-4 py-3">Name</th>
                                    <th class="px-4 py-3">Description</th>
                                    <th class="px-4 py-3">Reserved By</th>
                                    <th class="px-4 py-3">Amount (NGN)</th>
                                    <th class="px-4 py-3">Quantity</th>
                                    <th class="px-4 py-3">Note</th>
                                    <th class="px-4 py-3">Date</th>
                                    <th class="px-4 py-3">Status</th>
                                </tr>
                            </thead>
                            <tbody>
                               
                                    @if ($reserved)
                                    @foreach ($reserved as $reserve)
                                    <tr class="border-b">
                                          <td class="px-4 py-6">
                                           {{$reserve->item->name ?? $reserve->money->name}}
                                        </td>
                                        <td class="px-4 py-6">  {{$reserve->item->note ?? $reserve->money->description}}
                                        <td class="px-4 py-6">{{ $reserve->name }}</td>
                                        <td class="px-4 py-6">₦{{ number_format($reserve->amount, 2)}}</td>
                                        <td class="px-4 py-6">{{$reserve->quantity ?? '-'}}</td>
                                        <td class="px-4 py-6">{{ $reserve->note ?? '-' }}</td>
                                        <td class="px-4 py-6">{{ \Carbon\Carbon::parse($reserve->created_at)->format('d M, Y') }}</td>
                                        <td class="px-4 py-6 text-success">Success</td>
                                </tr>

                                    @endforeach
                                    @else
                                    <tr class="border-b">
                                        <td colspan="7" class="px-4 py-6 text-center text-gray-400">
                                            You don't have any Reserved Items
                                        </td>
                                    </tr>
                                    @endif
                                    
                            </tbody>
                        </table>
                    </div>
                </div>



        </div>
    </section>
  
@endsection