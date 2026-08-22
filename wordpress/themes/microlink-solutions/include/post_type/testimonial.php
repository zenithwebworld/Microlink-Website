<?php
// Register Custom Post Type: Testimonial
function create_testimonial_cpt() {

    $labels = array(
        'name'           => __('Testimonials', _THEME_DOMAIN),
        'singular_name'  => __('Testimonial', _THEME_DOMAIN),
        'menu_name'      => __('Testimonials', _THEME_DOMAIN),
        'name_admin_bar' => __('Testimonial', _THEME_DOMAIN),
        'add_new'        => __('Add New', _THEME_DOMAIN),
        'add_new_item'   => __('Add New Testimonial', _THEME_DOMAIN),
        'edit_item'      => __('Edit Testimonial', _THEME_DOMAIN),
        'new_item'       => __('New Testimonial', _THEME_DOMAIN),
        'view_item'      => __('View Testimonial', _THEME_DOMAIN),
        'all_items'      => __('All Testimonials', _THEME_DOMAIN),
        'search_items'   => __('Search Testimonials', _THEME_DOMAIN),
        'not_found'      => __('No testimonials found.', _THEME_DOMAIN),
    );

    $args = array(
        'label'          => __('Testimonials', _THEME_DOMAIN),
        'labels'         => $labels,
        'public'         => true,
        'menu_icon'      => 'dashicons-testimonial',
        'supports'       => array('title', 'editor', 'thumbnail'),
        'has_archive'    => false,
        'rewrite'        => array('slug' => 'testimonials'),
        'show_in_rest'   => true,
    );

    register_post_type('testimonial', $args);
}
add_action('init', 'create_testimonial_cpt');