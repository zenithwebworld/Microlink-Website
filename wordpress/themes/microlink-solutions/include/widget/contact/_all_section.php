<?php
// Hero Section Widget
class Contact_Us_Section_Widget extends WP_Widget {
    function __construct() {
        parent::__construct(
            'contact_us_section',
            __('Contact Us :: All Section', _THEME_DOMAIN),
            array('description' => __('Update contact us all section content', _THEME_DOMAIN))
        );
    }

    // Frontend Output
    public function widget($args, $instance) {
        echo $args['before_widget'];

        // Dynamic Fields
        $address = $instance['address'] ?? '4th Floor, Sarthik Complex, Near Iscon Circle, Satellite, Ahmedabad';
        $email = $instance['email'] ?? 'info@microlink.co.in';
        $phone = $instance['phone'] ?? '+91 98244 08739';
        $timings = $instance['timings'] ?? 'Mon-Fri: 9AM - 6PM IST';
        $map = $instance['map'] ?? '';
        ?>

        <section class="contact-section section-gap double-gap position-relative">
            <img class="lazy banner-bg-1" src="<?php echo site_url('wp-content/uploads/2026/03/banner-bg-1.png'); ?>" alt="" width="87" height="25">
            <img class="lazy banner-bg-2" src="<?php echo site_url('wp-content/uploads/2026/03/banner-bg-2.png'); ?>" alt="" width="87" height="25">

            <div class="container">
                <div class="row align-items-center mb-sm-5 mb-4 justify-content-center">
                    <div class="col-md-8 col-xl-6 text-center">
                        <h2 class="cm-title text-black fs-40 mb-3">Get In <span>Touch With Us</span></h2>
                        <p class="text-muted">Have a question or ready to get started? We'd love to hear from you.</p>
                    </div>
                </div>
                <div class="row g-4 mt-2">
                    <div class="col-lg-3 col-md-6">
                        <div class="contact-info-card c-card bg-white h-100">
                            <div class="icon-circle mb-3">
                                <i class="n-icon text-primary" data-icon="s-location" data-iconwidth="30px"></i>
                            </div>
                            <h5 class="fw-bold mb-3">Address</h5>
                            <p class="text-muted"><?php echo esc_html($address); ?></p>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6">
                        <div class="contact-info-card c-card bg-white h-100">
                            <div class="icon-circle mb-3">
                                <i class="n-icon text-primary" data-icon="s-user" data-iconwidth="30px"></i>
                            </div>
                            <h5 class="fw-bold mb-3">Email Us</h5>
                            <p class="text-muted mb-2">
                                <a href="mailto:<?php echo esc_attr($email); ?>" class="text-primary fw-bold">
                                    <?php echo esc_html($email); ?>
                                </a>
                            </p>
                            <p class="text-muted">We'll respond within 24 hours</p>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6">
                        <div class="contact-info-card c-card bg-white h-100">
                            <div class="icon-circle mb-3">
                                <i class="n-icon text-primary" data-icon="s-projects" data-iconwidth="30px"></i>
                            </div>
                            <h5 class="fw-bold mb-3">Call Us</h5>
                            <p class="text-muted mb-2">
                                <a href="tel:<?php echo esc_attr($phone); ?>" class="text-primary fw-bold">
                                    <?php echo esc_html($phone); ?>
                                </a>
                            </p>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6">
                        <div class="contact-info-card c-card bg-white h-100">
                            <div class="icon-circle mb-3">
                                <i class="n-icon text-primary" data-icon="s-clock" data-iconwidth="30px"></i>
                            </div>
                            <h5 class="fw-bold mb-3">Office Timings</h5>
                            <p class="text-muted"><?php echo esc_html($timings); ?></p>
                        </div>
                    </div>
                </div>
                <div class="row g-4 mt-5">
                    <div class="col-lg-8">
                        <div class="contact-form-card c-card bg-white rounded-4 overflow-hidden h-100">
                            <div class="card-body p-5">
                                <h3 class="fw-bold mb-1">Send us a Message</h3>
                                <p class="text-muted mb-4">Fill out the form below and our team will get back to you.</p>
                                <?php echo do_shortcode('[contact-form-7 id="b1e7519" title="Contact Form"]'); ?>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="map-card c-card bg-white rounded-4 overflow-hidden h-100">
                            <iframe src="<?php echo esc_url($map); ?>" width="100%" height="500" style="border:0;"></iframe>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        
        <?php echo $args['after_widget'];
    }

    // Backend Form
    public function form($instance) {
        ?>

        <p><label>Address</label>
        <textarea class="widefat" name="<?php echo $this->get_field_name('address'); ?>"><?php echo esc_textarea($instance['address'] ?? ''); ?></textarea></p>

        <p><label>Email</label>
        <input class="widefat" name="<?php echo $this->get_field_name('email'); ?>" value="<?php echo esc_attr($instance['email'] ?? ''); ?>"></p>

        <p><label>Phone</label>
        <input class="widefat" name="<?php echo $this->get_field_name('phone'); ?>" value="<?php echo esc_attr($instance['phone'] ?? ''); ?>"></p>

        <p><label>Office Timings</label>
        <input class="widefat" name="<?php echo $this->get_field_name('timings'); ?>" value="<?php echo esc_attr($instance['timings'] ?? ''); ?>"></p>

        <p><label>Google Map Embed URL</label>
        <textarea class="widefat" name="<?php echo $this->get_field_name('map'); ?>"><?php echo esc_textarea($instance['map'] ?? ''); ?></textarea></p>

        <?php
    }

    // Save Data
    public function update($new_instance, $old_instance) {
        $instance = [];

        $instance['address'] = !empty($new_instance['address']) ? sanitize_textarea_field($new_instance['address']) : '';
        $instance['email']   = !empty($new_instance['email']) ? sanitize_email($new_instance['email']) : '';
        $instance['phone']   = !empty($new_instance['phone']) ? sanitize_text_field($new_instance['phone']) : '';
        $instance['timings'] = !empty($new_instance['timings']) ? sanitize_text_field($new_instance['timings']) : '';
        $instance['map'] = !empty($new_instance['map']) ? $new_instance['map'] : '';

        return $instance;
    }
}

// Register Widget
function register_contact_us_section_widget() {
    register_widget('Contact_Us_Section_Widget');
}
add_action('widgets_init', 'register_contact_us_section_widget');