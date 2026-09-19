<?php
// Register Contact Submissions CPT
function register_contact_submissions_cpt() {
    $labels = array(
        'name'                  => _x('Contact Logs', 'Post Type General Name', _THEME_DOMAIN),
        'singular_name'         => _x('Contact Log', 'Post Type Singular Name', _THEME_DOMAIN),
        'menu_name'             => __('Contact Logs', _THEME_DOMAIN),
        'all_items'             => __('All Submissions', _THEME_DOMAIN),
        'view_item'             => __('View Submission', _THEME_DOMAIN),
        'search_items'          => __('Search Submissions', _THEME_DOMAIN),
        'not_found'             => __('No submissions found', _THEME_DOMAIN),
    );

    $args = array(
        'label'                 => __('Contact Log', _THEME_DOMAIN),
        'labels'                => $labels,
        'supports'              => array('title'),
        'public'                => false,
        'show_ui'               => true,
        'show_in_menu'          => true,
        'menu_position'         => 25,
        'menu_icon'             => 'dashicons-email-alt',
        'capability_type'       => 'post',
        'capabilities'          => array('create_posts' => 'do_not_allow'), // Read-only logs
        'map_meta_cap'          => true,
    );

    register_post_type('contact_submission', $args);
}
add_action('init', 'register_contact_submissions_cpt');

// Add Custom Columns to Admin List Table
function set_custom_contact_submission_columns($columns) {
    $new_columns = array(
        'cb'            => $columns['cb'],
        'title'         => __('Name', _THEME_DOMAIN),
        'email'         => __('Email', _THEME_DOMAIN),
        'phone'         => __('Phone', _THEME_DOMAIN),
        'subject'       => __('Subject', _THEME_DOMAIN),
        'email_status'  => __('Email Status', _THEME_DOMAIN),
        'date'          => __('Date Received', _THEME_DOMAIN),
    );
    return $new_columns;
}
add_filter('manage_contact_submission_posts_columns', 'set_custom_contact_submission_columns');

// Populate Custom Columns Data
function custom_contact_submission_column_data($column, $post_id) {
    switch ($column) {
        case 'email':
            $email = get_post_meta($post_id, '_submission_email', true);
            echo !empty($email) ? '<a href="mailto:' . esc_attr($email) . '">' . esc_html($email) . '</a>' : '—';
            break;
        case 'phone':
            $phone = get_post_meta($post_id, '_submission_phone', true);
            echo !empty($phone) ? esc_html($phone) : '—';
            break;
        case 'subject':
            $subject = get_post_meta($post_id, '_submission_subject', true);
            echo !empty($subject) ? esc_html($subject) : '—';
            break;
        case 'email_status':
            $admin_status = get_post_meta($post_id, '_admin_email_status', true);
            $admin_err    = get_post_meta($post_id, '_admin_email_error', true);
            $user_status  = get_post_meta($post_id, '_user_email_status', true);
            $user_err     = get_post_meta($post_id, '_user_email_error', true);

            echo '<div style="display:flex; flex-direction:column; gap:4px; font-size:12px; min-width:140px;">';

            // Admin Status Badge
            echo '<div style="display:flex; align-items:center; gap:6px;">';
            echo '<strong style="color:#555; width:45px;">Admin:</strong>';
            if ($admin_status === 'Sent') {
                echo '<span style="background:#d1e7dd; color:#0f5132; padding:2px 8px; border-radius:10px; font-weight:600; font-size:11px;">✓ Sent</span>';
            } elseif ($admin_status === 'Failed') {
                echo '<span style="background:#f8d7da; color:#842029; padding:2px 8px; border-radius:10px; font-weight:600; font-size:11px;" title="' . esc_attr($admin_err) . '">✗ Not Sent</span>';
            } else {
                echo '<span style="background:#fff3cd; color:#664d03; padding:2px 8px; border-radius:10px; font-weight:600; font-size:11px;" title="No delivery record found">✗ Not Sent</span>';
            }
            echo '</div>';

            // User Auto-Reply Status Badge
            echo '<div style="display:flex; align-items:center; gap:6px;">';
            echo '<strong style="color:#555; width:45px;">User:</strong>';
            if ($user_status === 'Sent') {
                echo '<span style="background:#d1e7dd; color:#0f5132; padding:2px 8px; border-radius:10px; font-weight:600; font-size:11px;">✓ Sent</span>';
            } elseif ($user_status === 'Failed') {
                echo '<span style="background:#f8d7da; color:#842029; padding:2px 8px; border-radius:10px; font-weight:600; font-size:11px;" title="' . esc_attr($user_err) . '">✗ Not Sent</span>';
            } else {
                echo '<span style="background:#fff3cd; color:#664d03; padding:2px 8px; border-radius:10px; font-weight:600; font-size:11px;" title="No delivery record found">✗ Not Sent</span>';
            }
            echo '</div>';

            echo '</div>';
            break;
    }
}
add_action('manage_contact_submission_posts_custom_column', 'custom_contact_submission_column_data', 10, 2);

