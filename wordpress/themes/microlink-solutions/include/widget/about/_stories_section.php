<?php
// Stories Section Widget
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
        echo $args['before_widget'];
        
        $title = !empty($instance['title']) ? $instance['title'] : 'Transforming Vision into Results <span> Customer Success Stories</span>';
        $desc = !empty($instance['desc']) ? $instance['desc'] : 'See how we turn complex business challenges into measurable results through strategic technology implementation. Explore some of our proven success stories that showcase innovation, efficiency, and business growth in action.';
        ?>

        <section class="case-study-section section-gap common-owl">
            <div class="container">
                <div class="row align-items-end mb-4">
                    <div class="col-lg-10">
                        <h2 class="cm-title text-black fs-40 mb-2"><?php echo wp_kses_post($title); ?></h2>
                        <p><?php echo esc_html($desc); ?></p>
                    </div>
                    <div class="col-lg-2 text-lg-end mt-3 mt-lg-0">
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
                                    $story_title = get_the_title();
                                    $featured_image = get_the_post_thumbnail_url(get_the_ID(), 'full');
                                    $badge1 = get_post_meta(get_the_ID(), 'badge_1', true);
                                    $badge2 = get_post_meta(get_the_ID(), 'badge_2', true);
                                    $story_desc = get_the_excerpt();
                            ?>

                            <div class="portfolio-card">
                                <div class="thumbnail-container object-fit rounded-3">
                                    <div class="thumbnail">
                                        <img src="<?php echo esc_url($featured_image); ?>" alt="<?php echo esc_attr($story_title); ?>" width="891" height="594">
                                    </div>
                                    <div class="overlay">
                                        <?php if (!empty($badge1)) : ?>
                                            <span class="badge bg-light text-dark"><?php echo esc_html($badge1); ?></span>
                                        <?php endif; ?>
                                        <?php if (!empty($badge2)) : ?>
                                            <span class="badge bg-light text-dark"><?php echo esc_html($badge2); ?></span>
                                        <?php endif; ?>
                                        <h4 class="my-3 text-white"><?php the_title(); ?></h4>
                                        <p><?php echo esc_html($story_desc); ?></p>
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

        <p><label>Title (HTML allowed e.g. &lt;span&gt;)</label>
        <input class="widefat" name="<?php echo $this->get_field_name('title'); ?>" value="<?php echo esc_attr($title); ?>"></p>

        <p><label>Description</label>
        <textarea class="widefat" rows="3" name="<?php echo $this->get_field_name('desc'); ?>"><?php echo esc_textarea($desc); ?></textarea></p>

    <?php }

    // Save Data
    public function update($new_instance, $old_instance) {
        $instance = [];

        $instance['title'] = !empty($new_instance['title']) ? wp_kses_post($new_instance['title']) : '';
        $instance['desc']  = !empty($new_instance['desc']) ? sanitize_textarea_field($new_instance['desc']) : '';

        return $instance;
    }
}

// Register Widget
function register_about_stories_section_widget() {
    register_widget('About_Stories_Section_Widget');
}
add_action('widgets_init', 'register_about_stories_section_widget');