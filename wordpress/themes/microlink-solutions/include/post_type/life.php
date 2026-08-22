<?php
// Register Custom Post Type: Life @ Microlink
function create_life_microlink_cpt() {

    $labels = array(
        'name'               => __('Life @ Microlink', _THEME_DOMAIN),
        'singular_name'      => __('Life Item', _THEME_DOMAIN),
        'menu_name'          => __('Life @ Microlink', _THEME_DOMAIN),
        'add_new'            => __('Add New Media', _THEME_DOMAIN),
        'add_new_item'       => __('Add New Life Media', _THEME_DOMAIN),
        'edit_item'          => __('Edit Life Media', _THEME_DOMAIN),
        'new_item'           => __('New Life Media', _THEME_DOMAIN),
        'view_item'          => __('View Life Media', _THEME_DOMAIN),
        'all_items'          => __('All Life Media', _THEME_DOMAIN),
        'search_items'       => __('Search Media', _THEME_DOMAIN),
        'not_found'          => __('No media found', _THEME_DOMAIN),
    );

    $args = array(
        'label'              => __('Life @ Microlink', _THEME_DOMAIN),
        'labels'             => $labels,
        'public'             => true,
        'menu_icon'          => 'dashicons-format-image',
        'supports'           => array('title'),
        'has_archive'        => true,
        'rewrite'            => array('slug' => 'life-at-microlink'),
        'show_in_rest'       => true,
    );

    register_post_type('life_microlink', $args);
}
add_action('init', 'create_life_microlink_cpt');

// Register Custom Taxonomy for Life Media Categories (Photos / Videos)
function create_life_taxonomy() {
    register_taxonomy('life_category', 'life_microlink', array(
        'label'        => __('Life Categories', _THEME_DOMAIN),
        'labels'       => array(
            'name'          => __('Life Categories', _THEME_DOMAIN),
            'singular_name' => __('Life Category', _THEME_DOMAIN),
            'add_new_item'  => __('Add New Category', _THEME_DOMAIN),
        ),
        'hierarchical' => true,
        'rewrite'      => array('slug' => 'life-category'),
        'show_in_rest' => true,
    ));
}
add_action('init', 'create_life_taxonomy');

// Enqueue WP Media Scripts for Admin
function microlink_life_admin_media_scripts($hook) {
    global $post_type;
    if ($post_type === 'life_microlink') {
        wp_enqueue_media();
    }
}
add_action('admin_enqueue_scripts', 'microlink_life_admin_media_scripts');

// Add Meta Box for Media Details (Media Type, Photo URL, Video URL with Gallery Picker)
function add_life_media_meta_box() {
    add_meta_box(
        'life_media_details',
        __('Media Source Options (Media Gallery or Direct URL)', _THEME_DOMAIN),
        'render_life_media_meta_box',
        'life_microlink',
        'normal',
        'high'
    );
}
add_action('add_meta_boxes', 'add_life_media_meta_box');

function render_life_media_meta_box($post) {
    wp_nonce_field('save_life_media_meta', 'life_media_meta_nonce');

    $media_type = get_post_meta($post->ID, '_life_media_type', true) ?: 'photo';
    $photo_url  = get_post_meta($post->ID, '_life_photo_url', true) ?: '';
    $video_url  = get_post_meta($post->ID, '_life_video_url', true) ?: '';
    ?>

    <p style="margin-bottom: 20px;">
        <label for="life_media_type"><strong><?php _e('Media Category / Type', _THEME_DOMAIN); ?>:</strong></label><br>
        <select name="life_media_type" id="life_media_type" style="width:100%; max-width:400px; padding:6px;">
            <option value="photo" <?php selected($media_type, 'photo'); ?>><?php _e('Photo', _THEME_DOMAIN); ?></option>
            <option value="video" <?php selected($media_type, 'video'); ?>><?php _e('Video', _THEME_DOMAIN); ?></option>
        </select>
    </p>

    <!-- PHOTO MEDIA SOURCE -->
    <div id="life_photo_section" style="background:#f9f9f9; padding:15px; border:1px solid #e5e5e5; border-radius:6px; margin-bottom:20px;">
        <label for="life_photo_url"><strong><?php _e('Photo Source URL', _THEME_DOMAIN); ?>:</strong></label>
        <p style="margin:5px 0 10px; color:#666;">Choose a photo from your <strong>WordPress Media Library</strong> or type/paste a <strong>Direct Image URL</strong> below (Featured Image will be used as fallback if blank).</p>
        <div style="display:flex; gap:10px; align-items:center;">
            <input type="text" name="life_photo_url" id="life_photo_url" value="<?php echo esc_attr($photo_url); ?>" class="widefat" placeholder="https://domain.com/uploads/photo.jpg">
            <button type="button" class="button button-secondary microlink-media-upload-btn" data-target="#life_photo_url">
                📁 Choose from Media Gallery
            </button>
        </div>
    </div>

    <!-- VIDEO MEDIA SOURCE -->
    <div id="life_video_section" style="background:#f9f9f9; padding:15px; border:1px solid #e5e5e5; border-radius:6px; margin-bottom:20px;">
        <label for="life_video_url"><strong><?php _e('Video Source URL', _THEME_DOMAIN); ?>:</strong></label>
        <p style="margin:5px 0 10px; color:#666;">Select an MP4 video from your <strong>Media Library</strong> OR enter a direct video link (YouTube, Vimeo, MP4 URL).</p>
        <div style="display:flex; gap:10px; align-items:center;">
            <input type="text" name="life_video_url" id="life_video_url" value="<?php echo esc_attr($video_url); ?>" class="widefat" placeholder="https://www.youtube.com/watch?v=... or MP4 URL">
            <button type="button" class="button button-secondary microlink-media-upload-btn" data-target="#life_video_url">
                🎥 Choose from Media Gallery
            </button>
        </div>
    </div>

    <script>
    jQuery(document).ready(function($) {
        // Toggle view based on media type
        function toggleMediaFields() {
            var val = $('#life_media_type').val();
            if (val === 'video') {
                $('#life_video_section').show();
            } else {
                $('#life_video_section').show();
            }
        }
        $('#life_media_type').on('change', toggleMediaFields);
        toggleMediaFields();

        // WordPress Media Uploader Modal Handler
        $(document).on('click', '.microlink-media-upload-btn', function(e) {
            e.preventDefault();
            var btn = $(this);
            var targetSelector = btn.data('target');
            var targetInput = $(targetSelector);

            var mediaFrame = wp.media({
                title: 'Select or Upload Media File',
                button: { text: 'Use Selected Media' },
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

function save_life_media_meta_box($post_id) {
    if (!isset($_POST['life_media_meta_nonce']) || !wp_verify_nonce($_POST['life_media_meta_nonce'], 'save_life_media_meta')) {
        return;
    }
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
        return;
    }
    if (!current_user_can('edit_post', $post_id)) {
        return;
    }

    if (isset($_POST['life_media_type'])) {
        update_post_meta($post_id, '_life_media_type', sanitize_text_field($_POST['life_media_type']));
    }
    if (isset($_POST['life_photo_url'])) {
        update_post_meta($post_id, '_life_photo_url', esc_url_raw($_POST['life_photo_url']));
    }
    if (isset($_POST['life_video_url'])) {
        update_post_meta($post_id, '_life_video_url', esc_url_raw($_POST['life_video_url']));
    }
}
add_action('save_post_life_microlink', 'save_life_media_meta_box');
