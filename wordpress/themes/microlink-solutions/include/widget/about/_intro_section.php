<?php
// Intro Section Widget
class About_Intro_Section_Widget extends WP_Widget {
    function __construct() {
        parent::__construct(
            'about_intro_section',
            __('About Us :: Intro Section', _THEME_DOMAIN),
            array('description' => __('Update intro section content', _THEME_DOMAIN))
        );
    }

    // Frontend Output
    public function widget($args, $instance) {
        echo $args['before_widget'];

        // Dynamic fields
        $title = $instance['title'] ?? 'Why Enterprises Trust Microlink?';
        $desc1 = $instance['desc1'] ?? '';
        $desc2 = $instance['desc2'] ?? '';
        $desc3 = $instance['desc3'] ?? '';
        $btn_text = $instance['btn_text'] ?? 'Connect with us';
        $btn_link = $instance['btn_link'] ?? 'contact.html';
        $image = $instance['image'] ?? 'assets/images/why-chooses-01.jpg';
        ?>

        <section class="why-choose-section section-gap double-gap overflow-hidden">
            <div class="container">
                <div class="row align-items-center g-4">
                    <div class="col-xl-6 order-2 order-xl-1" data-aos="fade-right" data-aos-delay="80">
                        <h2 class="cm-title text-black fs-40 mb-4">
                            <?php echo str_replace('Microlink?', '<span>Microlink?</span>', $title); ?>
                        </h2>

                        <div class="cms">
                            <p><?php echo esc_html($desc1); ?></p>
                            <p><?php echo esc_html($desc2); ?></p>
                            <p><?php echo esc_html($desc3); ?></p>
                        </div>

                        <div class="d-flex align-items-center gap-3 mt-4">
                            <a href="<?php echo esc_url($btn_link); ?>" class="btn btn-primary">
                                <?php echo esc_html($btn_text); ?>
                            </a>
                        </div>
                    </div>
                    <div class="col-xl-6 order-1 order-xl-2" data-aos="fade-left" data-aos-delay="120">
                        <figure class="thumbnail-container object-fit rounded-3">
                            <div class="thumbnail">
                                <img src="<?php echo esc_url($image); ?>" alt="" width="720" height="480">
                            </div>
                        </figure>
                    </div>
                </div>
            </div>
        </section>
        
        <?php echo $args['after_widget'];
    }

    // Backend Form
    public function form($instance) {

        $title = $instance['title'] ?? '';
        $desc1 = $instance['desc1'] ?? '';
        $desc2 = $instance['desc2'] ?? '';
        $desc3 = $instance['desc3'] ?? '';
        $btn_text = $instance['btn_text'] ?? '';
        $btn_link = $instance['btn_link'] ?? '';
        $image = $instance['image'] ?? '';
        ?>

        <p>
            <label>Title</label>
            <input class="widefat" name="<?php echo $this->get_field_name('title'); ?>" value="<?php echo esc_attr($title); ?>">
        </p>

        <p>
            <label>Description 1</label>
            <textarea class="widefat" name="<?php echo $this->get_field_name('desc1'); ?>"><?php echo esc_textarea($desc1); ?></textarea>
        </p>

        <p>
            <label>Description 2</label>
            <textarea class="widefat" name="<?php echo $this->get_field_name('desc2'); ?>"><?php echo esc_textarea($desc2); ?></textarea>
        </p>

        <p>
            <label>Description 3</label>
            <textarea class="widefat" name="<?php echo $this->get_field_name('desc3'); ?>"><?php echo esc_textarea($desc3); ?></textarea>
        </p>

        <p>
            <label>Button Text</label>
            <input class="widefat" name="<?php echo $this->get_field_name('btn_text'); ?>" value="<?php echo esc_attr($btn_text); ?>">
        </p>

        <p>
            <label>Button Link</label>
            <input class="widefat" name="<?php echo $this->get_field_name('btn_link'); ?>" value="<?php echo esc_attr($btn_link); ?>">
        </p>

        <p>
            <label>Image URL</label>
            <input class="widefat" name="<?php echo $this->get_field_name('image'); ?>" value="<?php echo esc_attr($image); ?>">
        </p>

    <?php }

    // Save Data (SAFE FIXED)
    public function update($new_instance, $old_instance) {
        $instance = [];

        $instance['title'] = !empty($new_instance['title']) ? sanitize_text_field($new_instance['title']) : '';
        $instance['desc1'] = !empty($new_instance['desc1']) ? sanitize_textarea_field($new_instance['desc1']) : '';
        $instance['desc2'] = !empty($new_instance['desc2']) ? sanitize_textarea_field($new_instance['desc2']) : '';
        $instance['desc3'] = !empty($new_instance['desc3']) ? sanitize_textarea_field($new_instance['desc3']) : '';
        $instance['btn_text'] = !empty($new_instance['btn_text']) ? sanitize_text_field($new_instance['btn_text']) : '';
        $instance['btn_link'] = !empty($new_instance['btn_link']) ? esc_url_raw($new_instance['btn_link']) : '';
        $instance['image'] = !empty($new_instance['image']) ? esc_url_raw($new_instance['image']) : '';

        return $instance;
    }
}

// Register Widget
function register_about_intro_section_widget() {
    register_widget('About_Intro_Section_Widget');
}
add_action('widgets_init', 'register_about_intro_section_widget');