// Make columns sortable
function set_contact_submission_sortable_columns($columns) {
    $columns['email'] = 'email';
    $columns['subject'] = 'subject';
    return $columns;
}
add_filter('manage_edit-contact_submission_sortable_columns', 'set_contact_submission_sortable_columns');

// Add "Resend Emails" action link in row actions
function microlink_contact_submission_row_actions($actions, $post) {
    if ($post->post_type === 'contact_submission') {
        unset($actions['inline hide-if-no-js']); // Remove quick edit
        $resend_url = wp_nonce_url(
            admin_url('admin-post.php?action=microlink_resend_submission_emails&post_id=' . $post->ID),
            'microlink_resend_email_' . $post->ID
        );
        $actions['resend_email'] = '<a href="' . esc_url($resend_url) . '" style="color:#0d6efd; font-weight:600;"><span class="dashicons dashicons-email-alt" style="font-size:14px; vertical-align:middle; width:14px; height:14px;"></span> ' . __('Resend Emails', _THEME_DOMAIN) . '</a>';
    }
    return $actions;
}
add_filter('post_row_actions', 'microlink_contact_submission_row_actions', 10, 2);

// Handle Resend Emails action
function microlink_handle_resend_submission_emails() {
    if (!current_user_can('manage_options')) {
        wp_die(__('Unauthorized action', _THEME_DOMAIN));
    }
    $post_id = isset($_GET['post_id']) ? intval($_GET['post_id']) : 0;
    check_admin_referer('microlink_resend_email_' . $post_id);

    if ($post_id > 0) {
        $name    = get_post_meta($post_id, '_submission_name', true) ?: get_the_title($post_id);
        $email   = get_post_meta($post_id, '_submission_email', true);
        $phone   = get_post_meta($post_id, '_submission_phone', true);
        $subject = get_post_meta($post_id, '_submission_subject', true) ?: 'Contact Inquiry';
        $message = get_post_meta($post_id, '_submission_message', true);
        $ip      = get_post_meta($post_id, '_submission_ip', true) ?: 'Unknown';

        // 1. Resend Admin email
        $admin_recipients = get_option('microlink_admin_notification_email');
        if (empty($admin_recipients)) {
            $admin_recipients = get_option('microlink_smtp_from_email', get_option('admin_email')) ?: 'info@microlink.co.in';
        }
        if ($admin_recipients === 'pnaresh776@gmail.com') {
            $admin_recipients = 'info@microlink.co.in';
        }

        $from_email = get_option('microlink_smtp_from_email', 'info@microlink.co.in');
        if ($from_email === 'pnaresh776@gmail.com') {
            $from_email = 'info@microlink.co.in';
        }
        $from_name = get_option('microlink_smtp_from_name', get_bloginfo('name'));
        $site_name = get_bloginfo('name');

        $email_fields = array(
            'Sender Name'  => $name,
            'Email'        => $email,
            'Phone'        => !empty($phone) ? $phone : 'Not provided',
            'Subject'      => $subject,
            'Submitted On' => get_the_date('F j, Y g:i a', $post_id),
            'IP Address'   => $ip,
            'Message'      => $message,
        );
        $admin_content = custom_get_styled_email_template('New Contact Inquiry Received', $email_fields, 'Notification sent from ' . $site_name);
        $admin_headers = array(
            'Content-Type: text/html; charset=UTF-8',
            'From: ' . $from_name . ' <' . $from_email . '>',
            'Reply-To: ' . $name . ' <' . $email . '>',
        );
        $admin_emails = array_filter(array_map('trim', explode(',', $admin_recipients)));
        if (empty($admin_emails)) {
            $admin_emails = array('info@microlink.co.in');
        }
        $admin_sent = wp_mail($admin_emails, 'New Contact Inquiry: ' . $subject, $admin_content, $admin_headers);
        update_post_meta($post_id, '_admin_email_status', $admin_sent ? 'Sent' : 'Failed');
        if (!$admin_sent) {
            $last_err = get_option('microlink_last_mail_error');
            update_post_meta($post_id, '_admin_email_error', is_array($last_err) ? ($last_err['message'] ?? 'wp_mail returned false') : 'wp_mail returned false');
        } else {
            delete_post_meta($post_id, '_admin_email_error');
        }

        // 2. Resend User confirmation email
        $user_sent = false;
        if (!empty($email) && is_email($email)) {
            $user_fields = array(
                'Dear'            => $name,
                'Status'          => 'We have received your message and our team will get back to you shortly.',
                'Your Subject'    => $subject,
                'Reference ID'    => '#' . $post_id,
            );
            $user_content = custom_get_styled_email_template('Thank You for Contacting Us', $user_fields, 'Thank you for reaching out to ' . $site_name);
            $user_headers = array(
                'Content-Type: text/html; charset=UTF-8',
                'From: ' . $from_name . ' <' . $from_email . '>',
            );
            $user_sent = wp_mail($email, 'Thank you for reaching out to ' . $site_name, $user_content, $user_headers);
            update_post_meta($post_id, '_user_email_status', $user_sent ? 'Sent' : 'Failed');
            if (!$user_sent) {
                $last_err = get_option('microlink_last_mail_error');
                update_post_meta($post_id, '_user_email_error', is_array($last_err) ? ($last_err['message'] ?? 'wp_mail returned false') : 'wp_mail returned false');
            } else {
                delete_post_meta($post_id, '_user_email_error');
            }
        }

        $redirect = add_query_arg(array(
            'post_type'       => 'contact_submission',
            'resend_result'   => ($admin_sent && $user_sent) ? 'success' : 'failed',
            'admin_status'    => $admin_sent ? 'sent' : 'failed',
            'user_status'     => $user_sent ? 'sent' : 'failed',
        ), admin_url('edit.php'));
        wp_safe_redirect($redirect);
        exit;
    }
}
add_action('admin_post_microlink_resend_submission_emails', 'microlink_handle_resend_submission_emails');

