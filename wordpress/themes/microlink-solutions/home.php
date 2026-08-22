<?php
/**
 * The template for displaying the blog posts index page
 *
 * @package microlink-solutions
 */

get_header();

$page_for_posts_id = get_option('page_for_posts');
$banner_img = get_template_directory_uri() . '/assets/images/i-banner.jpg';
if ($page_for_posts_id && has_post_thumbnail($page_for_posts_id)) {
    $banner_img = get_the_post_thumbnail_url($page_for_posts_id, 'full');
}
$page_title = $page_for_posts_id ? get_the_title($page_for_posts_id) : 'Blog';
?>

<!-- Inner Banner Section -->
<section class="innerbanner-section">
    <div class="video-thumb">
        <div class="thumbnail-container object-fit">
            <div class="thumbnail">
                <img src="<?php echo esc_url($banner_img); ?>" alt="<?php echo esc_attr($page_title); ?>" title="<?php echo esc_attr($page_title); ?>" width="1920" height="500">
            </div>
        </div>
        <div class="caption">
            <div class="container">
                <div class="row">
                    <div class="col-lg-8">
                        <h1 class="cm-title text-white"><?php echo esc_html($page_title); ?></h1>
                        <div class="breadcrumb-nav mt-3">
                            <a href="<?php echo esc_url(home_url('/')); ?>" class="text-white" title="Home">
                                Home
                            </a>
                            <span class="text-white mx-2">-</span>
                            <span class="text-white"><?php echo esc_html($page_title); ?></span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Blog Listing Section -->
<section class="blog-section section-gap double-gap">
    <div class="container">
        <div class="row g-4">
            <?php
            if (have_posts()) :
                $delay = 80;
                while (have_posts()) : the_post();
                    $img = get_the_post_thumbnail_url(get_the_ID(), 'full');
                    $img = $img ?: get_template_directory_uri() . '/assets/images/blog-large.webp';
                    $title = get_the_title();
                    $desc  = wp_trim_words(get_the_excerpt(), 20);
                    $link  = get_permalink();
                    $date  = get_the_date('M d, Y');
                    $author = get_the_author();
                    $cat   = get_the_category();
                    $cat_name = !empty($cat) ? $cat[0]->name : 'General';
            ?>
                    <div class="col-lg-4 col-md-6">
                        <div class="blog-main-card bg-white c-card h-100 d-flex flex-column" data-aos="fade-up" data-aos-delay="<?php echo esc_attr($delay); ?>">
                            <div class="thumbnail-container object-fit rounded-3">
                                <div class="thumbnail">
                                    <a href="<?php echo esc_url($link); ?>">
                                        <img src="<?php echo esc_url($img); ?>" alt="<?php echo esc_attr($title); ?>" width="891" height="594">
                                    </a>
                                </div>
                            </div>
                            <div class="content pt-4 d-flex flex-column flex-grow-1">
                                <div class="post-small-tags small text-uppercase text-primary mb-1">
                                    <?php echo esc_html($cat_name); ?> <span class="text-muted">| <?php echo esc_html($date); ?></span>
                                </div>
                                <div class="fw-bold mt-2 text-dark"><?php echo esc_html($author); ?></div>
                                <h2 class="h5 mt-2 mb-3">
                                    <a href="<?php echo esc_url($link); ?>" class="text-dark text-decoration-none"><?php echo esc_html($title); ?></a>
                                </h2>
                                <p class="text-muted"><?php echo esc_html($desc); ?></p>
                                <div class="mt-auto pt-3">
                                    <a href="<?php echo esc_url($link); ?>" class="btn btn-link button-up p-0 text-decoration-none fw-bold">Read More</a>
                                </div>
                            </div>
                        </div>
                    </div>
            <?php
                    $delay += 40;
                endwhile;
            else :
            ?>
                <div class="col-12 text-center text-muted py-5">
                    <h3>No Blog Posts Found</h3>
                    <p>Check back soon for new articles and insights!</p>
                </div>
            <?php endif; ?>
        </div>

        <!-- Pagination -->
        <div class="row mt-5">
            <div class="col-12 d-flex justify-content-center">
                <?php
                $pagination = paginate_links([
                    'type'      => 'array',
                    'prev_text' => 'Previous',
                    'next_text' => 'Next',
                ]);

                if ($pagination) :
                    echo '<nav aria-label="Page navigation"><ul class="pagination mb-0">';
                    foreach ($pagination as $page) {
                        $active   = strpos($page, 'current') !== false ? ' active' : '';
                        $disabled = strpos($page, 'disabled') !== false ? ' disabled' : '';
                        $page_link = str_replace('page-numbers', 'page-link', $page);
                        echo '<li class="page-item' . $active . $disabled . '">' . $page_link . '</li>';
                    }
                    echo '</ul></nav>';
                endif;
                ?>
            </div>
        </div>
    </div>
</section>

<?php
get_footer();
