<?php
// Case Studies Section Widget
class Case_Studies_Section_Widget extends WP_Widget {
    function __construct() {
        parent::__construct(
            'case_studies_section',
            __('Common :: Case Studies Section', _THEME_DOMAIN),
            array('description' => __('Display dynamic case studies grid or slider', _THEME_DOMAIN))
        );
    }

    // Frontend Output
    public function widget($args, $instance) {
        echo $args['before_widget'];

        $title      = !empty($instance['title']) ? $instance['title'] : 'Transforming Vision into Results <span>Case Studies</span>';
        $subtitle   = !empty($instance['subtitle']) ? $instance['subtitle'] : 'See how we turn complex business challenges into measurable results through strategic technology implementation.';
        $posts_count = !empty($instance['posts_count']) ? intval($instance['posts_count']) : 6;
        $layout_type = !empty($instance['layout_type']) ? $instance['layout_type'] : 'carousel'; // carousel or grid
        ?>
        <section class="case-study-section section-gap common-owl">
            <div class="container">
                <div class="row align-items-end mb-4">
                    <div class="col-lg-9" data-aos="fade-up" data-aos-delay="80">
                        <h2 class="cm-title text-black fs-40 mb-2"><?php echo wp_kses_post($title); ?></h2>
                        <p class="text-muted mb-0"><?php echo esc_html($subtitle); ?></p>
                    </div>
                    <div class="col-lg-3 text-lg-end mt-3 mt-lg-0" data-aos="fade-up" data-aos-delay="100">
                        <a href="<?php echo esc_url(get_post_type_archive_link('case_study') ?: home_url('/case-studies')); ?>" class="btn btn-outline-primary fw-bold" title="View All Case Studies">
                            View All Case Studies
                        </a>
                    </div>
                </div>

                <?php
                $cs_query = new WP_Query([
                    'post_type'      => 'case_study',
                    'posts_per_page' => $posts_count,
                    'orderby'        => 'date',
                    'order'          => 'DESC'
                ]);

                // Fallback to story CPT if case_study has no posts yet
                if (!$cs_query->have_posts()) {
                    $cs_query = new WP_Query([
                        'post_type'      => 'story',
                        'posts_per_page' => $posts_count,
                        'orderby'        => 'date',
                        'order'          => 'DESC'
                    ]);
                }

                if ($cs_query->have_posts()) :
                ?>
                    <?php if ($layout_type === 'carousel') : ?>
                        <div class="row">
                            <div class="col-12">
                                <div class="owl-carousel portfolio-slider">
                                    <?php
                                    while ($cs_query->have_posts()) : $cs_query->the_post();
                                        $c_title       = get_the_title();
                                        $custom_img    = get_post_meta(get_the_ID(), 'custom_image_url', true);
                                        $feat_img      = !empty($custom_img) ? $custom_img : get_the_post_thumbnail_url(get_the_ID(), 'full');
                                        $feat_img      = !empty($feat_img) ? $feat_img : get_template_directory_uri() . '/assets/images/blog-large.webp';
                                        
                                        $badge1        = get_post_meta(get_the_ID(), 'badge_1', true) ?: 'Case Study';
                                        $badge2        = get_post_meta(get_the_ID(), 'badge_2', true) ?: 'Results';
                                        $client_name   = get_post_meta(get_the_ID(), 'client_name', true) ?: '';
                                        $pdf_url       = get_post_meta(get_the_ID(), 'pdf_url', true);
                                        $link          = !empty($pdf_url) ? $pdf_url : get_permalink();
                                        $desc          = wp_trim_words(get_the_excerpt(), 14);
                                    ?>
                                        <div class="portfolio-card shadow-sm rounded-3 overflow-hidden">
                                            <div class="thumbnail-container object-fit rounded-3">
                                                <div class="thumbnail">
                                                    <a href="<?php echo esc_url($link); ?>" <?php echo !empty($pdf_url) ? 'target="_blank"' : ''; ?>>
                                                        <img src="<?php echo esc_url($feat_img); ?>" alt="<?php echo esc_attr($c_title); ?>" width="891" height="594">
                                                    </a>
                                                </div>
                                                <div class="overlay p-4 d-flex flex-column justify-content-end">
                                                    <div class="mb-2">
                                                        <span class="badge bg-light text-dark me-1"><?php echo esc_html($badge1); ?></span>
                                                        <span class="badge bg-light text-dark"><?php echo esc_html($badge2); ?></span>
                                                    </div>
                                                    <?php if (!empty($client_name)) : ?>
                                                        <div class="small text-white-50 text-uppercase fw-bold mb-1"><?php echo esc_html($client_name); ?></div>
                                                    <?php endif; ?>
                                                    <h4 class="my-2 text-white fs-5 fw-bold">
                                                        <a href="<?php echo esc_url($link); ?>" class="text-white text-decoration-none" <?php echo !empty($pdf_url) ? 'target="_blank"' : ''; ?>><?php echo esc_html($c_title); ?></a>
                                                    </h4>
                                                    <p class="text-white opacity-75 small mb-0"><?php echo esc_html($desc); ?></p>
                                                </div>
                                            </div>
                                        </div>
                                    <?php
                                    endwhile;
                                    wp_reset_postdata();
                                    ?>
                                </div>
                            </div>
                        </div>
                    <?php else : ?>
                        <!-- Grid Layout -->
                        <div class="row g-4">
                            <?php
                            while ($cs_query->have_posts()) : $cs_query->the_post();
                                $c_title       = get_the_title();
                                $custom_img    = get_post_meta(get_the_ID(), 'custom_image_url', true);
                                $feat_img      = !empty($custom_img) ? $custom_img : get_the_post_thumbnail_url(get_the_ID(), 'full');
                                $feat_img      = !empty($feat_img) ? $feat_img : get_template_directory_uri() . '/assets/images/blog-large.webp';
                                
                                $badge1        = get_post_meta(get_the_ID(), 'badge_1', true) ?: 'Case Study';
                                $badge2        = get_post_meta(get_the_ID(), 'badge_2', true) ?: 'Results';
                                $client_name   = get_post_meta(get_the_ID(), 'client_name', true) ?: '';
                                $pdf_url       = get_post_meta(get_the_ID(), 'pdf_url', true);
                                $link          = !empty($pdf_url) ? $pdf_url : get_permalink();
                                $desc          = wp_trim_words(get_the_excerpt(), 14);
                            ?>
                                <div class="col-lg-4 col-md-6">
                                    <div class="portfolio-card shadow-sm rounded-3 overflow-hidden h-100">
                                        <div class="thumbnail-container object-fit rounded-3">
                                            <div class="thumbnail">
                                                <a href="<?php echo esc_url($link); ?>" <?php echo !empty($pdf_url) ? 'target="_blank"' : ''; ?>>
                                                    <img src="<?php echo esc_url($feat_img); ?>" alt="<?php echo esc_attr($c_title); ?>" width="891" height="594">
                                                </a>
                                            </div>
                                            <div class="overlay p-4 d-flex flex-column justify-content-end">
                                                <div class="mb-2">
                                                    <span class="badge bg-light text-dark me-1"><?php echo esc_html($badge1); ?></span>
                                                    <span class="badge bg-light text-dark"><?php echo esc_html($badge2); ?></span>
                                                </div>
                                                <?php if (!empty($client_name)) : ?>
                                                    <div class="small text-white-50 text-uppercase fw-bold mb-1"><?php echo esc_html($client_name); ?></div>
                                                <?php endif; ?>
                                                <h4 class="my-2 text-white fs-5 fw-bold">
                                                    <a href="<?php echo esc_url($link); ?>" class="text-white text-decoration-none" <?php echo !empty($pdf_url) ? 'target="_blank"' : ''; ?>><?php echo esc_html($c_title); ?></a>
                                                </h4>
                                                <p class="text-white opacity-75 small mb-0"><?php echo esc_html($desc); ?></p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?php
                            endwhile;
                            wp_reset_postdata();
                            ?>
                        </div>
                    <?php endif; ?>
                <?php else : ?>
                    <div class="row">
                        <div class="col-12 text-center text-muted">
                            <p>No case studies available at the moment.</p>
                        </div>
                    </div>
                <?php endif; ?>
            </div>
        </section>

        <?php echo $args['after_widget'];
    }

