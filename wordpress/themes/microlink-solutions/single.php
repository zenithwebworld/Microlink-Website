<?php
/**
 * The template for displaying single blog details matching blog-details.html
 *
 * @package microlink-solutions
 */

get_header();

$post_id  = get_the_ID();
$title    = get_the_title();
$feat_img = get_the_post_thumbnail_url($post_id, 'full');
$feat_img = $feat_img ?: get_template_directory_uri() . '/assets/images/blog-large.webp';
$date     = get_the_date('M d, Y');
$author   = get_the_author();
$cat      = get_the_category();
$cat_name = !empty($cat) ? $cat[0]->name : 'Digital';
?>

<!-- Banner Section -->
<section class="inner-banner-01 position-relative bg-light">
    <div class="container py-4">
        <div class="row align-items-center">
            <div class="col-lg-7 col-md-6">
                <h1 class="display-5 fw-bold text-black mb-0"><?php echo esc_html($title); ?></h1>
            </div>
            <div class="col-lg-5 col-md-6 text-md-end mt-3 mt-md-0">
                <div class="d-flex align-items-center justify-content-md-end">
                    <ul class="custom-breadcrumb-1 list-unstyled d-flex align-items-center gap-2 mb-0">
                        <li><a href="<?php echo esc_url(home_url('/')); ?>" title="Home" class="text-dark text-decoration-none">Home</a></li>
                        <li class="text-muted">/</li>
                        <li><a href="<?php echo esc_url(get_permalink(get_option('page_for_posts')) ?: home_url('/blogs')); ?>" title="Blog" class="text-dark text-decoration-none">Blog</a></li>
                        <li class="text-muted">/</li>
                        <li class="active text-primary fw-bold"><?php echo esc_html(wp_trim_words($title, 4)); ?></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Blog Details Section -->
<section class="blog-details section-gap">
    <div class="container">
        <div class="row g-lg-5 g-4">
            <!-- Left Content Column -->
            <div class="col-lg-8">
                <?php if (!empty($feat_img)) : ?>
                    <div class="p-2 bg-light rounded-3 mb-3">
                        <div class="thumbnail-container object-fit rounded-3">
                            <div class="thumbnail">
                                <img src="<?php echo esc_url($feat_img); ?>" alt="<?php echo esc_attr($title); ?>" width="891" height="594">
                            </div>
                        </div>
                    </div>
                <?php endif; ?>

                <div class="post-small-tags small text-uppercase text-primary mb-1">
                    <?php echo esc_html($cat_name); ?> <span class="text-muted">| <?php echo esc_html($date); ?></span>
                </div>
                <div class="fw-bold mt-3 text-dark"><?php echo esc_html($author); ?></div>
                <h2 class="mb-3 text-black fw-bold mt-2"><?php echo esc_html($title); ?></h2>

                <div class="cms">
                    <?php
                    while (have_posts()) : the_post();
                        the_content();
                    endwhile;
                    ?>
                </div>
            </div>

            <!-- Right Sidebar Column -->
            <div class="col-lg-4">
                <div class="position-sticky top-25">
                    <!-- Related Recent Blogs Card -->
                    <div class="card sidebar-card mb-4 border-0 shadow-sm rounded-3">
                        <div class="card-body p-4">
                            <h4 class="mb-4 text-primary fw-bold">Related Recent Blogs</h4>
                            <?php
                            $recent_query = new WP_Query([
                                'post_type'      => 'post',
                                'posts_per_page' => 3,
                                'post__not_in'   => [$post_id]
                            ]);

                            if ($recent_query->have_posts()) :
                                while ($recent_query->have_posts()) : $recent_query->the_post();
                                    $r_img   = get_the_post_thumbnail_url(get_the_ID(), 'medium') ?: get_template_directory_uri() . '/assets/images/blog-large.webp';
                                    $r_title = get_the_title();
                                    $r_link  = get_permalink();
                                    $r_date  = get_the_date('M d, Y');
                                    $r_author = get_the_author();
                                    $r_cat   = get_the_category();
                                    $r_cat_name = !empty($r_cat) ? $r_cat[0]->name : 'Digital';
                            ?>
                                    <div class="media d-flex align-items-start mb-4">
                                        <div class="thumbnail-container object-fit rounded-3 me-3" style="width:80px; flex-shrink:0;">
                                            <div class="thumbnail">
                                                <a href="<?php echo esc_url($r_link); ?>">
                                                    <img src="<?php echo esc_url($r_img); ?>" alt="<?php echo esc_attr($r_title); ?>" width="80" height="60" class="rounded-3">
                                                </a>
                                            </div>
                                        </div>
                                        <div class="media-body ms-3">
                                            <div class="post-small-tags small text-uppercase text-primary mb-1">
                                                <?php echo esc_html($r_cat_name); ?> <span class="text-muted">| <?php echo esc_html($r_date); ?></span>
                                            </div>
                                            <div class="fw-bold mt-1 small text-dark"><?php echo esc_html($r_author); ?></div>
                                            <h6 class="mt-1 mb-1 post-title">
                                                <a href="<?php echo esc_url($r_link); ?>" class="text-dark text-decoration-none fw-bold"><?php echo esc_html($r_title); ?></a>
                                            </h6>
                                        </div>
                                    </div>
                            <?php
                                endwhile;
                                wp_reset_postdata();
                            else :
                                echo '<p class="text-muted small">No related articles found.</p>';
                            endif;
                            ?>
                        </div>
                    </div>

                    <!-- Categories Card -->
                    <div class="card sidebar-card border-0 shadow-sm rounded-3">
                        <div class="card-body p-4">
                            <h4 class="mb-4 text-primary fw-bold">Categories</h4>
                            <ul class="list-unstyled category-list mb-0">
                                <?php
                                $categories = get_categories();
                                if (!empty($categories)) :
                                    foreach ($categories as $cat_item) :
                                ?>
                                        <li class="mb-2">
                                            <a href="<?php echo esc_url(get_category_link($cat_item->term_id)); ?>" class="category-item d-flex justify-content-between align-items-center text-dark text-decoration-none py-1">
                                                <span class="cat-name fw-medium"><?php echo esc_html($cat_item->name); ?></span>
                                                <span class="cat-count text-muted small">(<?php echo sprintf('%02d', $cat_item->count); ?>)</span>
                                            </a>
                                        </li>
                                <?php
                                    endforeach;
                                else :
                                    echo '<li class="text-muted small">No categories created yet.</li>';
                                endif;
                                ?>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<?php
get_footer();