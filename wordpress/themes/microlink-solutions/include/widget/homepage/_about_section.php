<?php
// Hero Section Widget
class Home_About_Section_Widget extends WP_Widget {

    function __construct() {
        parent::__construct(
            'home_about_section',
            __('Homepage :: About Section', _THEME_DOMAIN),
            array('description' => __('Update about section content', _THEME_DOMAIN))
        );
    }

    // Frontend Output
    public function widget($args, $instance) {
        echo $args['before_widget'];

        $title = !empty($instance['title']) ? $instance['title'] : '';
        $description = !empty($instance['description']) ? $instance['description'] : '';
        $features = !empty($instance['features']) ? explode("\n", $instance['features']) : [];
        $phone = !empty($instance['phone']) ? $instance['phone'] : '';
        $btn_text = !empty($instance['btn_text']) ? $instance['btn_text'] : '';
        $btn_link = !empty($instance['btn_link']) ? $instance['btn_link'] : '';

        $banner_image_1 = !empty($instance['banner_image_1']) ? $instance['banner_image_1'] : '';
        $banner_image_2 = !empty($instance['banner_image_2']) ? $instance['banner_image_2'] : ''; ?>

        <section class="about-section section-gap double-gap-t">
            <div class="container">
                <div class="row gx-5">
                    <div class="col-xl-6 mt-lg-0 mt-4">
                        <div class="position-relative image-wrap">
                            <div class="img-1">
                                <figure class="thumbnail-container object-fit">
                                    <div class="thumbnail">
                                        <img src="<?php echo esc_url($banner_image_1); ?>" alt="">
                                    </div>
                                </figure>
                            </div>
                            <div class="img-2 overflow-hidden">
                                <figure class="thumbnail-container object-fit">
                                    <div class="thumbnail">
                                        <img src="<?php echo esc_url($banner_image_2); ?>" alt="">
                                    </div>
                                </figure>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-6">
                        <h2 class="cm-title text-black fs-40">
                            <?php echo str_replace('Microlink', '<span>Microlink</span>', $title ?? ''); ?>
                        </h2>

                        <div class="cms mt-4">
                            <?php echo wpautop($description); ?>

                            <?php if(!empty($features)) : ?>
                                <ul>
                                    <?php foreach($features as $item) : ?>
                                        <li><?php echo esc_html($item); ?></li>
                                    <?php endforeach; ?>
                                </ul>
                            <?php endif; ?>
                        </div>
                        <div class="bottom-content about-cta d-flex align-items-center justify-content-sm-between mt-4 pt-4 justify-content-center flex-wrap gap-3">
                            <div class="about-cta-left d-flex align-items-center">
                                <div class="years-number">30+</div>
                                <div class="years-text ms-3">
                                    <div class="small text-muted">Years of</div>
                                    <div class="fw-bold">legacy and trust</div>
                                </div>
                            </div>
                            <div class="about-cta-center d-flex align-items-center">
                                <div class="icon-circle me-3" aria-hidden="true">
                                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                        stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
                                        <path d="M3 13v-1a9 9 0 0 1 18 0v1"></path>
                                        <path d="M21 13v6a2 2 0 0 1-2 2h-1a1 1 0 0 1-1-1v-6"></path>
                                        <path d="M3 13v6a2 2 0 0 0 2 2h1a1 1 0 0 0 1-1v-6"></path>
                                    </svg>
                                </div>
                                <div>
                                    <div class="small text-muted">Call Us For Inquiry</div>
                                    <div class="fw-bold">
                                        <?php echo esc_html($phone); ?>
                                    </div>
                                </div>
                            </div>
                            <div class="about-cta-right">
                                <a href="<?php echo esc_url($btn_link); ?>" class="btn btn-primary">
                                    <?php echo esc_html($btn_text); ?>
                                </a>
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

        $title = $instance['title'] ?? '';
        $description = $instance['description'] ?? '';
        $features = $instance['features'] ?? '';
        $phone = $instance['phone'] ?? '';
        $btn_text = $instance['btn_text'] ?? '';
        $btn_link = $instance['btn_link'] ?? '';

        $banner_image_1 = $instance['banner_image_1'] ?? '';
        $banner_image_2 = $instance['banner_image_2'] ?? '';
        ?>

        <p>
            <label>Title</label>
            <input class="widefat" name="<?php echo $this->get_field_name('title'); ?>" value="<?php echo esc_attr($title); ?>">
        </p>

        <p>
            <label>Description</label>
            <textarea class="widefat" rows="5" name="<?php echo $this->get_field_name('description'); ?>"><?php echo esc_textarea($description); ?></textarea>
        </p>

        <p>
            <label>Features (One per line)</label>
            <textarea class="widefat" rows="4" name="<?php echo $this->get_field_name('features'); ?>"><?php echo esc_textarea($features); ?></textarea>
        </p>

        <p>
            <label>Phone</label>
            <input class="widefat" name="<?php echo $this->get_field_name('phone'); ?>" value="<?php echo esc_attr($phone); ?>">
        </p>

        <p>
            <label>Button Text</label>
            <input class="widefat" name="<?php echo $this->get_field_name('btn_text'); ?>" value="<?php echo esc_attr($btn_text); ?>">
        </p>

        <p>
            <label>Button Link</label>
            <input class="widefat" name="<?php echo $this->get_field_name('btn_link'); ?>" value="<?php echo esc_attr($btn_link); ?>">
        </p>

        <hr>

        <p>
            <label>Image 1 URL</label>
            <input class="widefat" name="<?php echo $this->get_field_name('banner_image_1'); ?>" value="<?php echo esc_attr($banner_image_1); ?>">
        </p>

        <p>
            <label>Image 2 URL</label>
            <input class="widefat" name="<?php echo $this->get_field_name('banner_image_2'); ?>" value="<?php echo esc_attr($banner_image_2); ?>">
        </p>
    <?php }

    // Save Data
    public function update($new_instance, $old_instance) {
        $instance = [];

        $fields = [
            'title','description','features','phone',
            'btn_text','btn_link','banner_image_1','banner_image_2'
        ];

        foreach($fields as $field){
            $instance[$field] = (!empty($new_instance[$field])) ? strip_tags($new_instance[$field]) : '';
        }

        return $instance;
    }
}

// Register Widget
function register_home_about_section_widget() {
    register_widget('Home_About_Section_Widget');
}
add_action('widgets_init', 'register_home_about_section_widget');