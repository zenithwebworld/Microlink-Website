<?php
// Home Blog Section Widget
class Home_Blog_Section_Widget extends WP_Widget {

    function __construct() {
        parent::__construct(
            'home_blog_section',
            __('Homepage :: Blog Section', _THEME_DOMAIN),
            array('description' => __('Update blog section content', _THEME_DOMAIN))
        );
    }

    // Frontend Output
    public function widget($args, $instance) {
        echo $args['before_widget'];

        $title    = !empty($instance['title']) ? $instance['title'] : 'Stay connected with the technology <span>with our latest blogs</span>';
        $desc     = !empty($instance['desc']) ? $instance['desc'] : 'Explore our latest blogs on technology, digital transformation that connect with you the right knowledge';
        $btn_text = !empty($instance['btn_text']) ? $instance['btn_text'] : 'View All Blogs';
        ?>

        <section class="blog-section section-gap double-gap">
            <div class="container">
                <div class="row align-items-center mb-sm-5 mb-4 justify-content-between">
                    <div class="col-md-8 col-xl-5">
                        <h2 class="cm-title text-black fs-40 mb-2"><?php echo wp_kses_post($title); ?></h2>
                        <p class="text-muted"><?php echo esc_html($desc); ?></p>
                    </div>
                    <div class="col-md-4 text-md-end mt-3 mt-md-0">
                        <?php if (!empty($btn_text)) : ?>
                            <a href="<?php echo esc_url(get_permalink(get_option('page_for_posts')) ?: home_url('/blogs')); ?>" class="btn btn-primary">
                                <?php echo esc_html($btn_text); ?>
                            </a>
                        <?php endif; ?>
                    </div>
                </div>
                <div class="row g-4">
                    <?php
                    $query = new WP_Query([
                        'post_type'      => 'post',
                        'posts_per_page' => 4
                    ]);

                    if ($query->have_posts()) :
                        $count = 0;

                        while ($query->have_posts()) : $query->the_post();
                            $count++;

                            $img = get_the_post_thumbnail_url(get_the_ID(), 'full');
                            $img = $img ?: get_template_directory_uri().'/assets/images/blog-default.png';

                            $post_title = get_the_title();
                            $post_desc  = wp_trim_words(get_the_excerpt(), 18);
                            $link       = get_permalink();
                            $date       = get_the_date('M d, Y');
                            $author     = get_the_author();
                            $cat        = get_the_category();
                            $cat_name   = !empty($cat) ? $cat[0]->name : '';
                    ?>

                    <?php if ($count == 1) : ?>

                        <!-- MAIN BLOG -->
                        <div class="col-lg-6">
                            <div class="blog-main-card bg-white c-card" data-aos="fade-up" data-aos-delay="80">
                                <div class="thumbnail-container object-fit rounded-3">
                                    <div class="thumbnail">
                                        <img src="<?php echo esc_url($img); ?>" alt="Blog" width="891" height="594">
                                    </div>
                                </div>
                                <div class="content pt-4">
                                    <div class="post-small-tags small text-uppercase text-primary mb-1">
                                        <?php echo esc_html($cat_name); ?>
                                        <span class="text-muted">| <?php echo esc_html($date); ?></span>
                                    </div>
                                    <div class="fw-bold mt-3"><?php echo esc_html($author); ?></div>
                                    <h2 class="h2 mb-3"><?php echo esc_html($post_title); ?></h2>
                                    <p class="text-muted"><?php echo esc_html($post_desc); ?></p>
                                    <a href="<?php echo esc_url($link); ?>" class="btn btn-link button-up mt-4">Read More</a>
                                </div>
                            </div>
                        </div>

                        <!-- OPEN RIGHT SIDE -->
                        <div class="col-lg-6">
                            <div class="row right-side g-4">

                    <?php else : ?>

                        <!-- SIDE BLOG -->
                        <div class="col-12">
                            <div class="item c-card d-flex align-content-center flex-column flex-sm-row"
                                data-aos="fade-up" data-aos-delay="<?php echo esc_attr(100 + ($count * 20)); ?>">
                                <div class="thumbnail-container object-fit">
                                    <div class="thumbnail">
                                        <img src="<?php echo esc_url($img); ?>" alt="" width="88" height="66" class="rounded-2 object-fit">
                                    </div>
                                </div>
                                <div class="ms-sm-3 pt-3 pt-sm-0">
                                    <div class="post-small-tags small text-uppercase text-primary mb-3">
                                        <?php echo esc_html($cat_name); ?>
                                        <span class="text-muted">| <?php echo esc_html($date); ?></span>
                                    </div>
                                    <h4 class="mb-3"><?php echo esc_html($post_title); ?></h4>
                                    <p class="text-muted"><?php echo esc_html($post_desc); ?></p>
                                    <a href="<?php echo esc_url($link); ?>" class="btn btn-link button-up mt-3">Read More</a>
                                </div>
                            </div>
                        </div>

                    <?php endif; ?>

                    <?php
                        endwhile;
                        wp_reset_postdata();
                    else :
                        echo '<div class="col-12 text-center text-muted"><p>No blog posts published yet.</p></div>';
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
        $title    = $instance['title'] ?? '';
        $desc     = $instance['desc'] ?? '';
        $btn_text = $instance['btn_text'] ?? '';
        ?>

        <p><label>Section Title (HTML allowed e.g. &lt;span&gt;)</label>
        <input class="widefat" name="<?php echo $this->get_field_name('title'); ?>" value="<?php echo esc_attr($title); ?>"></p>

        <p><label>Section Subtitle</label>
        <textarea class="widefat" rows="2" name="<?php echo $this->get_field_name('desc'); ?>"><?php echo esc_textarea($desc); ?></textarea></p>

        <p><label>Button Text</label>
        <input class="widefat" name="<?php echo $this->get_field_name('btn_text'); ?>" value="<?php echo esc_attr($btn_text); ?>"></p>
    <?php }

    // Save Data
    public function update($new_instance, $old_instance) {
        $instance = [];
        $instance['title']    = !empty($new_instance['title']) ? wp_kses_post($new_instance['title']) : '';
        $instance['desc']     = !empty($new_instance['desc']) ? sanitize_textarea_field($new_instance['desc']) : '';
        $instance['btn_text'] = !empty($new_instance['btn_text']) ? sanitize_text_field($new_instance['btn_text']) : '';
        return $instance;
    }
}

// Register Widget
function register_blog_about_section_widget() {
    register_widget('Home_Blog_Section_Widget');
}
add_action('widgets_init', 'register_blog_about_section_widget');