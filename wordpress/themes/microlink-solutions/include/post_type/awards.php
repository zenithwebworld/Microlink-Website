<?php
// Register Custom Post Type: Awards & Recognition
function create_awards_cpt() {

    $labels = array(
        'name'               => __('Awards & Recognition', _THEME_DOMAIN),
        'singular_name'      => __('Award', _THEME_DOMAIN),
        'menu_name'          => __('Awards & Recognition', _THEME_DOMAIN),
        'add_new'            => __('Add New Award', _THEME_DOMAIN),
        'add_new_item'       => __('Add New Award', _THEME_DOMAIN),
        'edit_item'          => __('Edit Award', _THEME_DOMAIN),
        'new_item'           => __('New Award', _THEME_DOMAIN),
        'view_item'          => __('View Award', _THEME_DOMAIN),
        'all_items'          => __('All Awards', _THEME_DOMAIN),
        'search_items'       => __('Search Awards', _THEME_DOMAIN),
        'not_found'          => __('No awards found', _THEME_DOMAIN),
    );

    $args = array(
        'label'              => __('Awards & Recognition', _THEME_DOMAIN),
        'labels'             => $labels,
        'public'             => true,
        'menu_icon'          => 'dashicons-awards',
        'supports'           => array('title'),
        'has_archive'        => true,
        'rewrite'            => array('slug' => 'awards-recognition'),
        'show_in_rest'       => true,
    );

    register_post_type('award', $args);
}
add_action('init', 'create_awards_cpt');

// Register Custom Taxonomy for Award Categories
function create_award_taxonomy() {
    register_taxonomy('award_category', 'award', array(
        'label'        => __('Award Categories', _THEME_DOMAIN),
        'labels'       => array(
            'name'          => __('Award Categories', _THEME_DOMAIN),
            'singular_name' => __('Award Category', _THEME_DOMAIN),
            'add_new_item'  => __('Add New Category', _THEME_DOMAIN),
        ),
        'hierarchical' => true,
        'rewrite'      => array('slug' => 'award-category'),
        'show_in_rest' => true,
    ));
}
add_action('init', 'create_award_taxonomy');

// Enqueue WP Media Scripts for Award Post Type Admin
function microlink_award_admin_media_scripts($hook) {
    global $post_type;
    if ($post_type === 'award') {
        wp_enqueue_media();
    }
}
add_action('admin_enqueue_scripts', 'microlink_award_admin_media_scripts');

// Add Meta Box for Award Media Details
function add_award_meta_box() {
    add_meta_box(
        'award_details',
        __('Award Image & Details (Media Gallery or Direct URL)', _THEME_DOMAIN),
        'render_award_meta_box',
        'award',
        'normal',
        'high'
    );
}
add_action('add_meta_boxes', 'add_award_meta_box');

function render_award_meta_box($post) {
    wp_nonce_field('save_award_meta', 'award_meta_nonce');

    $image_url = get_post_meta($post->ID, '_award_image_url', true) ?: '';
    $subtitle  = get_post_meta($post->ID, '_award_subtitle', true) ?: '';
    ?>

    <p style="margin-bottom:15px;">
        <label for="award_subtitle"><strong><?php _e('Award Subtitle / Year / Organization', _THEME_DOMAIN); ?>:</strong></label><br>
        <input type="text" name="award_subtitle" id="award_subtitle" value="<?php echo esc_attr($subtitle); ?>" class="widefat" placeholder="e.g. Excellence Award 2025 | Tech Leaders">
    </p>

    <div style="background:#f9f9f9; padding:15px; border:1px solid #e5e5e5; border-radius:6px;">
        <label for="award_image_url"><strong><?php _e('Award Image Source URL', _THEME_DOMAIN); ?>:</strong></label>
        <p style="margin:5px 0 10px; color:#666;"><?php _e('Choose an image from your WordPress Media Library OR paste a Direct Image URL.', _THEME_DOMAIN); ?></p>
        <div style="display:flex; gap:10px; align-items:center;">
            <input type="text" name="award_image_url" id="award_image_url" value="<?php echo esc_attr($image_url); ?>" class="widefat" placeholder="https://domain.com/uploads/award.jpg">
            <button type="button" class="button button-secondary microlink-media-upload-btn" data-target="#award_image_url">
                📁 Choose from Media Gallery
            </button>
        </div>
    </div>

    <script>
    jQuery(document).ready(function($) {
        $(document).on('click', '.microlink-media-upload-btn', function(e) {
            e.preventDefault();
            var btn = $(this);
            var targetInput = $($(this).data('target'));

            var mediaFrame = wp.media({
                title: 'Select or Upload Award Image',
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

function save_award_meta_box($post_id) {
    if (!isset($_POST['award_meta_nonce']) || !wp_verify_nonce($_POST['award_meta_nonce'], 'save_award_meta')) {
        return;
    }
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
        return;
    }
    if (!current_user_can('edit_post', $post_id)) {
        return;
    }

    if (isset($_POST['award_image_url'])) {
        update_post_meta($post_id, '_award_image_url', esc_url_raw($_POST['award_image_url']));
    }
    if (isset($_POST['award_subtitle'])) {
        update_post_meta($post_id, '_award_subtitle', sanitize_text_field($_POST['award_subtitle']));
    }
}
add_action('save_post_award', 'save_award_meta_box');
