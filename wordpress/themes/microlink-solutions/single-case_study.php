<?php
/**
 * The template for displaying single Case Study details
 *
 * @package microlink-solutions
 */

get_header();

$post_id     = get_the_ID();
$title       = get_the_title();
$content     = apply_filters('the_content', get_the_content());

$custom_img  = get_post_meta($post_id, 'custom_image_url', true);
$feat_img    = !empty($custom_img) ? $custom_img : get_the_post_thumbnail_url($post_id, 'full');
$feat_img    = !empty($feat_img) ? $feat_img : get_template_directory_uri() . '/assets/images/blog-large.webp';

$badge1      = get_post_meta($post_id, 'badge_1', true) ?: 'Case Study';
$badge2      = get_post_meta($post_id, 'badge_2', true) ?: 'Results';
$client_name = get_post_meta($post_id, 'client_name', true) ?: '';
$pdf_url     = get_post_meta($post_id, 'pdf_url', true);
?>

<!-- Inner Banner Section -->
<section class="innerbanner-section">
    <div class="video-thumb">
        <div class="thumbnail-container object-fit">
            <div class="thumbnail">
                <img src="<?php echo esc_url($feat_img); ?>" alt="<?php echo esc_attr($title); ?>" title="<?php echo esc_attr($title); ?>" width="1920" height="500">
            </div>
        </div>
        <div class="caption">
            <div class="container">
                <div class="row">
                    <div class="col-lg-8">
                        <h1 class="cm-title text-white">
                            <?php echo esc_html($title); ?>
                        </h1>
                        <div class="breadcrumb-nav mt-3">
                            <a href="<?php echo esc_url(home_url('/')); ?>" class="text-white" title="Home">Home</a>
                            <span class="text-white mx-2">-</span>
                            <a href="<?php echo esc_url(get_post_type_archive_link('case_study') ?: home_url('/case-studies')); ?>" class="text-white" title="Case Studies">Case Studies</a>
                            <span class="text-white mx-2">-</span>
                            <span class="text-white"><?php echo esc_html(wp_trim_words($title, 5)); ?></span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Case Study Details Section -->
<section class="blog-details section-gap">
    <div class="container">
        <div class="row g-lg-5 g-4">
            <!-- Main Content Area -->
            <div class="col-lg-8">
                <div class="mb-3">
                    <span class="badge bg-primary text-white me-2 px-3 py-2 fs-6"><?php echo esc_html($badge1); ?></span>
                    <span class="badge bg-secondary text-white px-3 py-2 fs-6"><?php echo esc_html($badge2); ?></span>
                </div>

                <?php if (!empty($client_name)) : ?>
                    <h5 class="text-muted text-uppercase fw-bold mb-2">Client: <?php echo esc_html($client_name); ?></h5>
                <?php endif; ?>

                <h2 class="mb-4 text-black fw-bold"><?php echo esc_html($title); ?></h2>

                <div class="cms">
                    <?php
                    while (have_posts()) : the_post();
                        the_content();
                    endwhile;
                    ?>
                </div>

                <?php if (!empty($pdf_url)) : ?>
                    <div class="mt-4 pt-3 border-top">
                        <a href="<?php echo esc_url($pdf_url); ?>" target="_blank" class="btn btn-primary btn-lg rounded-pill px-4">
                            📄 Download Full Case Study (PDF)
                        </a>
                    </div>
                <?php endif; ?>
            </div>

            <!-- Sidebar Area -->
            <div class="col-lg-4">
                <div class="card sidebar-card mb-4 border-0 shadow-sm rounded-3 position-sticky top-25">
                    <div class="card-body p-4">
                        <h4 class="mb-4 text-primary fw-bold">Recent Case Studies</h4>

                        <?php
                        $recent = new WP_Query([
                            'post_type'      => 'case_study',
                            'posts_per_page' => 4,
                            'post__not_in'   => [$post_id]
                        ]);

                        if ($recent->have_posts()) :
                            while ($recent->have_posts()) : $recent->the_post();
                                $r_title = get_the_title();
                                $r_link  = get_permalink();
                        ?>

                            <a href="<?php echo esc_url($r_link); ?>" class="d-flex align-items-center py-2 text-decoration-none text-dark border-bottom border-light">
                                <i class="n-icon text-primary me-2 flex-shrink-0" data-icon="s-right-dubble" data-iconwidth="12px" data-iconheight="12px"></i>
                                <span class="fw-medium text-dark"><?php echo esc_html($r_title); ?></span>
                            </a>

                        <?php
                            endwhile;
                            wp_reset_postdata();
                        else :
                            echo '<p class="text-muted small">No other case studies found.</p>';
                        endif;
                        ?>

                        <a href="<?php echo esc_url(home_url('/contact')); ?>" class="btn btn-primary w-100 mt-4" title="Talk to Our Experts">
                            Talk to Our Experts
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<?php get_footer(); ?>