// Resend Admin Notice
function microlink_submission_resend_admin_notice() {
    if (isset($_GET['resend_result']) && isset($_GET['post_type']) && $_GET['post_type'] === 'contact_submission') {
        $admin_ok = (isset($_GET['admin_status']) && $_GET['admin_status'] === 'sent');
        $user_ok  = (isset($_GET['user_status']) && $_GET['user_status'] === 'sent');
        if ($admin_ok && $user_ok) {
            echo '<div class="notice notice-success is-dismissible"><p><strong>Success!</strong> Both Admin Notification and User Auto-Reply emails were resent successfully.</p></div>';
        } else {
            $last_err = get_option('microlink_last_mail_error');
            $msg = is_array($last_err) ? ($last_err['message'] ?? '') : '';
            echo '<div class="notice notice-warning is-dismissible"><p><strong>Email Resend Notice:</strong> Admin Email: <strong>' . ($admin_ok ? 'Sent' : 'Failed') . '</strong> | User Auto-Reply: <strong>' . ($user_ok ? 'Sent' : 'Failed') . '</strong>' . ($msg ? ' &mdash; <em>' . esc_html($msg) . '</em>' : '') . '</p></div>';
        }
    }
}
add_action('admin_notices', 'microlink_submission_resend_admin_notice');

// Add Submission Meta Box Details View
function add_contact_submission_meta_box() {
    add_meta_box(
        'contact_submission_details',
        __('Submission Details', _THEME_DOMAIN),
        'render_contact_submission_meta_box',
        'contact_submission',
        'normal',
        'high'
    );
}
add_action('add_meta_boxes', 'add_contact_submission_meta_box');

