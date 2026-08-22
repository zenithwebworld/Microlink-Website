<?php
// Hero Section Widget
class Home_Hero_Section_Widget extends WP_Widget {

    function __construct() {
        parent::__construct(
            'home_hero_section',
            __('Homepage :: Hero Section', _THEME_DOMAIN),
            array('description' => __('Update hero section content', _THEME_DOMAIN))
        );
    }

    // Frontend Output
    public function widget($args, $instance) {
        echo $args['before_widget'];

        // Get options
        $banner_image_1 = !empty($instance['banner_image_1']) ? $instance['banner_image_1'] : '';
        $banner_image_2 = !empty($instance['banner_image_2']) ? $instance['banner_image_2'] : '';
        $banner_video = !empty($instance['banner_video']) ? $instance['banner_video'] : '';
        ?>

        <section class="banner-section">
            <div class="video-thumb">
                <img class="lazy banner-bg-1" src="<?php echo $banner_image_1; ?>" alt="<?php bloginfo('name'); ?>" width="87" height="25">
                <img class="lazy banner-bg-2" src="<?php echo $banner_image_2; ?>" alt="<?php bloginfo('name'); ?>" width="87" height="25">
                <div class="thumbnail-container object-fit">
                    <div class="thumbnail">
                        <video src="<?php echo $banner_video; ?>" type="video/mp4" autoplay loop muted></video>
                    </div>
                    <div class="caption">
                        <div class="container">
                            <div class="row">
                                <div class="col-lg-8 col-xxl-6">
                                    <div id="home-banner-03" class="carousel slide carousel-fade"
                                        data-bs-ride="carousel" data-bs-interval="4000" data-bs-pause="string"
                                        data-bs-wrap="true">
                                        <div class="carousel-inner">
                                            <div class="carousel-item active">
                                                <h2 class="cm-title">A Premier Systems Integrator <span> & Your
                                                        Technology Partner</span></h2>
                                                <h6 class="banner-text fw-normal mt-4">We empower businesses to thrive
                                                    in the digital era through secure, scalable IT infrastructure and
                                                    cybersecurity solutions. From design and deployment to ongoing
                                                    services that ensure smooth, secure, and uninterrupted IT
                                                    operations.</h6>
                                                <a class="btn btn-primary mt-lg-5 mt-4" href="#" title="Book Now">Book
                                                    Now</a>
                                            </div>
                                            <div class="carousel-item">
                                                <h2 class="cm-title">Ready for <br><span> Digital Transformation?</span>
                                                </h2>
                                                <h6 class="banner-text fw-normal mt-4">Book a free 30-minute
                                                    consultation and elevate the journey to modernize your IT systems.
                                                </h6>
                                                <a class="btn btn-primary mt-lg-5 mt-4" href="contact_us.html"
                                                    title="Book Now">Book Now</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        
        <?php echo $args['after_widget'];
    }

    // Backend Form
    public function form($instance) {
        $banner_image_1 = !empty($instance['banner_image_1']) ? $instance['banner_image_1'] : '';
        $banner_image_2 = !empty($instance['banner_image_2']) ? $instance['banner_image_2'] : '';
        $banner_video = !empty($instance['banner_video']) ? $instance['banner_video'] : '';
        ?>

        <p>
            <label>Slider Image 1</label>
            <input class="widefat" type="text" name="<?php echo $this->get_field_name('banner_image_1'); ?>" value="<?php echo esc_attr($banner_image_1); ?>">
        </p>
        <p>
            <label>Slider Image 2</label>
            <input class="widefat" type="text" name="<?php echo $this->get_field_name('banner_image_2'); ?>" value="<?php echo esc_attr($banner_image_2); ?>">
        </p>
        <p>
            <label>Slider Video</label>
            <input class="widefat" type="text" name="<?php echo $this->get_field_name('banner_video'); ?>" value="<?php echo esc_attr($banner_video); ?>">
        </p>
    <?php }

    // Save Data
    public function update($new_instance, $old_instance) {
        $instance = [];

        $instance['banner_image_1'] = (!empty($new_instance['banner_image_1'])) ? strip_tags($new_instance['banner_image_1']) : '';
        $instance['banner_image_2'] = (!empty($new_instance['banner_image_2'])) ? strip_tags($new_instance['banner_image_2']) : '';
        $instance['banner_video'] = (!empty($new_instance['banner_video'])) ? strip_tags($new_instance['banner_video']) : '';
        
        return $instance;
    }
}

// Register Widget
function register_home_hero_section_widget() {
    register_widget('Home_Hero_Section_Widget');
}
add_action('widgets_init', 'register_home_hero_section_widget');