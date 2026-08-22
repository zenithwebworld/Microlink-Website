<?php
// Partnership Section Widget
class Partnership_Section_Widget extends WP_Widget {
    function __construct() {
        parent::__construct(
            'partnership_section',
            __('Partnership :: All Section', _THEME_DOMAIN),
            array('description' => __('Update partnership all section content', _THEME_DOMAIN))
        );
    }

    // Frontend Output
    public function widget($args, $instance) {
        echo $args['before_widget'];

        $title    = !empty($instance['title']) ? $instance['title'] : 'Our Technology <span>Partners</span>';
        $subtitle = !empty($instance['subtitle']) ? $instance['subtitle'] : 'We collaborate with industry-leading technology providers to deliver robust, future-ready solutions.';

        $terms = get_terms([
            'taxonomy'   => 'partner_category',
            'hide_empty' => false,
        ]);
        ?>

        <section class="partner-page section-gap">
            <div class="container">
                <div class="row align-items-center mb-4 justify-content-center">
                    <div class="col-md-8 text-center">
                        <h2 class="cm-title text-black fs-40 mb-3"><?php echo wp_kses_post($title); ?></h2>
                        <p class="text-muted"><?php echo esc_html($subtitle); ?></p>
                    </div>
                </div>

                <div class="d-flex justify-content-center align-items-center flex-wrap cm-nav mb-4">
                    <ul class="nav nav-pills mt-3 mt-md-0" id="partnerTab" role="tablist">
                        <li class="nav-item">
                            <button class="nav-link active" data-bs-toggle="pill" data-bs-target="#partner-all">All Partners</button>
                        </li>
                        <?php if (!empty($terms) && !is_wp_error($terms)) : ?>
                            <?php foreach ($terms as $term) : ?>
                                <li class="nav-item">
                                    <button class="nav-link" data-bs-toggle="pill" data-bs-target="#partner-<?php echo esc_attr($term->slug); ?>">
                                        <?php echo esc_html($term->name); ?>
                                    </button>
                                </li>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </ul>
                </div>

                <div class="tab-content" id="partnerTabContent">
                    <!-- ALL PARTNERS TAB -->
                    <div class="tab-pane fade show active mt-4" id="partner-all">
                        <div class="row g-4">
                            <?php
                            $all_partners = new WP_Query([
                                'post_type'      => 'partner',
                                'posts_per_page' => -1,
                            ]);

                            if ($all_partners->have_posts()) :
                                while ($all_partners->have_posts()) : $all_partners->the_post();
                                    $logo = get_the_post_thumbnail_url(get_the_ID(), 'full');
                            ?>
                                <div class="col-md-6 col-lg-3">
                                    <div class="partner-card h-100 p-3 bg-white border rounded text-center d-flex align-items-center justify-content-center">
                                        <div class="thumbnail-container">
                                            <div class="thumbnail">
                                                <?php if (!empty($logo)) : ?>
                                                    <img src="<?php echo esc_url($logo); ?>" alt="<?php the_title_attribute(); ?>" style="max-height: 80px; width: auto;">
                                                <?php else : ?>
                                                    <span class="fw-bold"><?php the_title(); ?></span>
                                                <?php endif; ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?php
                                endwhile;
                                wp_reset_postdata();
                            else :
                                echo '<div class="col-12 text-center text-muted"><p>No partners added yet.</p></div>';
                            endif;
                            ?>
                        </div>
                    </div>

                    <!-- CATEGORY TABS -->
                    <?php if (!empty($terms) && !is_wp_error($terms)) : ?>
                        <?php foreach ($terms as $term) : ?>
                            <div class="tab-pane fade mt-4" id="partner-<?php echo esc_attr($term->slug); ?>">
                                <div class="row g-4">
                                    <div class="col-12"><h3 class="h5 fw-bold text-primary mb-3"><?php echo esc_html($term->name); ?></h3></div>
                                    <?php
                                    $cat_partners = new WP_Query([
                                        'post_type'      => 'partner',
                                        'posts_per_page' => -1,
                                        'tax_query'      => [
                                            [
                                                'taxonomy' => 'partner_category',
                                                'field'    => 'slug',
                                                'terms'    => $term->slug,
                                            ]
                                        ]
                                    ]);

                                    if ($cat_partners->have_posts()) :
                                        while ($cat_partners->have_posts()) : $cat_partners->the_post();
                                            $cat_logo = get_the_post_thumbnail_url(get_the_ID(), 'full');
                                    ?>
                                        <div class="col-md-6 col-lg-3">
                                            <div class="partner-card h-100 p-3 bg-white border rounded text-center d-flex align-items-center justify-content-center">
                                                <div class="thumbnail-container">
                                                    <div class="thumbnail">
                                                        <?php if (!empty($cat_logo)) : ?>
                                                            <img src="<?php echo esc_url($cat_logo); ?>" alt="<?php the_title_attribute(); ?>" style="max-height: 80px; width: auto;">
                                                        <?php else : ?>
                                                            <span class="fw-bold"><?php the_title(); ?></span>
                                                        <?php endif; ?>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    <?php
                                        endwhile;
                                        wp_reset_postdata();
                                    else :
                                        echo '<div class="col-12 text-center text-muted"><p>No partners in this category.</p></div>';
                                    endif;
                                    ?>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    <?php endif; ?>
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
        <textarea class="widefat" rows="2" name="<?php echo $this->get_field_name('subtitle'); ?>"><?php echo esc_textarea($subtitle); ?></textarea></p>
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
function register_partnership_section_widget() {
    register_widget('Partnership_Section_Widget');
}
add_action('widgets_init', 'register_partnership_section_widget');