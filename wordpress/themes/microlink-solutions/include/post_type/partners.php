<?php
// Register Custom Post Type: Partners
function create_partners_cpt() {

    $labels = array(
        'name'           => __('Partners', _THEME_DOMAIN),
        'singular_name'  => __('Partner', _THEME_DOMAIN),
        'menu_name'      => __('Partners', _THEME_DOMAIN),
        'name_admin_bar' => __('Partner', _THEME_DOMAIN),
        'add_new'        => __('Add New', _THEME_DOMAIN),
        'add_new_item'   => __('Add New Partner', _THEME_DOMAIN),
        'edit_item'      => __('Edit Partner', _THEME_DOMAIN),
        'new_item'       => __('New Partner', _THEME_DOMAIN),
        'view_item'      => __('View Partner', _THEME_DOMAIN),
        'all_items'      => __('All Partners', _THEME_DOMAIN),
        'search_items'   => __('Search Partners', _THEME_DOMAIN),
        'not_found'      => __('No partners found.', _THEME_DOMAIN),
    );

    $args = array(
        'label'          => __('Partners', _THEME_DOMAIN),
        'labels'         => $labels,
        'public'         => true,
        'menu_icon'      => 'dashicons-groups',
        'supports'       => array('title', 'thumbnail'),
        'has_archive'    => false,
        'rewrite'        => array('slug' => 'partners'),
        'show_in_rest'   => true,
    );

    register_post_type('partner', $args);
}
add_action('init', 'create_partners_cpt');

// Register Custom Taxonomy
function create_partner_taxonomy() {
    register_taxonomy('partner_category', 'partner', array(
        'label'        => __('Partner Categories', _THEME_DOMAIN),
        'hierarchical' => true,
        'rewrite'      => array('slug' => 'partner-category'),
        'show_in_rest' => true,
    ));
}
add_action('init', 'create_partner_taxonomy');