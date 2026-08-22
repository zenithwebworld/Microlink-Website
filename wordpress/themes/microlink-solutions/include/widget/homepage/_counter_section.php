<?php
// Hero Section Widget
class Home_Counter_Section_Widget extends WP_Widget {

    function __construct() {
        parent::__construct(
            'home_counter_section',
            __('Homepage :: Counter Section', _THEME_DOMAIN),
            array('description' => __('Update counter section content', _THEME_DOMAIN))
        );
    }

    // Frontend Output
    public function widget($args, $instance) {
        echo $args['before_widget'];

        // Counter 1
        $number_1 = !empty($instance['number_1']) ? $instance['number_1'] : '30';
        $label_1  = !empty($instance['label_1']) ? $instance['label_1'] : 'Years of Experience';
        $icon_1   = !empty($instance['icon_1']) ? $instance['icon_1'] : 's-awards';

        // Counter 2
        $number_2 = !empty($instance['number_2']) ? $instance['number_2'] : '100';
        $label_2  = !empty($instance['label_2']) ? $instance['label_2'] : 'Technology Alliances';
        $icon_2   = !empty($instance['icon_2']) ? $instance['icon_2'] : 's-cybersecurity-solutions';

        // Counter 3
        $number_3 = !empty($instance['number_3']) ? $instance['number_3'] : '400';
        $label_3  = !empty($instance['label_3']) ? $instance['label_3'] : 'Team Strength';
        $icon_3   = !empty($instance['icon_3']) ? $instance['icon_3'] : 's-projects';

        // Counter 4
        $number_4 = !empty($instance['number_4']) ? $instance['number_4'] : '1000';
        $label_4  = !empty($instance['label_4']) ? $instance['label_4'] : 'Clients served';
        $icon_4   = !empty($instance['icon_4']) ? $instance['icon_4'] : 's-clients';
        ?>

        <section class="counter section-gap double-gap counter-light bg-light section-gap">
            <div class="container">
                <div class="row align-items-center text-start text-md-center gy-3">

                    <div class="col-sm-6 col-xl-3">
                        <div class="counter-item d-flex align-items-center" data-aos="fade-up" data-aos-delay="100">
                            <div class="icon-box">
                                <i class="n-icon text-primary" data-icon="<?php echo esc_attr($icon_1); ?>" data-iconwidth="30px"
                                    data-iconheight="30px"></i>
                            </div>
                            <div class="sep"></div>
                            <div class="counter-content ms-3">
                                <div class="counter-number" data-target="<?php echo esc_attr($number_1); ?>" data-suffix="+">0</div>
                                <div class="counter-text"><?php echo esc_html($label_1); ?></div>
                            </div>
                        </div>
                    </div>

                    <div class="col-sm-6 col-xl-3">
                        <div class="counter-item d-flex align-items-center" data-aos="fade-up" data-aos-delay="150">
                            <div class="icon-box">
                                <i class="n-icon text-primary" data-icon="<?php echo esc_attr($icon_2); ?>" data-iconwidth="30px"
                                    data-iconheight="30px"></i>
                            </div>
                            <div class="sep"></div>
                            <div class="counter-content ms-3">
                                <div class="counter-number" data-target="<?php echo esc_attr($number_2); ?>" data-suffix="+">0</div>
                                <div class="counter-text"><?php echo esc_html($label_2); ?></div>
                            </div>
                        </div>
                    </div>

                    <div class="col-sm-6 col-xl-3">
                        <div class="counter-item d-flex align-items-center" data-aos="fade-up" data-aos-delay="200">
                            <div class="icon-box">
                                <i class="n-icon text-primary" data-icon="<?php echo esc_attr($icon_3); ?>" data-iconwidth="30px"
                                    data-iconheight="30px"></i>
                            </div>
                            <div class="sep"></div>
                            <div class="counter-content ms-3">
                                <div class="counter-number" data-target="<?php echo esc_attr($number_3); ?>" data-suffix="+">0</div>
                                <div class="counter-text"><?php echo esc_html($label_3); ?></div>
                            </div>
                        </div>
                    </div>

                    <div class="col-sm-6 col-xl-3">
                        <div class="counter-item d-flex align-items-center" data-aos="fade-up" data-aos-delay="250">
                            <div class="icon-box">
                                <i class="n-icon text-primary" data-icon="<?php echo esc_attr($icon_4); ?>" data-iconwidth="30px"
                                    data-iconheight="30px"></i>
                            </div>
                            <div class="sep"></div>
                            <div class="counter-content ms-3">
                                <div class="counter-number" data-target="<?php echo esc_attr($number_4); ?>" data-suffix="+" data-decimals="1">0</div>
                                <div class="counter-text"><?php echo esc_html($label_4); ?></div>
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

        for ($i = 1; $i <= 4; $i++) {
            ${"number_$i"} = $instance["number_$i"] ?? '';
            ${"label_$i"}  = $instance["label_$i"] ?? '';
            ${"icon_$i"}   = $instance["icon_$i"] ?? '';
        }
        ?>

        <?php for ($i = 1; $i <= 4; $i++) : ?>
            <h4>Counter <?php echo $i; ?></h4>

            <p>
                <label>Number</label>
                <input class="widefat"
                       name="<?php echo $this->get_field_name("number_$i"); ?>"
                       value="<?php echo esc_attr(${"number_$i"}); ?>">
            </p>

            <p>
                <label>Label</label>
                <input class="widefat"
                       name="<?php echo $this->get_field_name("label_$i"); ?>"
                       value="<?php echo esc_attr(${"label_$i"}); ?>">
            </p>

            <p>
                <label>Icon</label>
                <input class="widefat"
                       name="<?php echo $this->get_field_name("icon_$i"); ?>"
                       value="<?php echo esc_attr(${"icon_$i"}); ?>">
            </p>

            <hr>
        <?php endfor; ?>

    <?php }

    // Save Data
    public function update($new_instance, $old_instance) {
        $instance = [];

        for ($i = 1; $i <= 4; $i++) {
            $instance["number_$i"] = (!empty($new_instance["number_$i"])) ? strip_tags($new_instance["number_$i"]) : '';
            $instance["label_$i"]  = (!empty($new_instance["label_$i"])) ? strip_tags($new_instance["label_$i"]) : '';
            $instance["icon_$i"]   = (!empty($new_instance["icon_$i"])) ? strip_tags($new_instance["icon_$i"]) : '';
        }

        return $instance;
    }
}

// Register Widget
function register_counter_about_section_widget() {
    register_widget('Home_Counter_Section_Widget');
}
add_action('widgets_init', 'register_counter_about_section_widget');