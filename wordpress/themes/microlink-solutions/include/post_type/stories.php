<?php
// Register Custom Post Type: Stories
function create_stories_cpt() {

    $labels = array(
        'name'               => __('Stories', _THEME_DOMAIN),
        'singular_name'      => __('Story', _THEME_DOMAIN),
        'menu_name'          => __('Stories', _THEME_DOMAIN),
        'add_new'            => __('Add New Story', _THEME_DOMAIN),
        'add_new_item'       => __('Add New Story', _THEME_DOMAIN),
        'edit_item'          => __('Edit Story', _THEME_DOMAIN),
        'new_item'           => __('New Story', _THEME_DOMAIN),
        'view_item'          => __('View Story', _THEME_DOMAIN),
        'all_items'          => __('All Stories', _THEME_DOMAIN),
        'search_items'       => __('Search Stories', _THEME_DOMAIN),
    );

    $args = array(
        'label'              => __('Stories', _THEME_DOMAIN),
        'labels'             => $labels,
        'public'             => true,
        'menu_icon'          => 'dashicons-format-gallery',
        'supports'           => array('title', 'editor', 'thumbnail'),
        'has_archive'        => true,
        'rewrite'            => array('slug' => 'stories'),
        'show_in_rest'       => true,
    );

    register_post_type('story', $args);
}
add_action('init', 'create_stories_cpt');