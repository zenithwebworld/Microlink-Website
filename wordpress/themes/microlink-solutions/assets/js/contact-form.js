jQuery(document).ready(function($) {
    $('#microlink-custom-contact-form').on('submit', function(e) {
        e.preventDefault();
        
        var $form = $(this);
        var $btn = $form.find('button[type="submit"]');
        var $alert = $('#contact-form-response');
        var originalBtnText = $btn.html();

        $btn.prop('disabled', true).html('<span class="spinner-border spinner-border-sm me-2" role="status" aria-hidden="true"></span> Sending...');
        $alert.hide().removeClass('alert-success alert-danger');

        var formData = {
            action: 'microlink_submit_contact',
            nonce: microlink_contact_obj.nonce,
            name: $form.find('[name="name"]').val(),
            email: $form.find('[name="email"]').val(),
            phone: $form.find('[name="phone"]').val(),
            subject: $form.find('[name="subject"]').val(),
            message: $form.find('[name="message"]').val()
        };

        $.post(microlink_contact_obj.ajax_url, formData, function(response) {
            if (response.success) {
                $alert.addClass('alert alert-success').html(response.data.message).fadeIn();
                $form[0].reset();
            } else {
                $alert.addClass('alert alert-danger').html(response.data.message || 'An error occurred. Please try again.').fadeIn();
            }
        }).fail(function() {
            $alert.addClass('alert alert-danger').html('Server error. Please try again later.').fadeIn();
        }).always(function() {
            $btn.prop('disabled', false).html(originalBtnText);
        });
    });
});
