<?php
function create_jobs_cpt() {

    register_post_type('job', [
        'label' => 'Jobs',
        'public' => true,
        'menu_icon' => 'dashicons-id',
        'supports' => ['title', 'editor'],
        'has_archive' => true,
        'rewrite' => ['slug' => 'careers'],
        'show_in_rest' => true,
    ]);

}
add_action('init', 'create_jobs_cpt');