// Item Image upload and preview 
document.addEventListener('DOMContentLoaded', function() {
    const fileInput = document.getElementById('coverImage');
    const imagePreview = document.getElementById('imagePreview');
    
    fileInput.addEventListener('change', function(event) {
        // Clear previous preview
        imagePreview.innerHTML = '';
        
        const file = event.target.files[0];
        
        // Check if a file was selected
        if (!file) {
            imagePreview.textContent = 'No image selected';
            return;
        }
        
        // Validate file type
        if (!file.type.match('image.*')) {
            imagePreview.textContent = 'Selected file is not an image';
            return;
        }
        
        // Validate file size (2MB = 2 * 1024 * 1024 bytes)
        if (file.size > 2 * 1024 * 1024) {
            imagePreview.textContent = 'Image size exceeds 2MB limit';
            return;
        }
        
        // Create a FileReader to read the image
        const reader = new FileReader();
        
        reader.onload = function(e) {
            // Create a container div for proper sizing
            const previewContainer = document.createElement('div');
            previewContainer.style.width = '100%';
            previewContainer.style.height = '200px'; // Set fixed height for the container
            previewContainer.style.position = 'relative';
            previewContainer.style.overflow = 'hidden';
            previewContainer.style.borderRadius = '4px';
            previewContainer.style.backgroundColor = '#f8f9fa';
            
            // Create image element
            const img = document.createElement('img');
            img.src = e.target.result;
            img.style.position = 'absolute';
            img.style.top = '0';
            img.style.left = '0';
            img.style.width = '100%';
            img.style.height = '100%';
            img.style.objectFit = 'cover'; // This makes the image cover the container while maintaining aspect ratio
            
            // Create remove button
            const removeBtn = document.createElement('button');
            removeBtn.textContent = 'Remove';
            removeBtn.className = 'btn btn-sm btn-danger';
            removeBtn.style.position = 'absolute';
            removeBtn.style.bottom = '10px';
            removeBtn.style.right = '10px';
            removeBtn.style.zIndex = '10';
            removeBtn.addEventListener('click', function(e) {
                e.stopPropagation(); // Prevent event bubbling
                // Clear the file input
                fileInput.value = '';
                // Reset preview
                imagePreview.innerHTML = 'No image selected';
            });
            
            // Add elements to preview container
            previewContainer.appendChild(img);
            previewContainer.appendChild(removeBtn);
            imagePreview.appendChild(previewContainer);
        };
        
        // Read the image file as a data URL
        reader.readAsDataURL(file);
    });
    
    // Handle drag and drop functionality
    const fileUpload = document.querySelector('.file-upload');
    
    // Add initial styling to file upload
    fileUpload.style.border = '2px dashed #ddd';
    fileUpload.style.borderRadius = '4px';
    fileUpload.style.padding = '20px';
    fileUpload.style.textAlign = 'center';
    fileUpload.style.cursor = 'pointer';
    fileUpload.style.marginBottom = '10px';
    
    ['dragenter', 'dragover', 'dragleave', 'drop'].forEach(eventName => {
        fileUpload.addEventListener(eventName, preventDefaults, false);
    });
    
    function preventDefaults(e) {
        e.preventDefault();
        e.stopPropagation();
    }
    
    ['dragenter', 'dragover'].forEach(eventName => {
        fileUpload.addEventListener(eventName, highlight, false);
    });
    
    ['dragleave', 'drop'].forEach(eventName => {
        fileUpload.addEventListener(eventName, unhighlight, false);
    });
    
    function highlight() {
        fileUpload.style.border = '2px dashed #4CAF50';
        fileUpload.style.backgroundColor = 'rgba(76, 175, 80, 0.1)';
    }
    
    function unhighlight() {
        fileUpload.style.border = '2px dashed #ddd';
        fileUpload.style.backgroundColor = '';
    }
    
    fileUpload.addEventListener('drop', handleDrop, false);
    
    function handleDrop(e) {
        const dt = e.dataTransfer;
        const files = dt.files;
        
        if (files.length > 0) {
            fileInput.files = files;
            // Trigger the change event manually
            fileInput.dispatchEvent(new Event('change'));
        }
    }
    
    // Make the entire upload area clickable to trigger file input
    // But prevent the click event if the click is on the input itself
    fileUpload.addEventListener('click', function(e) {
        // Check if the click target is the file input itself
        if (e.target !== fileInput) {
            fileInput.click();
        }
        e.stopPropagation(); // Stop event propagation
    });
});

