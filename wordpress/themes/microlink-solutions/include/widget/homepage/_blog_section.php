<?php
// Hero Section Widget
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
        ?>

        <section class="blog-section section-gap double-gap">
            <div class="container">
                <div class="row align-items-center mb-sm-5 mb-4 justify-content-between">
                    <div class="col-md-8 col-xl-5">
                        <h2 class="cm-title text-black fs-40 mb-2">
                            Stay connected with the technology <span>with our latest blogs</span>
                        </h2>
                        <p class="text-muted">Explore our latest blogs on technology, digital transformation that connect with you the right knowledge</p>
                    </div>
                    <div class="col-md-4 text-md-end mt-3 mt-md-0">
                        <a href="<?php echo esc_url(get_permalink(get_option('page_for_posts'))); ?>" class="btn btn-primary">View All Blogs</a>
                    </div>
                </div>
                <div class="row g-4">
                    <?php
                    $query = new WP_Query([
                        'post_type' => 'post',
                        'posts_per_page' => 4
                    ]);

                    if ($query->have_posts()) :
                        $count = 0;
                        $side_open = false;

                        while ($query->have_posts()) : $query->the_post();
                            $count++;

                            $img = get_the_post_thumbnail_url(get_the_ID(), 'full');
                            $img = $img ?: get_template_directory_uri().'/assets/images/blog-default.png';

                            $title = get_the_title();
                            $desc = wp_trim_words(get_the_excerpt(), 18);
                            $link = get_permalink();
                            $date = get_the_date('M d, Y');
                            $author = get_the_author();
                            $cat = get_the_category();
                            $cat_name = !empty($cat) ? $cat[0]->name : '';
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
                                    <h2 class="h2 mb-3"><?php echo esc_html($title); ?></h2>
                                    <p class="text-muted"><?php echo esc_html($desc); ?></p>
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
                                    <h4 class="mb-3"><?php echo esc_html($title); ?></h4>
                                    <p class="text-muted"><?php echo esc_html($desc); ?></p>
                                    <a href="<?php echo esc_url($link); ?>" class="btn btn-link button-up mt-3">Read More</a>
                                </div>
                            </div>
                        </div>

                    <?php endif; ?>

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

    // Backend Form (UNCHANGED)
    public function form($instance) { ?>
        <p><strong>Blogs are automatically fetched from CPT (posts)</strong></p>
    <?php }

    // Save Data (UNCHANGED)
    public function update($new_instance, $old_instance) {
        $instance = [];
        return $instance;
    }
}

// Register Widget
function register_blog_about_section_widget() {
    register_widget('Home_Blog_Section_Widget');
}
add_action('widgets_init', 'register_blog_about_section_widget');