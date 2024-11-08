document.addEventListener('DOMContentLoaded', function() {
    const profilePicture = document.getElementById('profilePicture');
    const profilePictureInput = document.getElementById('profilePictureInput');
    const uploadButton = document.getElementById('uploadButton');

    // Trigger file input when upload button is clicked
    uploadButton.addEventListener('click', function() {
        profilePictureInput.click();
    });

    // Handle file selection
    profilePictureInput.addEventListener('change', function(e) {
        const file = e.target.files[0];
        
        if (file) {
            // Show preview of selected image
            const reader = new FileReader();
            reader.onload = function(e) {
                profilePicture.src = e.target.result;
            };
            reader.readAsDataURL(file);

            // Create FormData and upload
            const formData = new FormData();
            formData.append('profile_picture', file);

            // Upload image using fetch
            fetch('/upload-profile-picture', {
                method: 'POST',
                body: formData,
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Show success message
                    alert('Profile picture updated successfully!');
                } else {
                    // Show error message
                    alert('Error uploading profile picture: ' + data.message);
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Error uploading profile picture. Please try again.');
            });
        }
    });
});