// Modal popup item form
// Get modal elements
document.addEventListener('DOMContentLoaded', function() {
    const modal = document.getElementById('formModal');
    const closeBtn = document.querySelector('.close-btn');
    const form = document.getElementById('createListForm');
    
    // Store the original scroll position
    let scrollPosition;
    
    // List all button IDs that should trigger the modal
    const modalTriggerIds = [
        'openModalBtn',
        'thirdModalBtn'
        // Add more button IDs as needed
    ];

    // Add click event listeners to all modal trigger buttons
    modalTriggerIds.forEach(id => {
        const button = document.getElementById(id);
        if (button) {
            // button.addEventListener('click', openModal);
            button.addEventListener('click', function () {
              resetForm(); // 👈 clears all previous data
              openModal(); // then show the modal
          });
          
        }
    });
    
        // ✅ Handle all edit buttons
        document.querySelectorAll('.editModalBtn').forEach(button => {
          button.addEventListener('click', function () {
              openModal();

              // Fill the form with the data attributes
              document.getElementById('name').value = button.dataset.name || '';
              document.getElementById('website_link').value = button.dataset.website_link || '';
              document.getElementById('note').value = button.dataset.note || '';
              document.getElementById('price').value = button.dataset.price || '';
              document.getElementById('quantity').value = button.dataset.quantity || '';

              // Optional: preview image
              const preview = document.getElementById('imagePreview');
              if (button.dataset.image) {
                  preview.innerHTML = `<img src="${button.dataset.image}" style="max-height: 100px;">`;
              }

              // Update form action if you're editing
              form.action = `/items/update/${button.dataset.id}`;
          });
      });
    
    closeBtn.addEventListener('click', closeModal);
    window.addEventListener('click', outsideClick);
    // form.addEventListener('submit', submitForm);
    function resetForm() {
      form.reset();
  
      // Clear the hidden ID
      document.getElementById('itemId').value = '';
  
      // Reset form action to create route
      form.action = '/items'; // or use {{ route('create.item') }} if you're rendering inline with blade
  
      // Optional: Clear file input preview if you're using image preview
      const imagePreview = document.getElementById('imagePreview');
      if (imagePreview) {
          imagePreview.innerHTML = 'No image selected';
      }
  }
  
    // Open modal
    function openModal() {
        // Store current scroll position
        scrollPosition = window.pageYOffset;
        
        // Add styles to body to prevent scrolling
        document.body.style.position = 'fixed';
        document.body.style.top = `-${scrollPosition}px`;
        document.body.style.width = '100%';
        
        // Display the modal
        modal.style.display = 'block';
    }
    
    // Close modal
    function closeModal() {
        // Remove styles from body to enable scrolling
        document.body.style.position = '';
        document.body.style.top = '';
        document.body.style.width = '';
        
        // Restore scroll position
        window.scrollTo(0, scrollPosition);
        
        // Hide the modal
        modal.style.display = 'none';
    }
    
    // Close modal if clicked outside
    function outsideClick(e) {
        if (e.target == modal) {
            closeModal();
        }
    }
    
    // // Handle form submission
    // function submitForm(e) {
    //     e.preventDefault();
        
    //     // Get form values
    //     const itemTitle = document.getElementById('itemTitle').value;
    //     const webLink = document.getElementById('webLink').value;
        
    //     // You would typically send this data to a server here
        
    //     // Reset form
    //     form.reset();
        
    //     // Close modal
    //     closeModal();
        
    //     // Show success message (optional)
    //     alert('Form submitted successfully!');
    // }
});

// New Category selected input
document.addEventListener('DOMContentLoaded', function() {
    // Get the dropdown and new category input field
    const categoryDropdown = document.getElementById('itemCategory');
    const newCategoryContainer = document.querySelector('#newCategory').closest('.form-col');
    
    // Hide the new category input initially
    newCategoryContainer.style.display = 'none';
    
    // Add event listener to the dropdown
    categoryDropdown.addEventListener('change', function() {
        // Check if "Create new category" is selected (value="1")
        if (this.value === '1') {
            // Show the new category input
            newCategoryContainer.style.display = 'block';
        } else {
            // Hide the new category input for other options
            newCategoryContainer.style.display = 'none';
            // Clear the input value when hiding
            document.getElementById('newCategory').value = '';
        }
    });
    
    // Trigger the change event to set initial state
    categoryDropdown.dispatchEvent(new Event('change'));
});



// Wishlist media upload image or video
// document.addEventListener('DOMContentLoaded', function() {
//     const mediaInput = document.getElementById('media-upload');
//     const uploadContainer = document.querySelector('.media-upload-container');
//     // const previewContainer = document.querySelector('.preview-container');
    
//     // Create remove button but don't append it yet
//     const removeBtn = document.createElement('button');
//     removeBtn.className = 'remove-btn';
//     removeBtn.innerHTML = '&times;';
//     removeBtn.addEventListener('click', function(e) {
//       e.preventDefault();
//       e.stopPropagation();
      
