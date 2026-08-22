<?php
// Home Service Section Widget (Fully Dynamic & Attractive UI)
class Home_Service_Section_Widget extends WP_Widget {
    function __construct() {
        parent::__construct(
            'home_service_section',
            __('Homepage :: Service Section', _THEME_DOMAIN),
            array('description' => __('Update homepage service section content', _THEME_DOMAIN))
        );
    }

    // Frontend Output
    public function widget($args, $instance) {
        echo $args['before_widget'];

        $title    = !empty($instance['title']) ? $instance['title'] : 'Our Services <span>IT Services</span>';
        $subtitle = !empty($instance['subtitle']) ? $instance['subtitle'] : 'Our engineers will work 24*7 to provide you seamless IT Operations';
        ?>
        <section class="service-cards-section section-gap bg-light">
            <div class="container">
                <div class="row justify-content-center section-intro mb-lg-4 mb-3" data-aos="fade-up" data-aos-delay="80">
                    <div class="col-lg-8 text-center">
                        <h2 class="cm-title fs-40 text-black"><?php echo wp_kses_post($title); ?></h2>
                        <p class="text-muted mt-2 mb-0"><?php echo esc_html($subtitle); ?></p>
                    </div>
                </div>

                <div class="owl-carousel services-owl pb-lg-4 pb-3">
                    <?php
                    // Query primary page services first, fallback to all services if none flagged primary
                    $services = new WP_Query([
                        'post_type'      => 'service',
                        'posts_per_page' => -1,
                        'orderby'        => 'menu_order title',
                        'order'          => 'ASC',
                        'meta_query'     => [
                            [
                                'key'     => 'is_primary_page',
                                'value'   => '1',
                                'compare' => '='
                            ]
                        ]
                    ]);

                    if (!$services->have_posts()) {
                        $services = new WP_Query([
                            'post_type'      => 'service',
                            'posts_per_page' => -1,
                            'orderby'        => 'menu_order title',
                            'order'          => 'ASC'
                        ]);
                    }

                    if ($services->have_posts()) :
                        $delay = 100;

                        while ($services->have_posts()) : $services->the_post();

                            $service_title = get_the_title();
                            $desc          = get_post_meta(get_the_ID(), '_service_short_desc', true);
                            $icon          = get_post_meta(get_the_ID(), '_service_icon', true) ?: 's-cybersecurity-solutions';
                            $list          = get_post_meta(get_the_ID(), 'services_list', true);
                            $link          = get_permalink();
                    ?>

                    <div class="item">
                        <div class="service-card c-card h-100 p-4 bg-white rounded-3 d-flex flex-column" data-aos="fade-up" data-aos-delay="<?php echo esc_attr($delay); ?>">
                            <div class="d-flex align-items-center mb-3">
                                <div class="service-icon bg-soft me-3">
                                    <i class="n-icon text-primary"
                                       data-icon="<?php echo esc_attr($icon); ?>"
                                       data-iconwidth="30px"
                                       data-iconheight="30px"></i>
                                </div>
                                <h5 class="m-0 fw-bold fs-5 text-black"><?php echo esc_html($service_title); ?></h5>
                            </div>

                            <?php if (!empty($desc)) : ?>
                                <p class="text-muted small mb-3"><?php echo esc_html($desc); ?></p>
                            <?php endif; ?>

                            <?php if (!empty($list)) : ?>
                                <div class="service-list-content mb-3">
                                    <?php echo html_entity_decode($list); ?>
                                </div>
                            <?php endif; ?>

                            <div class="mt-auto pt-2">
                                <a href="<?php echo esc_url($link); ?>" class="btn btn-link button-up p-0 text-decoration-none fw-bold" title="Read More">Read More</a>
                            </div>
                        </div>
                    </div>

                    <?php
                        $delay += 40;
                        endwhile;
                        wp_reset_postdata();
                    else :
                        echo '<div class="col-12 text-center text-muted"><p>No services available.</p></div>';
                    endif;
                    ?>

                </div>
            </div>
        </section>
        
        <?php echo $args['after_widget'];
    }

    // Backend Form
    public function form($instance) {
        $title    = $instance['title'] ?? '';
        $subtitle = $instance['subtitle'] ?? '';
        ?>
        <p>
            <label>Section Title (HTML allowed e.g. &lt;span&gt;)</label>
            <input class="widefat" name="<?php echo $this->get_field_name('title'); ?>" value="<?php echo esc_attr($title); ?>">
        </p>
        <p>
            <label>Section Subtitle</label>
            <textarea class="widefat" rows="2" name="<?php echo $this->get_field_name('subtitle'); ?>"><?php echo esc_textarea($subtitle); ?></textarea>
        </p>
    <?php }

    // Save Data
    public function update($new_instance, $old_instance) {
        $instance = [];
        $instance['title']    = !empty($new_instance['title']) ? wp_kses_post($new_instance['title']) : '';
        $instance['subtitle'] = !empty($new_instance['subtitle']) ? sanitize_textarea_field($new_instance['subtitle']) : '';
        return $instance;
    }
}

// Register Widget
function register_home_service_section_widget() {
    register_widget('Home_Service_Section_Widget');
}
add_action('widgets_init', 'register_home_service_section_widget');