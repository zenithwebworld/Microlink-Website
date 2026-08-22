<?php
// Hero Section Widget
class Leadership_Section_Widget extends WP_Widget {
    function __construct() {
        parent::__construct(
            'leadership_section',
            __('Leadership :: All Section', _THEME_DOMAIN),
            array('description' => __('Update leadership all section content', _THEME_DOMAIN))
        );
    }

    // Frontend Output
    public function widget($args, $instance) {
        echo $args['before_widget']; ?>

        <section class="section-gap pt-0">
            <div class="container">
                <div class="row align-items-start mb-5 g-5">
                    <div class="col-12 text-center">
                        <h2 class="cm-title text-black">Meet the <span>Board of directors</span></h2>
                    </div>
                </div>

                <?php $showcase = new WP_Query([
                    'post_type' => 'team',
                    'meta_query' => [
                        [
                            'key' => 'display_in_showcase',
                            'value' => '1'
                        ]
                    ],
                    'orderby' => 'menu_order',
                    'order' => 'ASC'
                ]);

                $i = 1;

                if ($showcase->have_posts()) :
                    while ($showcase->have_posts()) : $showcase->the_post();
                        $img = get_the_post_thumbnail_url(get_the_ID(), 'full');
                        $name = get_the_title();
                        $role = get_post_meta(get_the_ID(), '_team_role', true);
                        $linkedin = get_post_meta(get_the_ID(), '_team_linkedin', true);
                ?>

                <!-- KEEP SAME HTML STRUCTURE -->
                <div class="row align-items-start mb-5 g-5">

                    <?php if ($i % 2 != 0) : ?>
                        <!-- IMAGE LEFT -->
                        <div class="col-lg-4 mb-4">
                            <div class="leader-img">
                                <div class="thumbnail-container object-fit">
                                    <div class="thumbnail">
                                        <img src="<?php echo esc_url($img); ?>" />
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-8">
                    <?php else : ?>
                        <!-- CONTENT LEFT -->
                        <div class="col-lg-8">
                    <?php endif; ?>

                            <div class="d-flex justify-content-between mb-3">
                                <div>
                                    <h2 class="leader-title"><?php echo esc_html($name); ?></h2>
                                    <p class="leader-role"><?php echo esc_html($role); ?></p>
                                </div>

                                <a href="<?php echo esc_url($linkedin); ?>" class="social-icon">
                                    <i class="n-icon" data-icon="s-linkedin" data-iconwidth="20px" data-iconheight="20px"></i>
                                </a>
                            </div>

                            <div class="cms mt-4">
                                <?php echo apply_filters('the_content', get_the_content()); ?>
                            </div>
                        </div>

                    <?php if ($i % 2 == 0) : ?>
                        <!-- IMAGE RIGHT -->
                        <div class="col-lg-4 mb-4">
                            <div class="leader-img">
                                <div class="thumbnail-container object-fit">
                                    <div class="thumbnail">
                                        <img src="<?php echo esc_url($img); ?>" />
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endif; ?>
                </div>

                <?php
                    $i++;
                    endwhile;
                    wp_reset_postdata();
                endif;
                ?>

            </div>
        </section>

        <!-- TEAM GRID -->
        <section class="section-gap">
            <div class="container">
                <div class="row g-4">
                    <div class="col-12 text-center">
                        <h2 class="cm-title text-black">Meet Our <span>Team</span></h2>
                    </div>

                    <?php $team = new WP_Query([
                        'post_type' => 'team',
                        'posts_per_page' => -1,
                        'meta_query' => [
                            [
                                'key' => 'display_in_showcase',
                                'compare' => '!=',
                                'value' => '1'
                            ]
                        ]
                    ]);

                    if ($team->have_posts()) :
                        while ($team->have_posts()) : $team->the_post();

                            $img = get_the_post_thumbnail_url(get_the_ID(), 'full');
                            $name = get_the_title();
                            $role = get_post_meta(get_the_ID(), '_team_role', true);
                            $dept = get_post_meta(get_the_ID(), '_team_dept', true);
                            $linkedin = get_post_meta(get_the_ID(), '_team_linkedin', true);
                            $email = get_post_meta(get_the_ID(), '_team_email', true);
                            $phone = get_post_meta(get_the_ID(), '_team_phone', true) ?: get_post_meta(get_the_ID(), '_team_contact', true);
                    ?>

                    <div class="col-xl-3 col-md-6">
                        <div class="team-card">
                            <div class="team-img">
                                <div class="thumbnail-container object-fit">
                                    <div class="thumbnail">
                                        <img src="<?php echo esc_url($img); ?>" />
                                    </div>
                                </div>
                                <div class="overlay">
                                    <a href="<?php echo esc_url($linkedin); ?>" class="social-btn">
                                        <i class="n-icon" data-icon="s-linkedin" data-iconwidth="20px" data-iconheight="20px"></i>
                                    </a>
                                </div>
                            </div>

                            <div class="team-content">
                                <div class="team-name"><?php echo esc_html($name); ?></div>
                                <div class="team-role"><?php echo esc_html($role); ?></div>
                                <div class="team-dept"><?php echo esc_html($dept); ?></div>
                                <?php if (!empty($email)) : ?>
                                    <div class="team-email mt-2">
                                        <a href="mailto:<?php echo esc_attr($email); ?>" class="text-muted text-decoration-none">
                                            <?php echo esc_html($email); ?>
                                        </a>
                                    </div>
                                <?php endif; ?>
                                <?php if (!empty($phone)) : ?>
                                    <div class="team-phone mt-1">
                                        <a href="tel:<?php echo esc_attr($phone); ?>" class="text-muted text-decoration-none">
                                            <?php echo esc_html($phone); ?>
                                        </a>
                                    </div>
                                <?php endif; ?>
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
        </section>

        <?php echo $args['after_widget'];
    }

    // Backend Form (unchanged)
    public function form($instance) { ?>
        <p><strong>Teams are automatically fetched from CPT (team)</strong></p>
    <?php }

    public function update($new_instance, $old_instance) {
        return [];
    }
}

// Register Widget
function register_leadership_section_widget() {
    register_widget('Leadership_Section_Widget');
}
add_action('widgets_init', 'register_leadership_section_widget');