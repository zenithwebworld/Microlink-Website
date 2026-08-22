<?php
// Hero Section Widget
class Home_Partner_Section_Widget extends WP_Widget {

    function __construct() {
        parent::__construct(
            'home_partner_section',
            __('Homepage :: Partner Section', _THEME_DOMAIN),
            array('description' => __('Update partner section content', _THEME_DOMAIN))
        );
    }

    // Frontend Output
    public function widget($args, $instance) {
        echo $args['before_widget']; ?>

        <section class="section-gap double-gap partner-section">
            <img class="lazy banner-bg-1" src="<?php echo site_url('wp-content/uploads/2026/03/banner-bg-1.png'); ?>" alt="" title="" width="87" height="25">
            <img class="lazy banner-bg-2" src="<?php echo site_url('wp-content/uploads/2026/03/banner-bg-2.png'); ?>" alt="" title="" width="87" height="25">
            <div class="container-fluid">
                <div class="row justify-content-center">
                    <div class="col-xl-5 mb-5 text-center" data-aos="fade-up" data-aos-delay="80">
                        <h2 class="cm-title fs-40 mb-3">
                            Meet Our esteemed <span>Clients</span>
                        </h2>
                        <p class="text-white">
                            Meet some of our esteemed clientele from across industries including Pharma & Hospitals, Manufacturing & Retail, Government & Public Sector, Hotel & Hospitality, and Educational Institutes. We are proud to deliver reliable solutions that build lasting partnerships and drive success.
                        </p>
                    </div>
                    <div class="col-12">
                        <div class="partner-marquee-slider overflow-hidden d-flex" data-aos="fade-left"
                            data-aos-delay="120">
                            <div class="display-1 text-white text-uppercase text-nowrap d-flex align-items-center">
                                <?php
                                $partners = new WP_Query([
                                    'post_type' => 'partner',
                                    'posts_per_page' => -1
                                ]);

                                if ($partners->have_posts()) :
                                    while ($partners->have_posts()) : $partners->the_post();
                                        $logo = get_the_post_thumbnail_url(get_the_ID(), 'full');
                                ?>

                                <span>
                                    <img src="<?php echo esc_url($logo); ?>" alt="<?php the_title(); ?>" title="<?php the_title(); ?>" width="891" height="594">
                                </span>

                                <?php
                                    endwhile;
                                    wp_reset_postdata();
                                endif;
                                ?>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        
        <?php echo $args['after_widget'];
    }

    // Backend Form (UNCHANGED)
    public function form($instance) { ?>
        <p><strong>Partners are automatically fetched from CPT (partners)</strong></p>
    <?php }

    // Save Data (UNCHANGED)
    public function update($new_instance, $old_instance) {
        $instance = [];
        return $instance;
    }
}

// Register Widget
function register_home_partner_section_widget() {
    register_widget('Home_Partner_Section_Widget');
}
add_action('widgets_init', 'register_home_partner_section_widget');