//       // Clear the input and preview
//       // mediaInput.value = '';
//       // previewContainer.innerHTML = '';
//       // uploadContainer.classList.remove('has-preview');
      
//       // Remove the button itself
//       if (this.parentNode === uploadContainer) {
//         uploadContainer.removeChild(this);
//       }
//     });
    
//     // mediaInput.addEventListener('change', function() {
//     //   // Clear previous preview
//     //   previewContainer.innerHTML = '';
      
//     //   if (this.files && this.files[0]) {
//     //     const file = this.files[0];
//     //     const fileType = file.type;
        
//     //     // Add the remove button to the container
//     //     if (!uploadContainer.contains(removeBtn)) {
//     //       uploadContainer.appendChild(removeBtn);
//     //     }
        
//     //     // Create appropriate element based on file type
//     //     if (fileType.startsWith('image/')) {
//     //       const img = document.createElement('img');
//     //       img.src = URL.createObjectURL(file);
//     //       img.onload = function() {
//     //         URL.revokeObjectURL(this.src);
//     //       }
//     //       previewContainer.appendChild(img);
//     //     } else if (fileType.startsWith('video/')) {
//     //       const video = document.createElement('video');
//     //       video.src = URL.createObjectURL(file);
//     //       video.controls = true;
//     //       video.autoplay = false;
//     //       video.onloadedmetadata = function() {
//     //         URL.revokeObjectURL(this.src);
//     //       }
//     //       previewContainer.appendChild(video);
//     //     }
        
//     //     // Add class to container to show we have media
//     //     uploadContainer.classList.add('has-preview');
//     //   } else {
//     //     // No file selected, remove the class
//     //     uploadContainer.classList.remove('has-preview');
//     //   }
//     // });
    
//     // Add drag and drop functionality
//     ['dragenter', 'dragover', 'dragleave', 'drop'].forEach(eventName => {
//       uploadContainer.addEventListener(eventName, preventDefaults, false);
//     });
    
//     function preventDefaults(e) {
//       e.preventDefault();
//       e.stopPropagation();
//     }
    
//     ['dragenter', 'dragover'].forEach(eventName => {
//       uploadContainer.addEventListener(eventName, highlight, false);
//     });
    
//     ['dragleave', 'drop'].forEach(eventName => {
//       uploadContainer.addEventListener(eventName, unhighlight, false);
//     });
    
//     function highlight() {
//       uploadContainer.style.borderColor = '#4CAF50';
//       uploadContainer.style.backgroundColor = 'rgba(76, 175, 80, 0.1)';
//     }
    
//     function unhighlight() {
//       uploadContainer.style.borderColor = '#ccc';
//       uploadContainer.style.backgroundColor = '';
//     }
    
//     uploadContainer.addEventListener('drop', function(e) {
//       const dt = e.dataTransfer;
//       const files = dt.files;
      
//       if (files.length > 0) {
//         mediaInput.files = files;
//         mediaInput.dispatchEvent(new Event('change'));
//       }
//     });
//   });

function copyShareLink() {
    const copyText = document.getElementById("shareLink");
    copyText.select();
    copyText.setSelectionRange(0, 99999); // For mobile devices
    navigator.clipboard.writeText(copyText.value).then(function () {
        Swal.fire({
            icon: 'success',
            title: 'Copied!',
            text: 'The link has been copied to your clipboard.',
            timer: 2000,
            showConfirmButton: false
        });
    }).catch(function (err) {
        console.error('Error copying text: ', err);
    });
}

//   Wishlist form popup

