// public/js/profile.js
$(document).ready(function() {
    // Profile Picture Upload Handling
    $('#uploadButton').click(function() {
        $('#profilePictureInput').click();
    });

    $('#profilePictureInput').change(function() {
        if (this.files && this.files[0]) {
            // Show preview immediately
            var reader = new FileReader();
            reader.onload = function(e) {
                $('#profilePicture').attr('src', e.target.result);
            };
            reader.readAsDataURL(this.files[0]);
        }
    });

    // Save Changes (Including Profile Picture)
    $('#saveChangesButton').click(function() {
        const formData = new FormData();
        formData.append('firstName', $('#firstName').val());
        formData.append('lastName', $('#lastName').val());
        formData.append('birthDate', $('#birthDate').val());
        formData.append('email', $('#email').val());
        
        // Add profile picture if selected
        if ($('#profilePictureInput')[0].files[0]) {
            formData.append('profilePicture', $('#profilePictureInput')[0].files[0]);
        }

        // Show loading state
        $('#saveChangesButton').prop('disabled', true).html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Saving...');

        $.ajax({
            url: '/profile/update',
            method: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function(response) {
                showAlert('success', 'Profile updated successfully');
            },
            error: function(xhr) {
                showAlert('danger', 'Error updating profile: ' + (xhr.responseJSON?.message || 'Unknown error'));
            },
            complete: function() {
                // Reset button state
                $('#saveChangesButton').prop('disabled', false).html('Save Changes');
            }
        });
    });

    // Separate Profile Picture Upload (if needed)
    function uploadProfilePicture() {
        if ($('#profilePictureInput')[0].files[0]) {
            var formData = new FormData();
            formData.append('profile_picture', $('#profilePictureInput')[0].files[0]);

            // Show loading state
            $('#uploadButton').prop('disabled', true).html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Uploading...');

            $.ajax({
                url: '/profile/upload-picture',
                type: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(response) {
                    if (response.success) {
                        $('#profilePicture').attr('src', response.path);
                        showAlert('success', 'Profile picture updated successfully!');
                    } else {
                        showAlert('danger', 'Error: ' + response.message);
                    }
                },
                error: function(xhr) {
                    showAlert('danger', 'Error uploading profile picture: ' + (xhr.responseJSON?.message || 'Unknown error'));
                },
                complete: function() {
                    // Reset button state
                    $('#uploadButton').prop('disabled', false).html('<i class="bi bi-upload me-1"></i>Upload Photo');
                }
            });
        }
    }

    // Add Address
    $('#saveAddressButton').click(function() {
        $.ajax({
            url: '/profile/address',
            method: 'POST',
            data: {
                address: $('#newAddress').val(),
                _token: $('meta[name="csrf-token"]').attr('content')
            },
            success: function(response) {
                showAlert('success', 'Address added successfully');
                // Refresh address list or add to DOM
            },
            error: function(xhr) {
                showAlert('danger', 'Error adding address: ' + (xhr.responseJSON?.message || 'Unknown error'));
            }
        });
    });

    // Utility function for showing alerts
    function showAlert(type, message) {
        const alertHtml = `
            <div class="alert alert-${type} alert-dismissible fade show" role="alert">
                ${message}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>`;
        
        // Remove existing alerts
        $('.alert').remove();
        
        // Add new alert
        $('#alertContainer').html(alertHtml);
        
        // Auto-dismiss after 5 seconds
        setTimeout(function() {
            $('.alert').alert('close');
        }, 5000);
    }

    $(document).ready(function() {
        // Load existing addresses when page loads
        loadAddresses();
    
        // Save Address
        $('#saveAddressButton').click(function() {
            const addressInput = $('#addressInput').val().trim();
            
            if (!addressInput) {
                showAddressAlert('Please enter an address');
                return;
            }
    
            // Show loading state
            $('#saveAddressButton').prop('disabled', true).html('<span class="spinner-border spinner-border-sm"></span> Saving...');
    
            $.ajax({
                url: '/profile/address',
                method: 'POST',
                data: {
                    address: addressInput,
                    _token: $('meta[name="csrf-token"]').attr('content')
                },
                success: function(response) {
                    // Clear input and close modal
                    $('#addressInput').val('');
                    $('#addressModal').modal('hide');
                    
                    // Reload addresses
                    loadAddresses();
                    
                    // Show success message
                    showAlert('success', 'Address added successfully');
                },
                error: function(xhr) {
                    showAddressAlert('Error adding address: ' + (xhr.responseJSON?.message || 'Unknown error'));
                },
                complete: function() {
                    // Reset button state
                    $('#saveAddressButton').prop('disabled', false).html('Save Address');
                }
            });
        });
    
        // Delete Address
        $(document).on('click', '.delete-address', function() {
            const addressId = $(this).data('id');
            
            if (confirm('Are you sure you want to delete this address?')) {
                $.ajax({
                    url: `/profile/address/${addressId}`,
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(response) {
                        loadAddresses();
                        showAlert('success', 'Address deleted successfully');
                    },
                    error: function(xhr) {
                        showAlert('danger', 'Error deleting address: ' + (xhr.responseJSON?.message || 'Unknown error'));
                    }
                });
            }
        });
    
        // Function to load addresses
        function loadAddresses() {
            $.ajax({
                url: '/profile/addresses',
                method: 'GET',
                success: function(addresses) {
                    const addressList = $('#addressList');
                    addressList.empty();
    
                    if (addresses.length === 0) {
                        addressList.append(`
                            <div class="text-muted text-center py-3">
                                No addresses added yet
                            </div>
                        `);
                    } else {
                        addresses.forEach(function(address) {
                            addressList.append(`
                                <div class="d-flex justify-content-between align-items-center border-bottom py-2">
                                    <span>${address.address}</span>
                                    <button class="btn btn-sm btn-danger delete-address" data-id="${address.id}">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </div>
                            `);
                        });
                    }
                },
                error: function(xhr) {
                    showAlert('danger', 'Error loading addresses: ' + (xhr.responseJSON?.message || 'Unknown error'));
                }
            });
        }
    
        // Function to show alert in address modal
        function showAddressAlert(message) {
            const alertDiv = $('#addressAlert');
            alertDiv.removeClass('d-none').text(message);
            
            // Hide alert after 5 seconds
            setTimeout(() => {
                alertDiv.addClass('d-none');
            }, 5000);
        }
    });
});