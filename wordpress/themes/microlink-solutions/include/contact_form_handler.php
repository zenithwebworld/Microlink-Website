<?php
/**
 * Custom Contact Form AJAX Handler & Submission Logging
 */

if (!defined('ABSPATH')) {
    exit;
}

// Enqueue contact form script and ajax variables
function microlink_enqueue_contact_script() {
    wp_register_script(
        'microlink-contact-ajax',
        get_template_directory_uri() . '/assets/js/contact-form.js',
        array('jquery'),
        _S_VERSION,
        true
    );

    wp_localize_script('microlink-contact-ajax', 'microlink_contact_obj', array(
        'ajax_url' => admin_url('admin-ajax.php'),
        'nonce'    => wp_create_nonce('microlink_contact_nonce'),
    ));

    wp_enqueue_script('microlink-contact-ajax');
}
add_action('wp_enqueue_scripts', 'microlink_enqueue_contact_script');

// AJAX Submission Callback
function microlink_handle_contact_submission() {
    check_ajax_referer('microlink_contact_nonce', 'nonce');

    $name    = isset($_POST['name']) ? sanitize_text_field($_POST['name']) : '';
    $email   = isset($_POST['email']) ? sanitize_email($_POST['email']) : '';
    $phone   = isset($_POST['phone']) ? sanitize_text_field($_POST['phone']) : '';
    $subject = isset($_POST['subject']) ? sanitize_text_field($_POST['subject']) : 'New Contact Inquiry';
    $message = isset($_POST['message']) ? sanitize_textarea_field($_POST['message']) : '';

    if (empty($name) || empty($email) || empty($message) || !is_email($email)) {
        wp_send_json_error(array('message' => __('Please fill in all required fields with a valid email address.', _THEME_DOMAIN)));
    }

    $ip_address = $_SERVER['REMOTE_ADDR'] ?? 'Unknown';

    // 1. Log submission into Custom Post Type `contact_submission`
    $post_id = wp_insert_post(array(
        'post_title'   => $name . ' (' . $email . ')',
        'post_type'    => 'contact_submission',
        'post_status'  => 'publish',
        'meta_input'   => array(
            '_submission_name'    => $name,
            '_submission_email'   => $email,
            '_submission_phone'   => $phone,
            '_submission_subject' => $subject,
            '_submission_message' => $message,
            '_submission_ip'      => $ip_address,
        ),
    ));

    if (is_wp_error($post_id)) {
        wp_send_json_error(array('message' => __('Failed to log submission. Please try again later.', _THEME_DOMAIN)));
    }

    // 2. Send Styled Notification Email to Admin
    $admin_recipients = get_option('microlink_admin_notification_email');
    if (empty($admin_recipients)) {
        $admin_recipients = get_option('microlink_smtp_from_email', get_option('admin_email')) ?: 'info@microlink.co.in';
    }

    $from_email = get_option('microlink_smtp_from_email', 'info@microlink.co.in');
    $from_name  = get_option('microlink_smtp_from_name', get_bloginfo('name'));
    $site_name  = get_bloginfo('name');
    
    $email_fields = array(
        'Sender Name'  => $name,
        'Email'        => $email,
        'Phone'        => !empty($phone) ? $phone : 'Not provided',
        'Subject'      => $subject,
        'Submitted On' => current_time('F j, Y g:i a'),
        'IP Address'   => $ip_address,
        'Message'      => $message,
    );

    $admin_email_content = custom_get_styled_email_template('New Contact Inquiry Received', $email_fields, 'Notification sent from ' . $site_name);
    $admin_headers = array(
        'Content-Type: text/html; charset=UTF-8',
        'From: ' . $from_name . ' <' . $from_email . '>',
        'Reply-To: ' . $name . ' <' . $email . '>',
    );

    // Support comma-separated admin recipients
    $admin_emails = array_filter(array_map('trim', explode(',', $admin_recipients)));
    if (empty($admin_emails)) {
        $admin_emails = array('info@microlink.co.in');
    }

    $admin_sent = wp_mail($admin_emails, 'New Contact Inquiry: ' . $subject, $admin_email_content, $admin_headers);
    update_post_meta($post_id, '_admin_email_status', $admin_sent ? 'Sent' : 'Failed');
    if (!$admin_sent) {
        $last_err = get_option('microlink_last_mail_error');
        update_post_meta($post_id, '_admin_email_error', is_array($last_err) ? ($last_err['message'] ?? 'wp_mail returned false') : 'wp_mail returned false');
    }

    // 3. Send Styled Confirmation Email to User
    $user_fields = array(
        'Dear'            => $name,
        'Status'          => 'We have received your message and our team will get back to you shortly.',
        'Your Subject'    => $subject,
        'Reference ID'    => '#' . $post_id,
    );
    $user_email_content = custom_get_styled_email_template('Thank You for Contacting Us', $user_fields, 'Thank you for reaching out to ' . $site_name);
    $user_headers = array(
        'Content-Type: text/html; charset=UTF-8',
        'From: ' . $from_name . ' <' . $from_email . '>',
    );

    $user_sent = wp_mail($email, 'Thank you for reaching out to ' . $site_name, $user_email_content, $user_headers);
    update_post_meta($post_id, '_user_email_status', $user_sent ? 'Sent' : 'Failed');
    if (!$user_sent) {
        $last_err = get_option('microlink_last_mail_error');
        update_post_meta($post_id, '_user_email_error', is_array($last_err) ? ($last_err['message'] ?? 'wp_mail returned false') : 'wp_mail returned false');
    }

    wp_send_json_success(array('message' => __('Thank you! Your message has been sent successfully.', _THEME_DOMAIN)));
}

add_action('wp_ajax_microlink_submit_contact', 'microlink_handle_contact_submission');
add_action('wp_ajax_nopriv_microlink_submit_contact', 'microlink_handle_contact_submission');

// Also Hook into Contact Form 7 submissions (if CF7 is used) to log to CPT
function microlink_cf7_log_submission($contact_form) {
    $submission = WPCF7_Submission::get_instance();
    if ($submission) {
        $posted_data = $submission->get_posted_data();
        
        $name    = !empty($posted_data['your-name']) ? sanitize_text_field($posted_data['your-name']) : ($posted_data['name'] ?? 'CF7 Submission');
        $email   = !empty($posted_data['your-email']) ? sanitize_email($posted_data['your-email']) : ($posted_data['email'] ?? '');
        $phone   = !empty($posted_data['your-phone']) ? sanitize_text_field($posted_data['your-phone']) : ($posted_data['phone'] ?? ($posted_data['tel'] ?? ''));
        $subject = !empty($posted_data['your-subject']) ? sanitize_text_field($posted_data['your-subject']) : ($posted_data['subject'] ?? 'CF7 Contact Form');
        $message = !empty($posted_data['your-message']) ? sanitize_textarea_field($posted_data['your-message']) : ($posted_data['message'] ?? '');

        wp_insert_post(array(
            'post_title'   => $name . ($email ? ' (' . $email . ')' : ''),
            'post_type'    => 'contact_submission',
            'post_status'  => 'publish',
            'meta_input'   => array(
                '_submission_name'    => $name,
                '_submission_email'   => $email,
                '_submission_phone'   => $phone,
                '_submission_subject' => $subject,
                '_submission_message' => $message,
                '_submission_ip'      => $_SERVER['REMOTE_ADDR'] ?? '',
            ),
        ));
    }
}
add_action('wpcf7_before_send_mail', 'microlink_cf7_log_submission');
