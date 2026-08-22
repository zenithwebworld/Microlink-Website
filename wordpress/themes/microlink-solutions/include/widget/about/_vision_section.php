<?php
// Vision Section Widget
class About_Vision_Section_Widget extends WP_Widget {
    function __construct() {
        parent::__construct(
            'about_vision_section',
            __('About Us :: Vision Section', _THEME_DOMAIN),
            array('description' => __('Update vision section content', _THEME_DOMAIN))
        );
    }

    // Frontend Output
    public function widget($args, $instance) {
        echo $args['before_widget'];

        // Dynamic variables
        $vision_title = $instance['vision_title'] ?? 'Our Vision';
        $vision_desc  = $instance['vision_desc'] ?? '';
        $mission_title = $instance['mission_title'] ?? 'Our Mission';
        $mission_desc  = $instance['mission_desc'] ?? '';
        ?>

        <section class="vision-mission-section section-gap">
            <div class="container">
                <div class="row g-4 g-lg-5 justify-content-center">
                    <div class="col-lg-6">
                        <div class="vm-card text-center h-100">
                            <div class="icon-circle">
                                <span class="material-icons-outlined"><i class="n-icon" data-icon="s-vision"
                                        data-iconwidth="35px" data-iconheight="35px"></i></span>
                            </div>
                            <h3 class="fw-bold mt-4 mb-3"><?php echo esc_html($vision_title); ?></h3>
                            <p><?php echo esc_html($vision_desc); ?></p>
                        </div>
                    </div>

                    <!-- Mission Card -->
                    <div class="col-lg-6">
                        <div class="vm-card text-center h-100">
                            <div class="icon-circle">
                                <span class="material-icons-outlined"><i class="n-icon" data-icon="s-misstion"
                                        data-iconwidth="35px" data-iconheight="35px"></i></span>
                            </div>
                            <h3 class="fw-bold mt-4 mb-3"><?php echo esc_html($mission_title); ?></h3>
                            <p><?php echo esc_html($mission_desc); ?></p>
                        </div>
                    </div>

                </div>
            </div>
        </section>
        
        <?php echo $args['after_widget'];
    }

    // Backend Form
    public function form($instance) {

        $vision_title = $instance['vision_title'] ?? '';
        $vision_desc  = $instance['vision_desc'] ?? '';
        $mission_title = $instance['mission_title'] ?? '';
        $mission_desc  = $instance['mission_desc'] ?? '';
        ?>

        <p>
            <label>Vision Title</label>
            <input class="widefat" name="<?php echo $this->get_field_name('vision_title'); ?>" value="<?php echo esc_attr($vision_title); ?>">
        </p>

        <p>
            <label>Vision Description</label>
            <textarea class="widefat" name="<?php echo $this->get_field_name('vision_desc'); ?>"><?php echo esc_textarea($vision_desc); ?></textarea>
        </p>

        <p>
            <label>Mission Title</label>
            <input class="widefat" name="<?php echo $this->get_field_name('mission_title'); ?>" value="<?php echo esc_attr($mission_title); ?>">
        </p>

        <p>
            <label>Mission Description</label>
            <textarea class="widefat" name="<?php echo $this->get_field_name('mission_desc'); ?>"><?php echo esc_textarea($mission_desc); ?></textarea>
        </p>

    <?php }

    // Save Data (SAFE)
    public function update($new_instance, $old_instance) {
        $instance = [];

        $instance['vision_title'] = !empty($new_instance['vision_title']) ? sanitize_text_field($new_instance['vision_title']) : '';
        $instance['vision_desc']  = !empty($new_instance['vision_desc']) ? sanitize_textarea_field($new_instance['vision_desc']) : '';
        $instance['mission_title'] = !empty($new_instance['mission_title']) ? sanitize_text_field($new_instance['mission_title']) : '';
        $instance['mission_desc']  = !empty($new_instance['mission_desc']) ? sanitize_textarea_field($new_instance['mission_desc']) : '';

        return $instance;
    }
}

// Register Widget
function register_about_vision_section_widget() {
    register_widget('About_Vision_Section_Widget');
}
add_action('widgets_init', 'register_about_vision_section_widget');