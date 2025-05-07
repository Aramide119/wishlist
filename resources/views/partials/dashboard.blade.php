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
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
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
    
      <!-- Custom JS for tab functionality -->
        <script>
            document.addEventListener("DOMContentLoaded", function () {
                const tabs = document.querySelectorAll(".tab");
                const tabContents = {
                    list: document.getElementById("list-content"),
                    wallet: document.getElementById("wallet-content"),
                    referral: document.getElementById("referral-content"),
                };

                tabs.forEach(tab => {
                    tab.addEventListener("click", () => {
                        // Remove active styles from all tabs
                        tabs.forEach(t => {
                            t.classList.remove("active-tab", "border-green-600", "text-gray-700");
                            t.classList.add("text-gray-500");
                        });

                        // Add active style to clicked tab
                        tab.classList.add("active-tab", "border-green-600", "text-gray-700");
                        tab.classList.remove("text-gray-500");

                        // Hide all tab contents
                        Object.values(tabContents).forEach(content => content.classList.add("hidden"));

                        // Show selected tab content
                        const selected = tab.dataset.tab;
                        tabContents[selected].classList.remove("hidden");
                    });
                });
            });
            document.addEventListener('DOMContentLoaded', () => {
                    const navToggle = document.getElementById('nav-toggle');
                    const navMenu = document.getElementById('nav-menu');
                    const userDropdownBtn = document.getElementById('userDropdownButton');
                    const userDropdown = document.getElementById('userDropdown');

                    // Mobile nav toggle
                    navToggle.addEventListener('click', () => {
                    navMenu.classList.toggle('hidden');
                    });

                    // Dropdown toggle
                    userDropdownBtn.addEventListener('click', (e) => {
                    e.stopPropagation(); // Prevent event bubbling
                    userDropdown.classList.toggle('hidden');
                    });

                    // Close dropdown when clicking outside
                    document.addEventListener('click', (e) => {
                    if (!userDropdown.contains(e.target) && !userDropdownBtn.contains(e.target)) {
                        userDropdown.classList.add('hidden');
                    }
                    });
            });
        </script>


  
      <!-- Bootstrap JS Bundle with Popper -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
    <script src="{{asset('js/script.js')}}"></script> 
     <script>

        document.getElementsByClassName('deleteWishlistbutton').addEventListener('click', function(event) {
            event.preventDefault(); // Prevent the default button action
            Swal.fire({
                title: 'Are you sure?',
                text: "Do you want to delete this wishlist?",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete!'
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementsByClassName('deleteWishlist').submit();
                }
            });
        });
    </script>
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
                function toggleSidebar(show) {
                       const sidebar = document.getElementById('withdraw-sidebar');
                        sidebar.classList.toggle('hidden', !show);

                        if (show) {
                            loadSavedAccounts(); // Fetch saved accounts when sidebar is shown
                        }

                    
                }
            
                function toggleForm(show) {
                    const form = document.getElementById('account-form');
                    form.classList.toggle('hidden', !show);
                }
            
                // Attach to button
                document.addEventListener('DOMContentLoaded', () => {
                    const withdrawBtn = document.querySelector('button.bg-green-600.text-white');
                    if (withdrawBtn) {
                        withdrawBtn.addEventListener('click', () => toggleSidebar(true));
                    }
                });

                document.addEventListener('DOMContentLoaded', () => {
                    fetch('/banks')
                        .then(res => res.json())
                        .then(data => {
                            const banks = data.data;
                            const bankSelect = document.getElementById('bank-select');
                            banks.forEach(bank => {
                                const option = document.createElement('option');
                                option.value = bank.code;
                                option.text = bank.name;
                                bankSelect.appendChild(option);
                            });
                        });

                    const accNumInput = document.getElementById('account-number');
                    const bankSelect = document.getElementById('bank-select');
                    const accNameDisplay = document.getElementById('account-name');
                    const submitBtn = document.getElementById('submit-button');
                    const accNameHidden = document.getElementById('account-name-hidden');
                    const bankNameText = document.getElementById('bank-name-text');

                    const spinner = document.getElementById('spinner');

                    accNumInput.addEventListener('input', () => {
                        const accountNumber = accNumInput.value;
                        const bankCode = bankSelect.value;
                        const bankText = bankSelect.options[bankSelect.selectedIndex].text;

                        // Only fire when exactly 10 digits are typed
                        if (accountNumber.length === 10 && bankCode) {
                            accNameDisplay.classList.add('hidden');
                            submitBtn.classList.add('hidden');
                            spinner.classList.remove('hidden');

                            fetch(`/resolve-account?account_number=${accountNumber}&bank_code=${bankCode}`)
                                .then(res => res.json())
                                .then(data => {
                                    spinner.classList.add('hidden');

                                    if (data.status) {
                                        accNameDisplay.textContent = `Account Name: ${data.data.account_name}`;
                                        accNameDisplay.classList.remove('hidden');

                                        accNameHidden.value = data.data.account_name;
                                        bankNameText.value = bankText;
                                        submitBtn.classList.remove('hidden');
                                    } else {
                                        accNameDisplay.textContent = 'Account does not exist';
                                        accNameDisplay.classList.remove('hidden');
                                    }
                                })
                                .catch(err => {
                                    spinner.classList.add('hidden');
                                    accNameDisplay.textContent = 'Something went wrong. Please try again.';
                                    accNameDisplay.classList.remove('hidden');
                                });
                        }
                    });


        });
        function loadSavedAccounts() {
            fetch('/get-user-accounts') // Replace with your actual route that returns saved accounts as JSON
                .then(res => res.json())
                .then(data => {
                    const container = document.querySelector('#withdraw-sidebar .space-y-2');
                    container.innerHTML = ''; // Clear old accounts

                    data.forEach(bank => {
                        const label = document.createElement('label');
                        label.className = 'flex items-start gap-2 bg-gray-50 border p-3 rounded cursor-pointer hover:bg-gray-100';
                        label.innerHTML = `
                            <div>
                                <p class="font-semibold">${bank.bank_name}</p>
                                <p class="text-sm text-gray-600">${bank.account_number}</p>
                                <p class="text-sm text-gray-600">${bank.account_name}</p>
                            </div>
                            <input type="radio" name="selected_account" value="${bank.id}"
                                data-bank-name="${bank.bank_name}"
                                data-account-number="${bank.account_number}"
                                data-account-name="${bank.account_name}"
                                onclick="populateFromSaved(this)">
                        `;
                        container.appendChild(label);
                    });
                })
                .catch(err => console.error('Error fetching saved accounts:', err));
        }
        function populateFromSaved(radio) {
            const accountId = radio.value;
            document.getElementById('selected-account-id').value = accountId;
        }

        function resetBankFormUI() {
            document.getElementById('bankForm').reset(); // Clear form fields

            // Hide previous account name display
            document.getElementById('account-name').classList.add('hidden');
            document.getElementById('account-name').textContent = '';

            // Hide the submit button
            document.getElementById('submit-button').classList.add('hidden');

            // Hide spinner
            document.getElementById('form-spinner').classList.add('hidden');
        }

        document.getElementById('bankForm').addEventListener('submit', function(e) {
            e.preventDefault(); // Prevent page refresh

            
            const formData = new FormData(this);
            const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
            const spinner = document.getElementById('form-spinner'); // get spinner

            spinner.classList.remove('hidden');
            fetch(this.action, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': csrfToken,
                },
                body: formData
            })
            
            .then(async res => {
                if (!res.ok) {
                    const errorText = await res.text();
                    throw new Error(errorText);
                }
                return res.json();
            })
            .then(data => {
            if (data.success) {
                document.getElementById('bankForm').reset();
                toggleForm(false);
                resetBankFormUI();
                loadSavedAccounts(); // Refresh saved accounts
            } else {
                alert('Failed to save bank details.');
            }
        })    .catch(error => {
                console.error('Error submitting form:', error.message);
                alert('Error submitting form:\n' + error.message);
            });
        });

        document.getElementById('withdraw-form').addEventListener('submit', function (e) {
                e.preventDefault();

                const accountId = document.getElementById('selected-account-id').value;
                const amount = document.getElementById('withdraw-amount').value;
                const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

                if (!accountId || !amount) {
                    alert("Please select an account and enter a valid amount.");
                    return;
                }

                fetch('/withdraw-request', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': csrfToken
                    },
                    body: JSON.stringify({ account_id: accountId, amount: amount })
                })
                .then(res => res.json())
                .then(data => {
                    if (data.success) {
                        alert('Withdrawal request submitted!');
                        document.getElementById('withdraw-form').reset();
                        document.getElementById('selected-account-id').value = '';
                        toggleSidebar(false);
                    } else {
                        alert(data.message || 'Withdrawal failed.');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('Something went wrong.');
                });
            });


    </script>
        
  </body>
  </html>