<?php
// Register Custom Post Type: Service
function create_service_cpt() {

    $labels = array(
        'name'           => __('Services', _THEME_DOMAIN),
        'singular_name'  => __('Service', _THEME_DOMAIN),
        'menu_name'      => __('Services', _THEME_DOMAIN),
        'name_admin_bar' => __('Service', _THEME_DOMAIN),
        'add_new'        => __('Add New', _THEME_DOMAIN),
        'add_new_item'   => __('Add New Service', _THEME_DOMAIN),
        'edit_item'      => __('Edit Service', _THEME_DOMAIN),
        'new_item'       => __('New Service', _THEME_DOMAIN),
        'view_item'      => __('View Service', _THEME_DOMAIN),
        'all_items'      => __('All Services', _THEME_DOMAIN),
        'search_items'   => __('Search Services', _THEME_DOMAIN),
        'not_found'      => __('No services found.', _THEME_DOMAIN),
    );

    $args = array(
        'label'          => __('Services', _THEME_DOMAIN),
        'labels'         => $labels,
        'public'         => true,
        'menu_icon'      => 'dashicons-admin-tools',
        'supports'       => array('title', 'editor', 'thumbnail'),
        'has_archive'    => true,
        'rewrite'        => array('slug' => 'services'),
        'show_in_rest'   => true,
    );

    register_post_type('service', $args);
}
add_action('init', 'create_service_cpt');

// Register Custom Taxonomy
function create_service_taxonomy() {
    register_taxonomy('service_category', 'service', array(
        'label'        => __('Service Categories', _THEME_DOMAIN),
        'hierarchical' => true,
        'rewrite'      => array('slug' => 'service-category'),
        'show_in_rest' => true,
    ));
}
add_action('init', 'create_service_taxonomy');