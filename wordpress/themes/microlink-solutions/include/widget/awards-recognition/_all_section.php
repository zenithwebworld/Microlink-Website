<?php
// Awards Section Widget (Dynamic Custom Post Type Query)
class Awards_Section_Widget extends WP_Widget {
    function __construct() {
        parent::__construct(
            'awards_section',
            __('Awards :: All Section', _THEME_DOMAIN),
            array('description' => __('Display awards dynamically from Awards & Recognition CPT', _THEME_DOMAIN))
        );
    }

    // Frontend Output
    public function widget($args, $instance) {
        echo $args['before_widget'];

        $title    = !empty($instance['title']) ? $instance['title'] : 'Awards & Recognition';
        $subtitle = !empty($instance['subtitle']) ? $instance['subtitle'] : 'Over the years, Microlink has been honored for its commitment to innovation, quality, and customer excellence. These recognitions reflect our dedication to delivering reliable solutions and building long-term partnerships based on trust and performance.';
        ?>

        <section class="gallery-section section-gap">
            <div class="container">
                <div class="row">
                    <div class="col-12">
                        <div class="row justify-content-between align-items-center cm-nav">
                            <div class="col-lg-8">
                                <h2 class="cm-title text-black fs-40 mb-2"><?php echo wp_kses_post($title); ?></h2>
                                <p><?php echo esc_html($subtitle); ?></p>
                            </div>
                        </div>

                        <div class="mt-5">
                            <div class="row g-4">
                                <?php
                                $awards_query = new WP_Query([
                                    'post_type'      => 'award',
                                    'posts_per_page' => -1,
                                    'orderby'        => 'menu_order title',
                                    'order'          => 'ASC'
                                ]);

                                if ($awards_query->have_posts()) :
                                    while ($awards_query->have_posts()) : $awards_query->the_post();
                                        $img_url    = get_post_meta(get_the_ID(), '_award_image_url', true) ?: get_the_post_thumbnail_url(get_the_ID(), 'full');
                                        $post_title = get_the_title();
                                        $subtitle   = get_post_meta(get_the_ID(), '_award_subtitle', true);
                                        $label      = !empty($subtitle) ? $post_title . ' - ' . $subtitle : $post_title;

                                        if (empty($img_url)) {
                                            continue;
                                        }
                                ?>
                                    <div class="col-md-4 col-lg-3">
                                        <a href="<?php echo esc_url($img_url); ?>" data-fancybox="gallery" class="media-item position-relative" title="<?php echo esc_attr($label); ?>">
                                            <figure class="thumbnail-container object-fit">
                                                <div class="thumbnail">
                                                    <img src="<?php echo esc_url($img_url); ?>" alt="<?php echo esc_attr($label); ?>" width="720" height="480">
                                                </div>
                                            </figure>
                                        </a>
                                    </div>
                                <?php
                                    endwhile;
                                    wp_reset_postdata();
                                else :
                                    echo '<div class="col-12 text-center text-muted"><p>No awards published yet. Add items in WP Admin -> Awards & Recognition.</p></div>';
                                endif;
                                ?>
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
        $title    = $instance['title'] ?? '';
        $subtitle = $instance['subtitle'] ?? '';
        ?>

        <p><label>Section Title (HTML allowed e.g. &lt;span&gt;)</label>
        <input class="widefat" name="<?php echo $this->get_field_name('title'); ?>" value="<?php echo esc_attr($title); ?>"></p>

        <p><label>Section Subtitle</label>
        <textarea class="widefat" rows="3" name="<?php echo $this->get_field_name('subtitle'); ?>"><?php echo esc_textarea($subtitle); ?></textarea></p>

        <p class="description">
            <em>Note: Award items and images are automatically queried from the <strong>Awards & Recognition</strong> Custom Post Type (`award`). Add and manage awards in WP Admin -> Awards & Recognition!</em>
        </p>

    <?php }

    // Save Data
    public function update($new_instance, $old_instance) {
        $instance = [];
        $instance['title']    = !empty($new_instance['title']) ? wp_kses_post($new_instance['title']) : '';
        $instance['subtitle'] = !empty($new_instance['subtitle']) ? sanitize_textarea_field($new_instance['subtitle']) : '';
        return $instance;
    }
}

// Register Widget
function register_awards_section_widget() {
    register_widget('Awards_Section_Widget');
}
add_action('widgets_init', 'register_awards_section_widget');