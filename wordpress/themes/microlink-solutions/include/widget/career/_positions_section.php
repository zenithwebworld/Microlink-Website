<?php
// Career Position Section Widget
class Career_Position_Section_Widget extends WP_Widget {
    function __construct() {
        parent::__construct(
            'career_position_section',
            __('Career :: Position', _THEME_DOMAIN),
            array('description' => __('Update position content', _THEME_DOMAIN))
        );
    }

    // Frontend Output
    public function widget($args, $instance) {
        echo $args['before_widget'];
        
        $title = !empty($instance['title']) ? $instance['title'] : 'Our <span>Open</span> Positions';
        $desc  = !empty($instance['desc']) ? $instance['desc'] : 'Explore detailed opportunities to grow with our expert IT team.';
        ?>

        <section class="openings-section section-gap bg-light">
            <div class="container">
                <div class="row align-items-end mb-4">
                    <div class="col-md-8">
                        <h2 class="cm-title text-black fs-40">
                            <?php echo wp_kses_post($title); ?>
                        </h2>
                        <p class="text-muted"><?php echo esc_html($desc); ?></p>
                    </div>
                </div>
                <div class="row align-items-end g-4">
                    <?php
                    $jobs = new WP_Query([
                        'post_type'      => 'job',
                        'posts_per_page' => -1
                    ]);

                    if ($jobs->have_posts()) :
                        while ($jobs->have_posts()) : $jobs->the_post();

                            $job_type   = get_post_meta(get_the_ID(), 'job_type', true);
                            $job_id     = get_post_meta(get_the_ID(), 'job_id', true);
                            $openings   = get_post_meta(get_the_ID(), 'openings', true);
                            $experience = get_post_meta(get_the_ID(), 'experience', true);
                            $location   = get_post_meta(get_the_ID(), 'location', true);
                            $skills     = get_post_meta(get_the_ID(), 'skills', true);

                            $skills_array = !empty($skills) ? explode(',', $skills) : [];
                    ?>

                    <div class="col-xl-6">
                        <div class="job-card p-4 mb-4 h-100">
                            <div class="row">
                                <div class="col-lg-8">
                                    <div class="d-flex flex-wrap align-items-center gap-3 mb-3">
                                        <?php if (!empty($job_type)) : ?>
                                            <span class="job-label"><?php echo esc_html($job_type); ?></span>
                                        <?php endif; ?>
                                        <?php if (!empty($job_id)) : ?>
                                            <small class="text-muted">Job ID: <?php echo esc_html($job_id); ?></small>
                                        <?php endif; ?>
                                        <?php if (!empty($openings)) : ?>
                                            <small class="border px-2 py-1 rounded text-muted"><?php echo esc_html($openings); ?> Openings</small>
                                        <?php endif; ?>
                                    </div>

                                    <h4 class="fw-bold mb-3"><?php the_title(); ?></h4>

                                    <p class="text-muted small mb-4">
                                        <?php echo wp_trim_words(get_the_content(), 25); ?>
                                    </p>

                                    <div class="d-flex flex-wrap gap-2">
                                        <?php foreach ($skills_array as $skill) : ?>
                                            <span class="tag"><?php echo esc_html(trim($skill)); ?></span>
                                        <?php endforeach; ?>
                                    </div>
                                </div>

                                <div class="col-lg-4 job-side ps-lg-4 d-flex flex-column justify-content-between">
                                    <div>
                                        <?php if (!empty($experience)) : ?>
                                            <div class="d-flex align-items-center mb-3">
                                                <span class="material-symbols-outlined me-2 text-muted"><i class="n-icon" data-icon="s-experience" data-iconwidth="24px" data-iconheight="24px"></i></span>
                                                <div>
                                                    <small class="text-muted d-block">Experience</small>
                                                    <strong><?php echo esc_html($experience); ?></strong>
                                                </div>
                                            </div>
                                        <?php endif; ?>

                                        <?php if (!empty($location)) : ?>
                                            <div class="d-flex align-items-center">
                                                <span class="material-symbols-outlined me-2 text-muted"><i class="n-icon" data-icon="s-location" data-iconwidth="24px" data-iconheight="24px"></i></span>
                                                <div>
                                                    <small class="text-muted d-block">Location</small>
                                                    <strong><?php echo esc_html($location); ?></strong>
                                                </div>
                                            </div>
                                        <?php endif; ?>
                                    </div>

                                    <div class="mt-4 d-grid gap-2">
                                        <a href="<?php echo esc_url(home_url('/application-form?job_id=' . $job_id)); ?>" class="btn btn-primary">
                                            Apply Now
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <?php
                        endwhile;
                        wp_reset_postdata();
                    else :
                        echo '<div class="col-12 text-center text-muted"><p>No open positions at this moment.</p></div>';
                    endif;
                    ?>
                </div>
            </div>
        </section>
        
        <?php echo $args['after_widget'];
    }

    // Backend Form
    public function form($instance) {
        $title = $instance['title'] ?? '';
        $desc  = $instance['desc'] ?? '';
        ?>
        <p>
            <label>Section Title (HTML allowed e.g. &lt;span&gt;)</label>
            <input class="widefat" name="<?php echo $this->get_field_name('title'); ?>" value="<?php echo esc_attr($title); ?>">
        </p>
        <p>
            <label>Section Description</label>
            <textarea class="widefat" rows="2" name="<?php echo $this->get_field_name('desc'); ?>"><?php echo esc_textarea($desc); ?></textarea>
        </p>
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
function register_career_position_section_widget() {
    register_widget('Career_Position_Section_Widget');
}
add_action('widgets_init', 'register_career_position_section_widget');