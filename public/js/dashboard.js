             // Profile Modal Toggle
             function toggleProfileModal(show) {
                const modal = document.getElementById('edit-profile-modal');
                if (show) {
                    modal.classList.remove('hidden');
                    document.body.style.overflow = 'hidden';
                } else {
                    modal.classList.add('hidden');
                    document.body.style.overflow = '';
                }
            }
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

                    const withdrawBtn = document.querySelector('button.withdraw');
                    if (withdrawBtn) {
                        withdrawBtn.addEventListener('click', () => toggleSidebar(true));
                    }

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
                     // Edit profile button click handler
                const editProfileBtn = document.querySelector('a[href=""].mt-1');
                if (editProfileBtn) {
                    editProfileBtn.addEventListener('click', function(e) {
                        e.preventDefault();
                        toggleProfileModal(true);
                    });
                }
        
                // Password toggle functionality
                const passwordToggle = document.getElementById('change-password-toggle');
                const passwordFields = document.getElementById('password-fields');
                
                passwordToggle.addEventListener('change', function() {
                    if (this.checked) {
                        passwordFields.classList.remove('hidden');
                    } else {
                        passwordFields.classList.add('hidden');
                    }
                });
                
                // Profile image preview
                const profileInput = document.getElementById('profile-image');
                const profilePreview = document.getElementById('profile-preview');
                
                profileInput.addEventListener('change', function(e) {
                    if (e.target.files.length > 0) {
                        const reader = new FileReader();
                        reader.onload = function(e) {
                            profilePreview.src = e.target.result;
                        };
                        reader.readAsDataURL(e.target.files[0]);
                    }
                });

                

            });
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

                 // Get all delete buttons
                const deleteButtons = document.getElementsByClassName('deleteWishlistbutton');
                
                // Add event listener to each delete button
                for (let i = 0; i < deleteButtons.length; i++) {
                    deleteButtons[i].addEventListener('click', function(event) {
                        event.preventDefault(); // Prevent the default button action
                        
                        // Get the specific form this button is associated with
                        const form = this.closest('.deleteWishlist');
                        
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
                                // Submit the specific form associated with this button
                                form.submit();
                            }
                        });
                    });
                }

         // Close modal when clicking outside
         document.getElementById('edit-profile-modal').addEventListener('click', function(e) {
                if (e.target === this) {
                    toggleProfileModal(false);
                }
            });