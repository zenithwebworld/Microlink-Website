<?php
// Philosophy Section Widget
class About_Philosophy_Section_Widget extends WP_Widget {
    function __construct() {
        parent::__construct(
            'about_philosophy_section',
            __('About Us :: Philosophy Section', _THEME_DOMAIN),
            array('description' => __('Update philosophy section content', _THEME_DOMAIN))
        );
    }

    // Frontend Output
    public function widget($args, $instance) {
        echo $args['before_widget'];

        // Dynamic variables
        $title = $instance['title'] ?? 'Our Philosophy';
        $desc = $instance['desc'] ?? '';

        $card1_title = $instance['card1_title'] ?? 'Purpose';
        $card1_desc = $instance['card1_desc'] ?? '';

        $card2_title = $instance['card2_title'] ?? 'Process';
        $card2_desc = $instance['card2_desc'] ?? '';

        $card3_title = $instance['card3_title'] ?? 'People';
        $card3_desc = $instance['card3_desc'] ?? '';

        $card4_title = $instance['card4_title'] ?? 'Partnership';
        $card4_desc = $instance['card4_desc'] ?? '';
        ?>

        <section class="core-values section-gap">
            <div class="container">
                <div class="row g-4 justify-content-center">
                    <div class="col-lg-8 text-center mb-5">
                        <h2 class="cm-title text-white fs-40">Our <span><?php echo esc_html($title); ?> </span></h2>
                        <div class="text-white"><?php echo esc_html($desc); ?></div>
                    </div>
                </div>
                <div class="row g-4 justify-content-center">

                    <!-- Card 1 -->
                    <div class="col-md-6 col-lg-3">
                        <div class="value-card h-100">
                            <div class="icon-box">
                                <span class="material-icons-outlined"><i class="n-icon" data-icon="s-purpose"
                                        data-iconwidth="28px" data-iconheight="28px"></i></span>
                            </div>
                            <h5 class="text-black"><?php echo esc_html($card1_title); ?></h5>
                            <p class="text-black"><?php echo esc_html($card1_desc); ?></p>
                        </div>
                    </div>

                    <!-- Card 2 -->
                    <div class="col-md-6 col-lg-3">
                        <div class="value-card h-100">
                            <div class="icon-box">
                                <span class="material-icons-outlined"><i class="n-icon" data-icon="s-process"
                                        data-iconwidth="28px" data-iconheight="28px"></i></span>
                            </div>
                            <h5 class="text-black"><?php echo esc_html($card2_title); ?></h5>
                            <p class="text-black"><?php echo esc_html($card2_desc); ?></p>
                        </div>
                    </div>

                    <!-- Card 3 -->
                    <div class="col-md-6 col-lg-3">
                        <div class="value-card h-100">
                            <div class="icon-box">
                                <span class="material-icons-outlined"><i class="n-icon" data-icon="s-collaboration"
                                        data-iconwidth="28px" data-iconheight="28px"></i></span>
                            </div>
                            <h5 class="text-black"><?php echo esc_html($card3_title); ?></h5>
                            <p class="text-black"><?php echo esc_html($card3_desc); ?></p>
                        </div>
                    </div>

                    <!-- Card 4 -->
                    <div class="col-md-6 col-lg-3">
                        <div class="value-card h-100">
                            <div class="icon-box">
                                <span class="material-icons-outlined"><i class="n-icon" data-icon="s-partnership"
                                        data-iconwidth="28px" data-iconheight="28px"></i></span>
                            </div>
                            <h5 class="text-black"><?php echo esc_html($card4_title); ?></h5>
                            <p class="text-black"><?php echo esc_html($card4_desc); ?></p>
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
        $desc = $instance['desc'] ?? '';

        $card1_title = $instance['card1_title'] ?? '';
        $card1_desc = $instance['card1_desc'] ?? '';

        $card2_title = $instance['card2_title'] ?? '';
        $card2_desc = $instance['card2_desc'] ?? '';

        $card3_title = $instance['card3_title'] ?? '';
        $card3_desc = $instance['card3_desc'] ?? '';

        $card4_title = $instance['card4_title'] ?? '';
        $card4_desc = $instance['card4_desc'] ?? '';
        ?>

        <p><label>Section Title</label>
        <input class="widefat" name="<?php echo $this->get_field_name('title'); ?>" value="<?php echo esc_attr($title); ?>"></p>

        <p><label>Description</label>
        <textarea class="widefat" name="<?php echo $this->get_field_name('desc'); ?>"><?php echo esc_textarea($desc); ?></textarea></p>

        <hr><strong>Card 1</strong>
        <p><input class="widefat" placeholder="Title" name="<?php echo $this->get_field_name('card1_title'); ?>" value="<?php echo esc_attr($card1_title); ?>"></p>
        <p><textarea class="widefat" placeholder="Description" name="<?php echo $this->get_field_name('card1_desc'); ?>"><?php echo esc_textarea($card1_desc); ?></textarea></p>

        <hr><strong>Card 2</strong>
        <p><input class="widefat" placeholder="Title" name="<?php echo $this->get_field_name('card2_title'); ?>" value="<?php echo esc_attr($card2_title); ?>"></p>
        <p><textarea class="widefat" placeholder="Description" name="<?php echo $this->get_field_name('card2_desc'); ?>"><?php echo esc_textarea($card2_desc); ?></textarea></p>

        <hr><strong>Card 3</strong>
        <p><input class="widefat" placeholder="Title" name="<?php echo $this->get_field_name('card3_title'); ?>" value="<?php echo esc_attr($card3_title); ?>"></p>
        <p><textarea class="widefat" placeholder="Description" name="<?php echo $this->get_field_name('card3_desc'); ?>"><?php echo esc_textarea($card3_desc); ?></textarea></p>

        <hr><strong>Card 4</strong>
        <p><input class="widefat" placeholder="Title" name="<?php echo $this->get_field_name('card4_title'); ?>" value="<?php echo esc_attr($card4_title); ?>"></p>
        <p><textarea class="widefat" placeholder="Description" name="<?php echo $this->get_field_name('card4_desc'); ?>"><?php echo esc_textarea($card4_desc); ?></textarea></p>

    <?php }

    // Save Data (SAFE)
    public function update($new_instance, $old_instance) {
        $instance = [];

        foreach ($new_instance as $key => $value) {
            $instance[$key] = !empty($value) ? sanitize_textarea_field($value) : '';
        }

        return $instance;
    }
}

// Register Widget
function register_about_philosophy_section_widget() {
    register_widget('About_Philosophy_Section_Widget');
}
add_action('widgets_init', 'register_about_philosophy_section_widget');