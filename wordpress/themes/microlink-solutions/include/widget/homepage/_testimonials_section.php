<?php
// Hero Section Widget
class Home_Testimonials_Section_Widget extends WP_Widget {

    function __construct() {
        parent::__construct(
            'home_testimonials_section',
            __('Homepage :: Testimonials Section', _THEME_DOMAIN),
            array('description' => __('Update testimonials section content', _THEME_DOMAIN))
        );
    }

    // Frontend Output
    public function widget($args, $instance) {
        echo $args['before_widget'];
        ?>

        <section class="testimonial-section common-owl section-gap bg-light double-gap overflow-hidden">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-lg-8 text-center mb-5">
                        <h2 class="cm-title text-black fs-40 mb-2">What Our <span>Clients Say</span></h2>
                        <p class="text-muted mt-3">
                            Lorem ipsum dolor sit amet consectetur adipisicing elit. Quisquam, quae.
                        </p>
                    </div>
                    <div class="circle-animation business">
                        <div class="circle-animation business-2">
                            <span class="tp-circle-8"></span>
                            <span class="tp-circle-6"></span>
                            <div class="circle-animation business-3"><span class="tp-circle-7"></span></div>
                            <div class="circle-animation business-4"><span class="tp-circle-5"></span></div>
                        </div>
                    </div>
                    <div class="col-lg-10">
                        <div class="owl-carousel testimonial-carousel">

                            <?php
                            $testimonials = new WP_Query([
                                'post_type' => 'testimonial',
                                'posts_per_page' => 6
                            ]);

                            if ($testimonials->have_posts()) :
                                while ($testimonials->have_posts()) : $testimonials->the_post();

                                    $img = get_the_post_thumbnail_url(get_the_ID(), 'full');
                                    $img = $img ?: get_template_directory_uri().'/assets/images/testimonials.png';

                                    $name = get_the_title();
                                    $designation = get_post_meta(get_the_ID(), '_testimonial_designation', true);
                                    $text = wp_trim_words(get_the_content(), 40);
                            ?>

                            <div class="testimonial-item text-center">
                                <div class="img mx-auto">
                                    <img src="<?php echo esc_url($img); ?>" alt="" width="88" height="66">
                                </div>
                                <h5 class=".client-name mt-4 pt-xl-3"><?php echo esc_html($name); ?></h5>
                                <?php if(!empty($designation)) { ?>
                                    <p class="client-designation">(<?php echo esc_html($designation); ?>)</p>
                                <?php } else { ?>
                                    <p class="client-designation">&nbsp;</p>
                                <?php } ?>
                                <p class="testimonial-text">
                                    <?php echo esc_html($text); ?>
                                </p>
                            </div>

                            <?php
                                endwhile;
                                wp_reset_postdata();
                            endif;
                            ?>

                        </div>
                    </div>
                </div>
            </div>
        </section>
        
        <?php echo $args['after_widget'];
    }

    // Backend Form (UNCHANGED)
    public function form($instance) { ?>
        <p><strong>Testimonials are automatically fetched from CPT (testimonial)</strong></p>
    <?php }

    // Save Data (UNCHANGED)
    public function update($new_instance, $old_instance) {
        $instance = [];
        return $instance;
    }
}

// Register Widget
function register_home_testimonials_section_widget() {
    register_widget('Home_Testimonials_Section_Widget');
}
add_action('widgets_init', 'register_home_testimonials_section_widget');