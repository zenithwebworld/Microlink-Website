<?php
/**
 * The template for displaying Case Studies Archive
 *
 * @package microlink-solutions
 */

get_header();

$banner_img = get_template_directory_uri() . '/assets/images/i-banner.jpg';
?>

<!-- Inner Banner Section -->
<section class="innerbanner-section">
    <div class="video-thumb">
        <div class="thumbnail-container object-fit">
            <div class="thumbnail">
                <img src="<?php echo esc_url($banner_img); ?>" alt="Case Studies" title="Case Studies" width="1920" height="500">
            </div>
        </div>
        <div class="caption">
            <div class="container">
                <div class="row">
                    <div class="col-lg-8">
                        <h1 class="cm-title text-white">Case Studies</h1>
                        <div class="breadcrumb-nav mt-3">
                            <a href="<?php echo esc_url(home_url('/')); ?>" class="text-white" title="Home">Home</a>
                            <span class="text-white mx-2">-</span>
                            <span class="text-white">Case Studies</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Case Studies Grid Section -->
<section class="case-study-section section-gap">
    <div class="container">
        <div class="row justify-content-center mb-5">
            <div class="col-lg-8 text-center">
                <h2 class="cm-title text-black fs-40 mb-3">Transforming Vision into Results <span>Customer Success Stories</span></h2>
                <p class="text-muted">Discover how Microlink empowers enterprises through strategic technology, scalable infrastructure, and secure digital transformation.</p>
            </div>
        </div>

        <div class="row g-4">
            <?php
            if (have_posts()) :
                while (have_posts()) : the_post();
                    $c_title       = get_the_title();
                    $custom_img    = get_post_meta(get_the_ID(), 'custom_image_url', true);
                    $feat_img      = !empty($custom_img) ? $custom_img : get_the_post_thumbnail_url(get_the_ID(), 'full');
                    $feat_img      = !empty($feat_img) ? $feat_img : get_template_directory_uri() . '/assets/images/blog-large.webp';
                    
                    $badge1        = get_post_meta(get_the_ID(), 'badge_1', true) ?: 'Case Study';
                    $badge2        = get_post_meta(get_the_ID(), 'badge_2', true) ?: 'Results';
                    $client_name   = get_post_meta(get_the_ID(), 'client_name', true) ?: '';
                    $pdf_url       = get_post_meta(get_the_ID(), 'pdf_url', true);
                    $link          = !empty($pdf_url) ? $pdf_url : get_permalink();
                    $desc          = wp_trim_words(get_the_excerpt(), 16);
            ?>
                <div class="col-lg-4 col-md-6">
                    <div class="portfolio-card shadow-sm rounded-3 overflow-hidden h-100 bg-white">
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
                
                the_posts_pagination([
                    'mid_size'  => 2,
                    'prev_text' => __('&laquo; Previous', _THEME_DOMAIN),
                    'next_text' => __('Next &raquo;', _THEME_DOMAIN),
                ]);
            else :
                echo '<div class="col-12 text-center text-muted"><p>No case studies published yet.</p></div>';
            endif;
            ?>
        </div>
    </div>
</section>

<?php get_footer(); ?>
