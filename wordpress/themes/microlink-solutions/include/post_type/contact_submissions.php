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
        'cb'        => $columns['cb'],
        'title'     => __('Name', _THEME_DOMAIN),
        'email'     => __('Email', _THEME_DOMAIN),
        'phone'     => __('Phone', _THEME_DOMAIN),
        'subject'   => __('Subject', _THEME_DOMAIN),
        'date'      => __('Date Received', _THEME_DOMAIN),
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
    $name    = get_post_meta($post->ID, '_submission_name', true) ?: $post->post_title;
    $email   = get_post_meta($post->ID, '_submission_email', true);
    $phone   = get_post_meta($post->ID, '_submission_phone', true);
    $subject = get_post_meta($post->ID, '_submission_subject', true);
    $message = get_post_meta($post->ID, '_submission_message', true);
    $ip      = get_post_meta($post->ID, '_submission_ip', true);
    $date    = get_the_date('F j, Y g:i a', $post);
    ?>
    <style>
        .submission-detail-table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        .submission-detail-table th { width: 20%; text-align: left; padding: 10px; background: #f8f9fa; border-bottom: 1px solid #e2e8f0; font-weight: 600; }
        .submission-detail-table td { padding: 10px; border-bottom: 1px solid #e2e8f0; vertical-align: top; }
        .submission-message-box { background: #fdfdfd; border: 1px solid #e2e8f0; padding: 15px; border-radius: 6px; white-space: pre-wrap; line-height: 1.6; }
    </style>
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

