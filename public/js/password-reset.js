function initializePasswordReset(resetUrl, csrfToken) {
    $(document).ready(function() {
        $('#passwordResetForm').on('submit', function(e) {
            e.preventDefault();
            
            const email = $('#resetEmail').val();
            
            $.ajax({
                url: resetUrl,
                method: 'POST',
                data: {
                    email: email,
                    _token: csrfToken
                },
                success: function(response) {
                    $('#successAlert').show();
                    $('#errorAlert').hide();
                    $('#resetEmail').val('');
                    setTimeout(function() {
                        $('#resetPasswordModal').modal('hide');
                        $('#successAlert').hide();
                    }, 3000);
                },
                error: function(xhr) {
                    $('#errorAlert').text(xhr.responseJSON.message || 'An error occurred. Please try again.');
                    $('#errorAlert').show();
                    $('#successAlert').hide();
                }
            });
        });

        // Reset alerts when modal is closed
        $('#resetPasswordModal').on('hidden.bs.modal', function () {
            $('#successAlert').hide();
            $('#errorAlert').hide();
            $('#resetEmail').val('');
        });
    });
}