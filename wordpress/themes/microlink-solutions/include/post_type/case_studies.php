<?php
// Register Custom Post Type: Case Study
function create_case_study_cpt() {

    $labels = array(
        'name'               => __('Case Studies', _THEME_DOMAIN),
        'singular_name'      => __('Case Study', _THEME_DOMAIN),
        'menu_name'          => __('Case Studies', _THEME_DOMAIN),
        'name_admin_bar'     => __('Case Study', _THEME_DOMAIN),
        'add_new'            => __('Add New Case Study', _THEME_DOMAIN),
        'add_new_item'       => __('Add New Case Study', _THEME_DOMAIN),
        'edit_item'          => __('Edit Case Study', _THEME_DOMAIN),
        'new_item'           => __('New Case Study', _THEME_DOMAIN),
        'view_item'          => __('View Case Study', _THEME_DOMAIN),
        'all_items'          => __('All Case Studies', _THEME_DOMAIN),
        'search_items'       => __('Search Case Studies', _THEME_DOMAIN),
        'not_found'          => __('No case studies found.', _THEME_DOMAIN),
    );

    $args = array(
        'label'              => __('Case Study', _THEME_DOMAIN),
        'labels'             => $labels,
        'public'             => true,
        'menu_icon'          => 'dashicons-portfolio',
        'supports'           => array('title', 'editor', 'thumbnail', 'excerpt'),
        'has_archive'        => true,
        'rewrite'            => array('slug' => 'case-studies'),
        'show_in_rest'       => true,
    );

    register_post_type('case_study', $args);
}
add_action('init', 'create_case_study_cpt');

// Register Custom Taxonomy: Case Study Category
function create_case_study_taxonomy() {
    register_taxonomy('case_study_category', 'case_study', array(
        'label'        => __('Case Study Categories', _THEME_DOMAIN),
        'hierarchical' => true,
        'rewrite'      => array('slug' => 'case-study-category'),
        'show_in_rest' => true,
    ));
}
add_action('init', 'create_case_study_taxonomy');

// Enqueue WP Media Scripts in Admin for Case Study
function microlink_case_study_admin_media_scripts($hook) {
    global $post_type;
    if ($post_type === 'case_study') {
        wp_enqueue_media();
    }
}
add_action('admin_enqueue_scripts', 'microlink_case_study_admin_media_scripts');

// Add Meta Box for Case Study Options
function add_case_study_meta_boxes() {
    add_meta_box(
        'case_study_details_meta',
        __('Case Study Details & Options', _THEME_DOMAIN),
        'render_case_study_meta_box',
        'case_study',
        'normal',
        'high'
    );
}
add_action('add_meta_boxes', 'add_case_study_meta_boxes');

function render_case_study_meta_box($post) {
    wp_nonce_field('save_case_study_meta', 'case_study_meta_nonce');

    $badge_1       = get_post_meta($post->ID, 'badge_1', true) ?: 'Digital Transformation';
    $badge_2       = get_post_meta($post->ID, 'badge_2', true) ?: 'Cloud Security';
    $client_name   = get_post_meta($post->ID, 'client_name', true) ?: '';
    $pdf_url       = get_post_meta($post->ID, 'pdf_url', true) ?: '';
    $custom_image  = get_post_meta($post->ID, 'custom_image_url', true) ?: '';
    ?>

    <p style="margin-bottom:15px;">
        <label for="badge_1"><strong><?php _e('Category Badge / Tag 1', _THEME_DOMAIN); ?>:</strong></label><br>
        <input type="text" name="badge_1" id="badge_1" value="<?php echo esc_attr($badge_1); ?>" class="widefat" placeholder="e.g. Cloud Security">
    </p>

    <p style="margin-bottom:15px;">
        <label for="badge_2"><strong><?php _e('Category Badge / Tag 2', _THEME_DOMAIN); ?>:</strong></label><br>
        <input type="text" name="badge_2" id="badge_2" value="<?php echo esc_attr($badge_2); ?>" class="widefat" placeholder="e.g. Healthcare">
    </p>

    <p style="margin-bottom:15px;">
        <label for="client_name"><strong><?php _e('Client / Company Name', _THEME_DOMAIN); ?>:</strong></label><br>
        <input type="text" name="client_name" id="client_name" value="<?php echo esc_attr($client_name); ?>" class="widefat" placeholder="e.g. Leading Financial Enterprise">
    </p>

    <p style="margin-bottom:15px;">
        <label for="pdf_url"><strong><?php _e('PDF / External Case Study URL (Optional)', _THEME_DOMAIN); ?>:</strong></label><br>
        <input type="url" name="pdf_url" id="pdf_url" value="<?php echo esc_attr($pdf_url); ?>" class="widefat" placeholder="https://domain.com/case-study.pdf">
    </p>

    <div style="background:#f9f9f9; padding:15px; border:1px solid #e5e5e5; border-radius:6px;">
        <label for="custom_image_url"><strong><?php _e('Card Image (Media Gallery or Direct URL)', _THEME_DOMAIN); ?>:</strong></label>
        <p style="margin:5px 0 10px; color:#666;"><?php _e('Choose an image from WordPress Media Gallery OR enter a direct URL.', _THEME_DOMAIN); ?></p>
        <div style="display:flex; gap:10px; align-items:center;">
            <input type="text" name="custom_image_url" id="custom_image_url" value="<?php echo esc_attr($custom_image); ?>" class="widefat" placeholder="https://domain.com/uploads/case-study.jpg">
            <button type="button" class="button button-secondary microlink-case-study-media-btn" data-target="#custom_image_url">
                📁 Choose from Media Gallery
            </button>
        </div>
    </div>

    <script>
    jQuery(document).ready(function($) {
        $(document).on('click', '.microlink-case-study-media-btn', function(e) {
            e.preventDefault();
            var targetInput = $($(this).data('target'));
            var mediaFrame = wp.media({
                title: 'Select Case Study Image',
                button: { text: 'Use Selected Image' },
                multiple: false
            });
            mediaFrame.on('select', function() {
                var attachment = mediaFrame.state().get('selection').first().toJSON();
                if (attachment && attachment.url) {
                    targetInput.val(attachment.url);
                }
            });
            mediaFrame.open();
        });
    });
    </script>
    <?php
}

function save_case_study_meta_box($post_id) {
    if (!isset($_POST['case_study_meta_nonce']) || !wp_verify_nonce($_POST['case_study_meta_nonce'], 'save_case_study_meta')) {
        return;
    }
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
        return;
    }
    if (!current_user_can('edit_post', $post_id)) {
        return;
    }

    if (isset($_POST['badge_1'])) {
        update_post_meta($post_id, 'badge_1', sanitize_text_field($_POST['badge_1']));
    }
    if (isset($_POST['badge_2'])) {
        update_post_meta($post_id, 'badge_2', sanitize_text_field($_POST['badge_2']));
    }
    if (isset($_POST['client_name'])) {
        update_post_meta($post_id, 'client_name', sanitize_text_field($_POST['client_name']));
    }
    if (isset($_POST['pdf_url'])) {
        update_post_meta($post_id, 'pdf_url', esc_url_raw($_POST['pdf_url']));
    }
    if (isset($_POST['custom_image_url'])) {
        update_post_meta($post_id, 'custom_image_url', esc_url_raw($_POST['custom_image_url']));
    }
}
add_action('save_post_case_study', 'save_case_study_meta_box');