function render_contact_submission_meta_box($post) {
    $name         = get_post_meta($post->ID, '_submission_name', true) ?: $post->post_title;
    $email        = get_post_meta($post->ID, '_submission_email', true);
    $phone        = get_post_meta($post->ID, '_submission_phone', true);
    $subject      = get_post_meta($post->ID, '_submission_subject', true);
    $message      = get_post_meta($post->ID, '_submission_message', true);
    $ip           = get_post_meta($post->ID, '_submission_ip', true);
    $date         = get_the_date('F j, Y g:i a', $post);
    $admin_status = get_post_meta($post->ID, '_admin_email_status', true);
    $admin_err    = get_post_meta($post->ID, '_admin_email_error', true);
    $user_status  = get_post_meta($post->ID, '_user_email_status', true);
    $user_err     = get_post_meta($post->ID, '_user_email_error', true);

    $resend_url = wp_nonce_url(
        admin_url('admin-post.php?action=microlink_resend_submission_emails&post_id=' . $post->ID),
        'microlink_resend_email_' . $post->ID
    );
    ?>
    <style>
        .submission-detail-table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        .submission-detail-table th { width: 22%; text-align: left; padding: 10px; background: #f8f9fa; border-bottom: 1px solid #e2e8f0; font-weight: 600; }
        .submission-detail-table td { padding: 10px; border-bottom: 1px solid #e2e8f0; vertical-align: top; }
        .submission-message-box { background: #fdfdfd; border: 1px solid #e2e8f0; padding: 15px; border-radius: 6px; white-space: pre-wrap; line-height: 1.6; }
    </style>
    <div style="margin-bottom: 15px; display: flex; justify-content: flex-end;">
        <a href="<?php echo esc_url($resend_url); ?>" class="button button-secondary">
            <span class="dashicons dashicons-email-alt" style="vertical-align: text-bottom;"></span> <?php _e('Resend Notification & Auto-Reply', _THEME_DOMAIN); ?>
        </a>
    </div>
    <table class="submission-detail-table">
        <tr>
            <th><?php _e('Full Name', _THEME_DOMAIN); ?></th>
            <td><strong><?php echo esc_html($name); ?></strong></td>
        </tr>
        <tr>
            <th><?php _e('Email Address', _THEME_DOMAIN); ?></th>
            <td><a href="mailto:<?php echo esc_attr($email); ?>"><?php echo esc_html($email); ?></a></td>
        </tr>
        <tr>
            <th><?php _e('Phone Number', _THEME_DOMAIN); ?></th>
            <td><?php echo !empty($phone) ? esc_html($phone) : '<em>Not provided</em>'; ?></td>
        </tr>
        <tr>
            <th><?php _e('Subject', _THEME_DOMAIN); ?></th>
            <td><?php echo esc_html($subject); ?></td>
        </tr>
        <tr>
            <th><?php _e('Admin Notification', _THEME_DOMAIN); ?></th>
            <td>
                <?php if ($admin_status === 'Sent'): ?>
                    <span style="color:#0f5132; font-weight:600;">✓ Successfully Sent to Admin</span>
                <?php elseif ($admin_status === 'Failed'): ?>
                    <span style="color:#842029; font-weight:600;">✗ Failed / Not Sent</span>
                    <?php if (!empty($admin_err)): ?>
                        <div style="color:#842029; font-size:12px; margin-top:4px;">Reason: <code><?php echo esc_html($admin_err); ?></code></div>
                    <?php endif; ?>
                <?php else: ?>
                    <span style="color:#856404; background:#fff3cd; padding:2px 8px; border-radius:10px; font-size:12px; font-weight:600;">✗ Not Sent (No record)</span>
                <?php endif; ?>
            </td>
        </tr>
        <tr>
            <th><?php _e('User Auto-Reply', _THEME_DOMAIN); ?></th>
            <td>
                <?php if ($user_status === 'Sent'): ?>
                    <span style="color:#0f5132; font-weight:600;">✓ Successfully Sent to Sender (<?php echo esc_html($email); ?>)</span>
                <?php elseif ($user_status === 'Failed'): ?>
                    <span style="color:#842029; font-weight:600;">✗ Failed / Not Sent</span>
                    <?php if (!empty($user_err)): ?>
                        <div style="color:#842029; font-size:12px; margin-top:4px;">Reason: <code><?php echo esc_html($user_err); ?></code></div>
                    <?php endif; ?>
                <?php else: ?>
                    <span style="color:#856404; background:#fff3cd; padding:2px 8px; border-radius:10px; font-size:12px; font-weight:600;">✗ Not Sent (No record)</span>
                <?php endif; ?>
            </td>
        </tr>
        <tr>
            <th><?php _e('Submission Date', _THEME_DOMAIN); ?></th>
            <td><?php echo esc_html($date); ?></td>
        </tr>
        <tr>
            <th><?php _e('IP Address', _THEME_DOMAIN); ?></th>
            <td><code><?php echo esc_html($ip ?: 'N/A'); ?></code></td>
        </tr>
        <tr>
            <th><?php _e('Message', _THEME_DOMAIN); ?></th>
            <td>
                <div class="submission-message-box"><?php echo esc_html($message); ?></div>
            </td>
        </tr>
    </table>
    <?php
}

