

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
        alert('Bank details saved!');
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