    // Backend Form
    public function form($instance) {
        $title       = $instance['title'] ?? '';
        $subtitle    = $instance['subtitle'] ?? '';
        $posts_count = $instance['posts_count'] ?? '6';
        $layout_type = $instance['layout_type'] ?? 'carousel';
        ?>
        <p>
            <label>Section Title (HTML allowed e.g. &lt;span&gt;)</label>
            <input class="widefat" name="<?php echo $this->get_field_name('title'); ?>" value="<?php echo esc_attr($title); ?>">
        </p>
        <p>
            <label>Section Subtitle</label>
            <textarea class="widefat" rows="2" name="<?php echo $this->get_field_name('subtitle'); ?>"><?php echo esc_textarea($subtitle); ?></textarea>
        </p>
        <p>
            <label>Number of Case Studies to Display</label>
            <input class="widefat" type="number" name="<?php echo $this->get_field_name('posts_count'); ?>" value="<?php echo esc_attr($posts_count); ?>">
        </p>
        <p>
            <label>Display Layout</label>
            <select class="widefat" name="<?php echo $this->get_field_name('layout_type'); ?>">
                <option value="carousel" <?php selected($layout_type, 'carousel'); ?>>Carousel Slider</option>
                <option value="grid" <?php selected($layout_type, 'grid'); ?>>3-Column Grid</option>
            </select>
        </p>
    <?php }

    // Save Data
    public function update($new_instance, $old_instance) {
        $instance = [];
        $instance['title']       = !empty($new_instance['title']) ? wp_kses_post($new_instance['title']) : '';
        $instance['subtitle']    = !empty($new_instance['subtitle']) ? sanitize_textarea_field($new_instance['subtitle']) : '';
        $instance['posts_count'] = !empty($new_instance['posts_count']) ? intval($new_instance['posts_count']) : 6;
        $instance['layout_type'] = !empty($new_instance['layout_type']) ? sanitize_text_field($new_instance['layout_type']) : 'carousel';
        return $instance;
    }
}

// Register Widget
function register_case_studies_section_widget() {
    register_widget('Case_Studies_Section_Widget');
}
add_action('widgets_init', 'register_case_studies_section_widget');
