jQuery(document).ready(function($) {
    // Handle form submission or AJAX trigger
    $('#add-hospital').on('submit', function(e) {
        e.preventDefault();

        const formData = {
            action: 'insert_or_update_data',  // The action hook for the AJAX handler
            nonce: ajax_object.nonce,         // Nonce for security
            name: $('#name').val(),       // Your form data
            city: $('#city').val(),
            state: $('#state').val(),
            address: $('#address').val(),
            zipCode: $('#zipCode').val(),
            phone: $('#phone').val(),
            email: $('#email').val(),
            numBeds: $('#numBeds').val(),
            specializations: $('#specializations').val(),
        };

        console.log('\n\n Line in hospital-ajax.js:20 formdata ', formData, '\n\n');

        $.ajax({
            url: ajax_object.ajax_url,
            type: 'POST',
            data: formData,
            success: function(response) {
                if (response.success) {
                    alert('Data successfully inserted/updated!');
                } else {
                    alert('Error: ' + response.data);  // Show error message
                }
            },
            error: function() {
                alert('An error occurred while processing the request.');
            }
        });
    });
});
