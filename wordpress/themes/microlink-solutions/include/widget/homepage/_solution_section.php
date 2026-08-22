<?php
// Hero Section Widget
class Home_Solution_Section_Widget extends WP_Widget {

    function __construct() {
        parent::__construct(
            'home_solution_section',
            __('Homepage :: Solution Section', _THEME_DOMAIN),
            array('description' => __('Update solution section content', _THEME_DOMAIN))
        );
    }

    // Frontend Output
    public function widget($args, $instance) {
        echo $args['before_widget'];
        ?>

        <section class="solution-section-02 section-gap double-gap">
            <div class="container">
                <div class="row align-items-center mb-sm-5 mb-4">
                    <div class="col-md-8">
                        <h2 class="cm-title text-black fs-40 mb-2">Explore our <span> Solutions</span> For your business need</h2>
                        <p class="text-muted">Digital transformation that brings value on the table</p>
                    </div>
                    <div class="col-md-4 text-md-end mt-3 mt-md-0">
                        <a href="/solutions" class="btn btn-primary">View All Solution</a>
                    </div>
                </div>
                <div class="owl-carousel owl-theme">
                    <?php
                    $query = new WP_Query([
                        'post_type' => 'solution',
                        'posts_per_page' => -1,
                        'meta_query' => [
                            [
                                'key' => 'is_primary_page',
                                'value' => '1',
                                'compare' => '='
                            ]
                        ]
                    ]);

                    if ($query->have_posts()) :
                        while ($query->have_posts()) : $query->the_post();

                            $image = get_the_post_thumbnail_url(get_the_ID(), 'full');
                            $title = get_the_title();
                            $desc  = get_post_meta(get_the_ID(), 'short_descirption', true);
                            $link  = get_permalink();

                            // Optional: ACF repeater (solution_list)
                            $list_items = get_post_meta(get_the_ID(), 'categories', true);
                    ?>

                    <div class="item">
                        <div class="solution-item">
                            <figure class="thumbnail-container object-fit">
                                <div class="thumbnail">
                                    <img src="<?php echo esc_url($image); ?>" alt="">
                                </div>
                            </figure>
                            <div class="solution-content d-flex flex-column h-100">
                                <div class="flex-grow-1">
                                    <h3 class="mb-3">
                                        <a href="<?php echo esc_url($link); ?>" class="text-white"><?php echo esc_html($title); ?></a>
                                    </h3>
                                    <p class="text-white mb-3"><?php echo esc_html($desc); ?></p>

                                    <div class="solution-list mt-4s">
                                        <?php echo html_entity_decode($list_items ?? ''); ?>
                                    </div>
                                </div>
                                <div class="solution-btn">
                                    <a href="<?php echo esc_url($link); ?>" class="btn btn-primary">Read more</a>
                                </div>
                            </div>
                        </div>
                    </div>

                    <?php
                        endwhile;
                        wp_reset_postdata();
                    endif;
                    ?>
                </div>
            </div>
        </section>

        <?php echo $args['after_widget'];
    }

    // Backend Form (unchanged)
    public function form($instance) { ?>
        <p><strong>Solutions are automatically fetched from CPT (solution)</strong></p>
    <?php }

    // Save Data (unchanged)
    public function update($new_instance, $old_instance) {
        return [];
    }
}

// Register Widget
function register_home_solution_section_widget() {
    register_widget('Home_Solution_Section_Widget');
}
add_action('widgets_init', 'register_home_solution_section_widget');