<?php
// Register Custom Post Type: Clients
function create_clients_cpt() {

    $labels = array(
        'name'           => __('Clients', _THEME_DOMAIN),
        'singular_name'  => __('Client', _THEME_DOMAIN),
        'menu_name'      => __('Clients', _THEME_DOMAIN),
        'name_admin_bar' => __('Client', _THEME_DOMAIN),
        'add_new'        => __('Add New', _THEME_DOMAIN),
        'add_new_item'   => __('Add New Client', _THEME_DOMAIN),
        'edit_item'      => __('Edit Client', _THEME_DOMAIN),
        'new_item'       => __('New Client', _THEME_DOMAIN),
        'view_item'      => __('View Client', _THEME_DOMAIN),
        'all_items'      => __('All Clients', _THEME_DOMAIN),
        'search_items'   => __('Search Clients', _THEME_DOMAIN),
        'not_found'      => __('No clients found.', _THEME_DOMAIN),
    );

    $args = array(
        'label'          => __('Clients', _THEME_DOMAIN),
        'labels'         => $labels,
        'public'         => true,
        'menu_icon'      => 'dashicons-businessman',
        'supports'       => array('title', 'thumbnail'),
        'has_archive'    => false,
        'rewrite'        => array('slug' => 'clients'),
        'show_in_rest'   => true,
    );

    register_post_type('client', $args);
}
add_action('init', 'create_clients_cpt');

// Register Custom Taxonomy
function create_client_taxonomy() {
    register_taxonomy('client_category', 'client', array(
        'label'        => __('Client Categories', _THEME_DOMAIN),
        'hierarchical' => true,
        'rewrite'      => array('slug' => 'client-category'),
        'show_in_rest' => true,
    ));
}
add_action('init', 'create_client_taxonomy');
