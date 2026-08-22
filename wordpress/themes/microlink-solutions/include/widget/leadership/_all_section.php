<?php
// Leadership Section Widget
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
        echo $args['before_widget'];

        $board_title = !empty($instance['board_title']) ? $instance['board_title'] : 'Meet the <span>Board of directors</span>';
        $team_title  = !empty($instance['team_title']) ? $instance['team_title'] : 'Meet Our <span>Team</span>';
        ?>

        <section class="section-gap pt-0">
            <div class="container">
                <div class="row align-items-start mb-5 g-5">
                    <div class="col-12 text-center">
                        <h2 class="cm-title text-black"><?php echo wp_kses_post($board_title); ?></h2>
                    </div>
                </div>

                <?php $showcase = new WP_Query([
                    'post_type'  => 'team',
                    'meta_query' => [
                        [
                            'key'   => 'display_in_showcase',
                            'value' => '1'
                        ]
                    ],
                    'orderby' => 'menu_order',
                    'order'   => 'ASC'
                ]);

                $i = 1;

                if ($showcase->have_posts()) :
                    while ($showcase->have_posts()) : $showcase->the_post();
                        $img      = get_the_post_thumbnail_url(get_the_ID(), 'full');
                        $name     = get_the_title();
                        $role     = get_post_meta(get_the_ID(), '_team_role', true);
                        $linkedin = get_post_meta(get_the_ID(), '_team_linkedin', true);
                ?>

                <div class="row align-items-start mb-5 g-5">
                    <?php if ($i % 2 != 0) : ?>
                        <!-- IMAGE LEFT -->
                        <div class="col-lg-4 mb-4">
                            <div class="leader-img">
                                <div class="thumbnail-container object-fit">
                                    <div class="thumbnail">
                                        <img src="<?php echo esc_url($img); ?>" alt="<?php echo esc_attr($name); ?>" />
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

                                <?php if (!empty($linkedin)) : ?>
                                    <a href="<?php echo esc_url($linkedin); ?>" class="social-icon" target="_blank" rel="noopener">
                                        <i class="n-icon" data-icon="s-linkedin" data-iconwidth="20px" data-iconheight="20px"></i>
                                    </a>
                                <?php endif; ?>
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
                                        <img src="<?php echo esc_url($img); ?>" alt="<?php echo esc_attr($name); ?>" />
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
                        <h2 class="cm-title text-black"><?php echo wp_kses_post($team_title); ?></h2>
                    </div>

                    <?php $team = new WP_Query([
                        'post_type'      => 'team',
                        'posts_per_page' => -1,
                        'meta_query'     => [
                            'relation' => 'OR',
                            [
                                'key'     => 'display_in_showcase',
                                'compare' => '!=',
                                'value'   => '1'
                            ],
                            [
                                'key'     => 'display_in_showcase',
                                'compare' => 'NOT EXISTS'
                            ]
                        ]
                    ]);

                    if ($team->have_posts()) :
                        while ($team->have_posts()) : $team->the_post();

                            $img      = get_the_post_thumbnail_url(get_the_ID(), 'full');
                            $name     = get_the_title();
                            $role     = get_post_meta(get_the_ID(), '_team_role', true);
                            $dept     = get_post_meta(get_the_ID(), '_team_dept', true);
                            $linkedin = get_post_meta(get_the_ID(), '_team_linkedin', true);
                            $email    = get_post_meta(get_the_ID(), '_team_email', true);
                            $phone    = get_post_meta(get_the_ID(), '_team_phone', true) ?: get_post_meta(get_the_ID(), '_team_contact', true);
                    ?>

                    <div class="col-xl-3 col-md-6">
                        <div class="team-card">
                            <div class="team-img">
                                <div class="thumbnail-container object-fit">
                                    <div class="thumbnail">
                                        <img src="<?php echo esc_url($img); ?>" alt="<?php echo esc_attr($name); ?>" />
                                    </div>
                                </div>
                                <?php if (!empty($linkedin)) : ?>
                                    <div class="overlay">
                                        <a href="<?php echo esc_url($linkedin); ?>" class="social-btn" target="_blank" rel="noopener">
                                            <i class="n-icon" data-icon="s-linkedin" data-iconwidth="20px" data-iconheight="20px"></i>
                                        </a>
                                    </div>
                                <?php endif; ?>
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

    // Backend Form
    public function form($instance) {
        $board_title = $instance['board_title'] ?? '';
        $team_title  = $instance['team_title'] ?? '';
        ?>
        <p>
            <label>Board of Directors Section Title (HTML allowed e.g. &lt;span&gt;)</label>
            <input class="widefat" name="<?php echo $this->get_field_name('board_title'); ?>" value="<?php echo esc_attr($board_title); ?>">
        </p>
        <p>
            <label>Team Section Title (HTML allowed e.g. &lt;span&gt;)</label>
            <input class="widefat" name="<?php echo $this->get_field_name('team_title'); ?>" value="<?php echo esc_attr($team_title); ?>">
        </p>
    <?php }

    public function update($new_instance, $old_instance) {
        $instance = [];
        $instance['board_title'] = !empty($new_instance['board_title']) ? wp_kses_post($new_instance['board_title']) : '';
        $instance['team_title']  = !empty($new_instance['team_title']) ? wp_kses_post($new_instance['team_title']) : '';
        return $instance;
    }
}

// Register Widget
function register_leadership_section_widget() {
    register_widget('Leadership_Section_Widget');
}
add_action('widgets_init', 'register_leadership_section_widget');