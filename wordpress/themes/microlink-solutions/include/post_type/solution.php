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