// Modal popup wishlist form
// Get modal elements
document.addEventListener('DOMContentLoaded', function() {
    // Get modal element
    const modal = document.getElementById('wishlistModal');
    
    // List all button IDs that should trigger the modal
    const modalTriggerIds = [
      'openWishlistModal',
      'openWishlistModalDate',
      'openWishlistModalAdd',
      'openWishlistModalIntro'
      // Add more button IDs as needed
    ];
    
    // Initialize Bootstrap modal
    const wishlistModal = new bootstrap.Modal(modal);
    
    // Add click event listeners to all modal trigger buttons
    modalTriggerIds.forEach(id => {
      const button = document.getElementById(id);
      if (button) {
        button.addEventListener('click', function() {
          wishlistModal.show();
        });
      }
    });
    
    // Close modal when close button is clicked
    const closeBtn = document.querySelector('#wishlistModal .btn-close');
    if (closeBtn) {
      closeBtn.addEventListener('click', function() {
        wishlistModal.hide();
      });
    }
    
    // Close modal when "Close" button in footer is clicked
    const closeModalBtn = document.querySelector('#wishlistModal .modal-footer .btn-secondary');
    if (closeModalBtn) {
      closeModalBtn.addEventListener('click', function() {
        wishlistModal.hide();
      });
    }
    
  });
  document.getElementById('uploadBtn2').addEventListener('click', function () {
    document.getElementById('actualFileInput').click();
});



    document.getElementById('generateGiftIdeasBtn').addEventListener('click', function () {
        const gender = document.getElementById('genderSelect').value;
        const occasion = document.getElementById('occasionInput').value.trim();
        const container = document.getElementById('giftIdeasContainer');

        if (!occasion) {
            container.innerHTML = '<div class="text-danger">Please enter an occasion.</div>';
            return;
        }

        container.innerHTML = `<div class="text-muted">Generating gift ideas for ${occasion}...</div>`;

        fetch('/generate-gift-ideas', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify({ gender, occasion })
        })
        .then(response => response.json())
        .then(data => {
            if (data.ideas && data.ideas.length > 0) {
                container.innerHTML = data.ideas.map(item => `
                    <div class="gift-idea py-1">
                        🎁 <a href="${item.link}" target="_blank">${item.name}</a>
                    </div>
                `).join('');
            } else {
                container.innerHTML = '<div class="text-danger">No gift ideas found.</div>';
            }
                    const modal = bootstrap.Modal.getInstance(document.getElementById('giftIdeaModal'));
                    if (modal) modal.hide();

        })
        .catch(err => {
            console.error(err);
            container.innerHTML = '<div class="text-danger">Something went wrong. Please try again.</div>';
        });
    });

document.getElementById('actualFileInput').addEventListener('change', function (event) {
    const previewContainer = document.getElementById('moneyimagePreview');
    const file = event.target.files[0];

    if (file && file.type.startsWith('image/')) {
        const reader = new FileReader();
        reader.onload = function (e) {
            previewContainer.style.backgroundImage = `url('${e.target.result}')`;
            previewContainer.style.backgroundSize = 'cover';
            previewContainer.style.backgroundPosition = 'center';
            previewContainer.innerHTML = ''; // remove 📷 icon
        };
        reader.readAsDataURL(file);
    } else {
        previewContainer.style.backgroundImage = 'none';
        previewContainer.innerHTML = '<div class="camera-icon">📷</div>';
    }
});
  document.addEventListener('DOMContentLoaded', function() {
    // Elements
    const popupTriggerBtn = document.querySelector('.add-money-btn');
    const popupOverlay = document.getElementById('moneyFundPopup');
    const closeBtn = document.getElementById('closeBtn');
    const uploadBtn = document.getElementById('uploadBtn');
    const actualFileInput = document.getElementById('actualFileInput');
    const imagePreview = document.getElementById('imagePreview');
    const moneyFundForm = document.getElementById('moneyFundForm');
    
    // Open popup when trigger button is clicked
    popupTriggerBtn.addEventListener('click', function() {
        popupOverlay.style.display = 'flex';
    });
    
    // Close popup when close button is clicked
    closeBtn.addEventListener('click', function() {
        popupOverlay.style.display = 'none';
    });
    
    // Close popup when clicking outside the popup container
    popupOverlay.addEventListener('click', function(e) {
        if (e.target === popupOverlay) {
            popupOverlay.style.display = 'none';
        }
    });
    
// Upload button functionality
uploadBtn.addEventListener('click', function() {
  actualFileInput.click();
});

// File input change functionality
actualFileInput.addEventListener('change', function() {
  const file = this.files[0];
  if (file) {
      const reader = new FileReader();
      
      reader.onload = function(e) {
          // Clear the camera icon
          imagePreview.innerHTML = '';
          // Set the background image
          imagePreview.style.backgroundImage = `url('${e.target.result}')`;
          // Make sure the background size and position are set properly
          imagePreview.style.backgroundSize = 'cover';
          imagePreview.style.backgroundPosition = 'center';
      };
      
      reader.readAsDataURL(file);
  }
});

    
    
    // // Form submission
    moneyFundForm.addEventListener('submit', function(e) {
        e.preventDefault();
        
        // Get form values
        const name = document.getElementById('name').value;
        const description = document.getElementById('description').value;
        const currency = document.getElementById('currency').value;
        const target = document.getElementById('target').value;
        const termsAgreed = document.getElementById('termsCheckbox').checked;
        
        // Validation
        if (!name) {
            alert('Please enter a name');
            return;
        }
        
        if (!target) {
            alert('Please enter a target amount');
            return;
        }
        
        if (!termsAgreed) {
            alert('Please agree to the terms of service');
            return;
        }
        
        // Close the popup after successful submission
        popupOverlay.style.display = 'none';
        
        // Reset form
        moneyFundForm.reset();
        imagePreview.innerHTML = '<div class="camera-icon">📷</div>';
        imagePreview.style.backgroundImage = '';
    });
});