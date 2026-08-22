<?php
// Hero Section Widget
class Home_Service_Section_Widget extends WP_Widget {
    function __construct() {
        parent::__construct(
            'home_service_section',
            __('Homepage :: Service Section', _THEME_DOMAIN),
            array('description' => __('Update service section content', _THEME_DOMAIN))
        );
    }

    // Frontend Output
    public function widget($args, $instance) {
        echo $args['before_widget'];
        ?>
        <section class="service-cards-section section-gap double-gap-t bg-light">
            <div class="container">
                <div class="row justify-content-center section-intro mb-lg-5 mb-4" data-aos="fade-up"
                    data-aos-delay="80">
                    <div class="col-lg-8 text-center">
                        <h2 class="cm-title fs-40 text-black">Our Srevices<span> IT Services</span></h2>
                        <p class="text-muted mt-3">Our engineers will work 24*7 to provide you seamless IT Operations
                        </p>
                    </div>
                </div>

                <div class="owl-carousel services-owl pb-lg-5 pb-4">

                    <?php
                    $services = new WP_Query([
                        'post_type' => 'service',
                        'posts_per_page' => 6,
                        'orderby' => 'menu_order',
                        'order' => 'ASC',
                        'meta_query' => [
                            [
                                'key' => 'is_primary_page',
                                'value' => '1',
                                'compare' => '='
                            ]
                        ]
                    ]);

                    if ($services->have_posts()) :
                        $delay = 100;

                        while ($services->have_posts()) : $services->the_post();

                            $title = get_the_title();
                            $desc = get_post_meta(get_the_ID(), '_service_short_desc', true);
                            $icon = get_post_meta(get_the_ID(), '_service_icon', true);
                            $list = get_post_meta(get_the_ID(), 'services_list', true);
                            $link = get_permalink();

                            // Feature list (textarea → explode)
                            $features_raw = get_post_meta(get_the_ID(), '_service_features', true);
                            $features = !empty($features_raw) ? explode("\n", $features_raw) : [];
                    ?>

                    <div class="item">
                        <div class="service-card c-card h-100" data-aos="fade-up" data-aos-delay="<?php echo esc_attr($delay); ?>">
                            <div class="service-icon bg-soft me-3">
                                <i class="n-icon text-primary"
                                   data-icon="<?php echo esc_attr($icon); ?>"
                                   data-iconwidth="35px"
                                   data-iconheight="35px"></i>
                            </div>
                            <h5 class="mt-3"><?php echo esc_html($title); ?></h5>
                            <p class="text-muted"><?php echo esc_html($desc); ?></p>

                            <?php echo html_entity_decode($list); ?>

                            <div>
                                <a href="<?php echo esc_url($link); ?>" class="btn btn-link button-up mt-4" title="Read More">Read More</a>
                            </div>
                        </div>
                    </div>

                    <?php
                        $delay += 40;
                        endwhile;
                        wp_reset_postdata();
                    endif;
                    ?>

                </div>
            </div>
        </section>
        
        <?php echo $args['after_widget'];
    }

    // Backend Form (UNCHANGED)
    public function form($instance) { ?>
        <p><strong>Solutions are automatically fetched from CPT (solution)</strong></p>
    <?php }

    // Save Data (UNCHANGED)
    public function update($new_instance, $old_instance) {
        $instance = [];
        return $instance;
    }
}

// Register Widget
function register_home_service_section_widget() {
    register_widget('Home_Service_Section_Widget');
}
add_action('widgets_init', 'register_home_service_section_widget');