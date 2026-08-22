<?php
// Hero Section Widget
class About_Stories_Section_Widget extends WP_Widget {
    function __construct() {
        parent::__construct(
            'about_stories_section',
            __('About Us :: Stories Section', _THEME_DOMAIN),
            array('description' => __('Update stories section content', _THEME_DOMAIN))
        );
    }

    // Frontend Output
    public function widget($args, $instance) {
        echo $args['before_widget']; ?>

        <section class="case-study-section section-gap common-owl">
            <div class="container">
                <div class="row align-items-end mb-4">
                    <div class="col-lg-10">
                        <h2 class="cm-title text-black fs-40 mb-2">Transforming Vision into Results <span> Customer Success Stories</span></h2>
                        <p>See how we turn complex business challenges into measurable results through strategic technology implementation. Explore some of our proven success stories that showcase innovation, efficiency, and business growth in action.</p>
                    </div>
                    <div class="col-lg-2 text-lg-end mt-3 mt-lg-0">
                        <!-- <a href="#" class="btn btn-primary">View all </a> -->
                    </div>
                </div>
                <div class="row">
                    <div class="col-12">
                        <div class="owl-carousel portfolio-slider">
                            <?php
                            $stories = new WP_Query([
                                'post_type' => 'story',
                                'posts_per_page' => 6
                            ]);

                            if ($stories->have_posts()) :
                                while ($stories->have_posts()) : $stories->the_post();
                                    $title = get_the_title();
                                    $featured_image = get_the_post_thumbnail_url(get_the_ID(), 'full');
                                    $badge1 = get_post_meta(get_the_ID(), 'badge_1', true);
                                    $badge2 = get_post_meta(get_the_ID(), 'badge_2', true);
                                    $desc = get_the_excerpt();
                            ?>

                            <div class="portfolio-card">
                                <div class="thumbnail-container object-fit rounded-3">
                                    <div class="thumbnail">
                                        <img src="<?php echo $featured_image; ?>" alt="<?php echo $title; ?>" width="891" height="594">
                                    </div>
                                    <div class="overlay">
                                        <span class="badge bg-light text-dark"><?php echo esc_html($badge1); ?></span>
                                        <span class="badge bg-light text-dark"><?php echo esc_html($badge2); ?></span>
                                        <h4 class="my-3 text-white"><?php the_title(); ?></h4>
                                        <p><?php echo esc_html($desc); ?></p>
                                    </div>
                                </div>
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

    // Backend Form
    public function form($instance) {

        $title = $instance['title'] ?? '';
        $desc = $instance['desc'] ?? '';
        ?>

        <p><label>Title</label>
        <input class="widefat" name="<?php echo $this->get_field_name('title'); ?>" value="<?php echo esc_attr($title); ?>"></p>

        <p><label>Description</label>
        <textarea class="widefat" name="<?php echo $this->get_field_name('desc'); ?>"><?php echo esc_textarea($desc); ?></textarea></p>

        <?php for ($i = 1; $i <= 3; $i++) : ?>
            <hr><strong>Item <?php echo $i; ?></strong>

            <p><input class="widefat" placeholder="Image 1" name="<?php echo $this->get_field_name("img1_$i"); ?>" value="<?php echo esc_attr($instance["img1_$i"] ?? ''); ?>"></p>
            <p><input class="widefat" placeholder="Image 2" name="<?php echo $this->get_field_name("img2_$i"); ?>" value="<?php echo esc_attr($instance["img2_$i"] ?? ''); ?>"></p>
            <p><input class="widefat" placeholder="Badge 1" name="<?php echo $this->get_field_name("badge1_$i"); ?>" value="<?php echo esc_attr($instance["badge1_$i"] ?? ''); ?>"></p>
            <p><input class="widefat" placeholder="Badge 2" name="<?php echo $this->get_field_name("badge2_$i"); ?>" value="<?php echo esc_attr($instance["badge2_$i"] ?? ''); ?>"></p>
            <p><input class="widefat" placeholder="Title" name="<?php echo $this->get_field_name("item_title_$i"); ?>" value="<?php echo esc_attr($instance["item_title_$i"] ?? ''); ?>"></p>
            <p><textarea class="widefat" placeholder="Description" name="<?php echo $this->get_field_name("item_desc_$i"); ?>"><?php echo esc_textarea($instance["item_desc_$i"] ?? ''); ?></textarea></p>

        <?php endfor; ?>

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
function register_about_stories_section_widget() {
    register_widget('About_Stories_Section_Widget');
}
add_action('widgets_init', 'register_about_stories_section_widget');