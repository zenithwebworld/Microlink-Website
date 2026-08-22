<?php
// Register Custom Post Type: Solution
function create_solution_cpt() {

    $labels = array(
        'name'           => __('Solutions', _THEME_DOMAIN),
        'singular_name'  => __('Solution', _THEME_DOMAIN),
        'menu_name'      => __('Solutions', _THEME_DOMAIN),
        'name_admin_bar' => __('Solution', _THEME_DOMAIN),
        'add_new'        => __('Add New', _THEME_DOMAIN),
        'add_new_item'   => __('Add New Solution', _THEME_DOMAIN),
        'edit_item'      => __('Edit Solution', _THEME_DOMAIN),
        'new_item'       => __('New Solution', _THEME_DOMAIN),
        'view_item'      => __('View Solution', _THEME_DOMAIN),
        'all_items'      => __('All Solutions', _THEME_DOMAIN),
        'search_items'   => __('Search Solutions', _THEME_DOMAIN),
        'not_found'      => __('No solutions found.', _THEME_DOMAIN),
    );

    $args = array(
        'label'          => __('Solution', _THEME_DOMAIN),
        'labels'         => $labels,
        'public'         => true,
        'menu_icon'      => 'dashicons-admin-generic',
        'supports'       => array('title', 'editor', 'thumbnail'),
        'has_archive'    => true,
        'rewrite'        => array('slug' => 'solutions'),
        'show_in_rest'   => true,
    );

    register_post_type('solution', $args);
}
add_action('init', 'create_solution_cpt');

// Register Custom Taxonomy
function create_solution_taxonomy() {

    register_taxonomy('solution_category', 'solution', array(
        'label'        => __('Solution Categories', _THEME_DOMAIN),
        'hierarchical' => true,
        'rewrite'      => array('slug' => 'solution-category'),
        'show_in_rest' => true,
    ));
}
add_action('init', 'create_solution_taxonomy');

// Enqueue WP Media Scripts for Admin
function microlink_solution_admin_media_scripts($hook) {
    global $post_type;
    if ($post_type === 'solution') {
        wp_enqueue_media();
    }
}
add_action('admin_enqueue_scripts', 'microlink_solution_admin_media_scripts');

// Add Meta Box for Solution Options
function add_solution_meta_boxes() {
    add_meta_box(
        'solution_details_meta',
        __('Solution Details & Media Options', _THEME_DOMAIN),
        'render_solution_meta_box',
        'solution',
        'normal',
        'high'
    );
}
add_action('add_meta_boxes', 'add_solution_meta_boxes');

function render_solution_meta_box($post) {
    wp_nonce_field('save_solution_meta', 'solution_meta_nonce');

    $icon          = get_post_meta($post->ID, '_solution_icon', true) ?: 's-cybersecurity-solutions';
    $short_desc    = get_post_meta($post->ID, '_solution_short_desc', true) ?: '';
    $banner_url    = get_post_meta($post->ID, '_solution_banner_url', true) ?: '';
    $is_primary    = get_post_meta($post->ID, 'is_primary_page', true) ?: '0';
    ?>

    <p style="margin-bottom:15px;">
        <label for="is_primary_page">
            <input type="checkbox" name="is_primary_page" id="is_primary_page" value="1" <?php checked($is_primary, '1'); ?>>
            <strong><?php _e('Show in Homepage Primary Solutions Showcase', _THEME_DOMAIN); ?></strong>
        </label>
    </p>

    <p style="margin-bottom:15px;">
        <label for="_solution_icon"><strong><?php _e('SVG Icon Identifier (e.g. s-cybersecurity-solutions, s-software-development)', _THEME_DOMAIN); ?>:</strong></label><br>
        <input type="text" name="_solution_icon" id="_solution_icon" value="<?php echo esc_attr($icon); ?>" class="widefat">
    </p>

    <p style="margin-bottom:15px;">
        <label for="_solution_short_desc"><strong><?php _e('Short Description / Subtitle', _THEME_DOMAIN); ?>:</strong></label><br>
        <textarea name="_solution_short_desc" id="_solution_short_desc" class="widefat" rows="2"><?php echo esc_textarea($short_desc); ?></textarea>
    </p>

    <div style="background:#f9f9f9; padding:15px; border:1px solid #e5e5e5; border-radius:6px;">
        <label for="_solution_banner_url"><strong><?php _e('Banner Image URL (Optional - Media Gallery or Direct URL)', _THEME_DOMAIN); ?>:</strong></label>
        <p style="margin:5px 0 10px; color:#666;"><?php _e('Select a custom banner from WordPress Media Library OR paste a Direct Image URL.', _THEME_DOMAIN); ?></p>
        <div style="display:flex; gap:10px; align-items:center;">
            <input type="text" name="_solution_banner_url" id="_solution_banner_url" value="<?php echo esc_attr($banner_url); ?>" class="widefat" placeholder="https://domain.com/uploads/banner.jpg">
            <button type="button" class="button button-secondary microlink-media-upload-btn" data-target="#_solution_banner_url">
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
                title: 'Select or Upload Banner Image',
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

function save_solution_meta_box($post_id) {
    if (!isset($_POST['solution_meta_nonce']) || !wp_verify_nonce($_POST['solution_meta_nonce'], 'save_solution_meta')) {
        return;
    }
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
        return;
    }
    if (!current_user_can('edit_post', $post_id)) {
        return;
    }

    update_post_meta($post_id, 'is_primary_page', isset($_POST['is_primary_page']) ? '1' : '0');

    if (isset($_POST['_solution_icon'])) {
        update_post_meta($post_id, '_solution_icon', sanitize_text_field($_POST['_solution_icon']));
    }
    if (isset($_POST['_solution_short_desc'])) {
        update_post_meta($post_id, '_solution_short_desc', sanitize_textarea_field($_POST['_solution_short_desc']));
    }
    if (isset($_POST['_solution_banner_url'])) {
        update_post_meta($post_id, '_solution_banner_url', esc_url_raw($_POST['_solution_banner_url']));
    }
}
add_action('save_post_solution', 'save_solution_meta_box');