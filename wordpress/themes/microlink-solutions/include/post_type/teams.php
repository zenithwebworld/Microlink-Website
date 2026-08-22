<?php
// Register Custom Post Type: Team
function create_team_cpt() {

    $labels = array(
        'name'           => __('Team Members', _THEME_DOMAIN),
        'singular_name'  => __('Team Member', _THEME_DOMAIN),
        'menu_name'      => __('Team', _THEME_DOMAIN),
        'name_admin_bar' => __('Team Member', _THEME_DOMAIN),
        'add_new'        => __('Add New', _THEME_DOMAIN),
        'add_new_item'   => __('Add New Team Member', _THEME_DOMAIN),
        'edit_item'      => __('Edit Team Member', _THEME_DOMAIN),
        'new_item'       => __('New Team Member', _THEME_DOMAIN),
        'view_item'      => __('View Team Member', _THEME_DOMAIN),
        'all_items'      => __('All Team Members', _THEME_DOMAIN),
        'search_items'   => __('Search Team', _THEME_DOMAIN),
        'not_found'      => __('No team members found.', _THEME_DOMAIN),
    );

    $args = array(
        'label'          => __('Team', _THEME_DOMAIN),
        'labels'         => $labels,
        'public'         => true,
        'menu_icon'      => 'dashicons-groups',
        'supports'       => array('title', 'editor', 'thumbnail', 'page-attributes'),
        'has_archive'    => false,
        'rewrite'        => array('slug' => 'team'),
        'show_in_rest'   => true,
    );

    register_post_type('team', $args);
}
add_action('init', 'create_team_cpt');