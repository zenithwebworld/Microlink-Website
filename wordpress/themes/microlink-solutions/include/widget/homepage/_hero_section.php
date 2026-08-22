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

        $slide1_title = !empty($instance['slide1_title']) ? $instance['slide1_title'] : 'A Premier Systems Integrator <span> & Your Technology Partner</span>';
        $slide1_text = !empty($instance['slide1_text']) ? $instance['slide1_text'] : 'We empower businesses to thrive in the digital era through secure, scalable IT infrastructure and cybersecurity solutions.';
        $slide1_btn_text = !empty($instance['slide1_btn_text']) ? $instance['slide1_btn_text'] : 'Book Now';
        $slide1_btn_link = !empty($instance['slide1_btn_link']) ? $instance['slide1_btn_link'] : home_url('/contact');

        $slide2_title = !empty($instance['slide2_title']) ? $instance['slide2_title'] : 'Ready for <br><span> Digital Transformation?</span>';
        $slide2_text = !empty($instance['slide2_text']) ? $instance['slide2_text'] : 'Book a free 30-minute consultation and elevate the journey to modernize your IT systems.';
        $slide2_btn_text = !empty($instance['slide2_btn_text']) ? $instance['slide2_btn_text'] : 'Book Now';
        $slide2_btn_link = !empty($instance['slide2_btn_link']) ? $instance['slide2_btn_link'] : home_url('/contact');
        ?>

        <section class="banner-section">
            <div class="video-thumb">
                <img class="lazy banner-bg-1" src="<?php echo esc_url($banner_image_1); ?>" alt="<?php bloginfo('name'); ?>" width="87" height="25">
                <img class="lazy banner-bg-2" src="<?php echo esc_url($banner_image_2); ?>" alt="<?php bloginfo('name'); ?>" width="87" height="25">
                <div class="thumbnail-container object-fit">
                    <div class="thumbnail">
                        <video src="<?php echo esc_url($banner_video); ?>" type="video/mp4" autoplay loop muted></video>
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
                                                <h2 class="cm-title"><?php echo wp_kses_post($slide1_title); ?></h2>
                                                <h6 class="banner-text fw-normal mt-4"><?php echo esc_html($slide1_text); ?></h6>
                                                <?php if (!empty($slide1_btn_text)) : ?>
                                                    <a class="btn btn-primary mt-lg-5 mt-4" href="<?php echo esc_url($slide1_btn_link); ?>" title="<?php echo esc_attr($slide1_btn_text); ?>">
                                                        <?php echo esc_html($slide1_btn_text); ?>
                                                    </a>
                                                <?php endif; ?>
                                            </div>
                                            <div class="carousel-item">
                                                <h2 class="cm-title"><?php echo wp_kses_post($slide2_title); ?></h2>
                                                <h6 class="banner-text fw-normal mt-4"><?php echo esc_html($slide2_text); ?></h6>
                                                <?php if (!empty($slide2_btn_text)) : ?>
                                                    <a class="btn btn-primary mt-lg-5 mt-4" href="<?php echo esc_url($slide2_btn_link); ?>" title="<?php echo esc_attr($slide2_btn_text); ?>">
                                                        <?php echo esc_html($slide2_btn_text); ?>
                                                    </a>
                                                <?php endif; ?>
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
        $banner_image_1  = $instance['banner_image_1'] ?? '';
        $banner_image_2  = $instance['banner_image_2'] ?? '';
        $banner_video    = $instance['banner_video'] ?? '';

        $slide1_title    = $instance['slide1_title'] ?? '';
        $slide1_text     = $instance['slide1_text'] ?? '';
        $slide1_btn_text = $instance['slide1_btn_text'] ?? '';
        $slide1_btn_link = $instance['slide1_btn_link'] ?? '';

        $slide2_title    = $instance['slide2_title'] ?? '';
        $slide2_text     = $instance['slide2_text'] ?? '';
        $slide2_btn_text = $instance['slide2_btn_text'] ?? '';
        $slide2_btn_link = $instance['slide2_btn_link'] ?? '';
        ?>

        <p>
            <label>Slider Image 1 URL</label>
            <input class="widefat" type="text" name="<?php echo $this->get_field_name('banner_image_1'); ?>" value="<?php echo esc_attr($banner_image_1); ?>">
        </p>
        <p>
            <label>Slider Image 2 URL</label>
            <input class="widefat" type="text" name="<?php echo $this->get_field_name('banner_image_2'); ?>" value="<?php echo esc_attr($banner_image_2); ?>">
        </p>
        <p>
            <label>Slider Video URL</label>
            <input class="widefat" type="text" name="<?php echo $this->get_field_name('banner_video'); ?>" value="<?php echo esc_attr($banner_video); ?>">
        </p>

        <hr>
        <h4>Slide 1</h4>
        <p>
            <label>Slide 1 Title (HTML allowed e.g. &lt;span&gt;)</label>
            <input class="widefat" type="text" name="<?php echo $this->get_field_name('slide1_title'); ?>" value="<?php echo esc_attr($slide1_title); ?>">
        </p>
        <p>
            <label>Slide 1 Description</label>
            <textarea class="widefat" rows="3" name="<?php echo $this->get_field_name('slide1_text'); ?>"><?php echo esc_textarea($slide1_text); ?></textarea>
        </p>
        <p>
            <label>Slide 1 Button Text</label>
            <input class="widefat" type="text" name="<?php echo $this->get_field_name('slide1_btn_text'); ?>" value="<?php echo esc_attr($slide1_btn_text); ?>">
        </p>
        <p>
            <label>Slide 1 Button Link</label>
            <input class="widefat" type="text" name="<?php echo $this->get_field_name('slide1_btn_link'); ?>" value="<?php echo esc_attr($slide1_btn_link); ?>">
        </p>

        <hr>
        <h4>Slide 2</h4>
        <p>
            <label>Slide 2 Title (HTML allowed e.g. &lt;span&gt;)</label>
            <input class="widefat" type="text" name="<?php echo $this->get_field_name('slide2_title'); ?>" value="<?php echo esc_attr($slide2_title); ?>">
        </p>
        <p>
            <label>Slide 2 Description</label>
            <textarea class="widefat" rows="3" name="<?php echo $this->get_field_name('slide2_text'); ?>"><?php echo esc_textarea($slide2_text); ?></textarea>
        </p>
        <p>
            <label>Slide 2 Button Text</label>
            <input class="widefat" type="text" name="<?php echo $this->get_field_name('slide2_btn_text'); ?>" value="<?php echo esc_attr($slide2_btn_text); ?>">
        </p>
        <p>
            <label>Slide 2 Button Link</label>
            <input class="widefat" type="text" name="<?php echo $this->get_field_name('slide2_btn_link'); ?>" value="<?php echo esc_attr($slide2_btn_link); ?>">
        </p>
    <?php }

    // Save Data
    public function update($new_instance, $old_instance) {
        $instance = [];

        $fields = [
            'banner_image_1', 'banner_image_2', 'banner_video',
            'slide1_title', 'slide1_text', 'slide1_btn_text', 'slide1_btn_link',
            'slide2_title', 'slide2_text', 'slide2_btn_text', 'slide2_btn_link'
        ];

        foreach ($fields as $field) {
            if ($field === 'slide1_title' || $field === 'slide2_title') {
                $instance[$field] = !empty($new_instance[$field]) ? wp_kses_post($new_instance[$field]) : '';
            } else {
                $instance[$field] = !empty($new_instance[$field]) ? sanitize_text_field($new_instance[$field]) : '';
            }
        }
        
        return $instance;
    }
}

// Register Widget
function register_home_hero_section_widget() {
    register_widget('Home_Hero_Section_Widget');
}
add_action('widgets_init', 'register_home_hero_section_widget');