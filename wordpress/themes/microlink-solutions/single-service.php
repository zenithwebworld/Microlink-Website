<?php
/**
 * The template for displaying single service details matching solution page structure
 *
 * @package microlink-solutions
 */

get_header();

$post_id    = get_the_ID();
$title      = get_the_title();
$content    = apply_filters('the_content', get_the_content());

$custom_banner = get_post_meta($post_id, '_service_banner_url', true);
$banner        = !empty($custom_banner) ? $custom_banner : get_the_post_thumbnail_url($post_id, 'full');
$banner        = !empty($banner) ? $banner : get_template_directory_uri() . '/assets/images/i-banner.jpg';
?>

<!-- Inner Banner Section -->
<section class="innerbanner-section">
    <div class="video-thumb">
        <div class="thumbnail-container object-fit">
            <div class="thumbnail">
                <img src="<?php echo esc_url($banner); ?>" alt="<?php echo esc_attr($title); ?>" title="<?php echo esc_attr($title); ?>" width="1920" height="500">
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
                            <a href="<?php echo esc_url(home_url('/services')); ?>" class="text-white" title="Services">Services</a>
                            <span class="text-white mx-2">-</span>
                            <span class="text-white"><?php echo esc_html($title); ?></span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Service Details Section -->
<section class="blog-details section-gap">
    <div class="container">
        <div class="row g-lg-5 g-4">
            <!-- Main Content Area -->
            <div class="col-lg-8">
                <h2 class="mb-3 text-black fw-bold">Overview</h2>
                <div class="cms">
                    <?php echo $content; ?>
                </div>
            </div>

            <!-- Sidebar Area -->
            <div class="col-lg-4">
                <div class="card sidebar-card mb-4 border-0 shadow-sm rounded-3 position-sticky top-25">
                    <div class="card-body p-4">
                        <h4 class="mb-4 text-primary fw-bold">Related Services</h4>

                        <?php
                        $related = new WP_Query([
                            'post_type'      => 'service',
                            'posts_per_page' => 6,
                            'post__not_in'   => [$post_id],
                            'orderby'        => 'menu_order title',
                            'order'          => 'ASC'
                        ]);

                        if ($related->have_posts()) :
                            while ($related->have_posts()) : $related->the_post();
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
                            echo '<p class="text-muted small">No related services found.</p>';
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

<!-- Partners & OEM Section -->
<?php
$partners_query = new WP_Query([
    'post_type'      => 'partner',
    'posts_per_page' => -1
]);

if ($partners_query->have_posts()) :
?>
    <section class="section-gap double-gap partner-section">
        <div class="container-fluid">
            <div class="row justify-content-center">
                <div class="col-xl-6 mb-5 text-center" data-aos="fade-up" data-aos-delay="80">
                    <h2 class="cm-title fs-40 mb-3 text-white"> Meet our esteemed <span>Partners & OEM</span></h2>
                    <p class="text-white opacity-75">Our partners and OEMs are the backbone of our trust and success. Meet our Partners & OEMs for your Secure Digital Transformation journey.</p>
                </div>
                <div class="col-12">
                    <div class="partner-marquee-slider overflow-hidden d-flex" data-aos="fade-left" data-aos-delay="120">
                        <div class="display-1 text-white text-uppercase text-nowrap d-flex align-items-center">
                            <?php
                            while ($partners_query->have_posts()) : $partners_query->the_post();
                                $logo = get_the_post_thumbnail_url(get_the_ID(), 'full');
                                if (empty($logo)) {
                                    continue;
                                }
                            ?>
                                <span class="mx-3">
                                    <img src="<?php echo esc_url($logo); ?>" alt="<?php echo esc_attr(get_the_title()); ?>" title="<?php echo esc_attr(get_the_title()); ?>" width="180" height="70" style="object-fit:contain; max-height:70px;">
                                </span>
                            <?php
                            endwhile;
                            wp_reset_postdata();
                            ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
<?php endif; ?>

<!-- Customer Success Stories Section -->
<section class="case-study-section section-gap common-owl">
    <div class="container">
        <div class="row align-items-end mb-4">
            <div class="col-lg-10">
                <h2 class="cm-title text-black fs-40 mb-2">Transforming Vision into Results <span> Customer Success Stories</span></h2>
                <p class="text-muted">See how we turn complex business challenges into measurable results through strategic technology implementation. Explore some of our proven success stories that showcase innovation, efficiency, and business growth in action.</p>
            </div>
            <div class="col-lg-2 text-lg-end mt-3 mt-lg-0">
                <a href="<?php echo esc_url(home_url('/stories')); ?>" class="btn btn-outline-primary">View All Stories</a>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <div class="owl-carousel portfolio-slider">
                    <?php
                    $stories = new WP_Query([
                        'post_type'      => 'story',
                        'posts_per_page' => 6
                    ]);

                    if ($stories->have_posts()) :
                        while ($stories->have_posts()) : $stories->the_post();
                            $story_title = get_the_title();
                            $featured_image = get_the_post_thumbnail_url(get_the_ID(), 'full') ?: get_template_directory_uri() . '/assets/images/blog-large.webp';
                            $badge1 = get_post_meta(get_the_ID(), 'badge_1', true) ?: 'Innovation';
                            $badge2 = get_post_meta(get_the_ID(), 'badge_2', true) ?: 'Results';
                            $desc   = wp_trim_words(get_the_excerpt(), 15);
                            $story_link = get_permalink();
                    ?>

                    <div class="portfolio-card">
                        <div class="thumbnail-container object-fit rounded-3">
                            <div class="thumbnail">
                                <a href="<?php echo esc_url($story_link); ?>">
                                    <img src="<?php echo esc_url($featured_image); ?>" alt="<?php echo esc_attr($story_title); ?>" width="891" height="594">
                                </a>
                            </div>
                            <div class="overlay">
                                <span class="badge bg-light text-dark"><?php echo esc_html($badge1); ?></span>
                                <span class="badge bg-light text-dark"><?php echo esc_html($badge2); ?></span>
                                <h4 class="my-3 text-white">
                                    <a href="<?php echo esc_url($story_link); ?>" class="text-white text-decoration-none"><?php echo esc_html($story_title); ?></a>
                                </h4>
                                <p class="text-white opacity-75"><?php echo esc_html($desc); ?></p>
                            </div>
                        </div>
                    </div>

                    <?php
                        endwhile;
                        wp_reset_postdata();
                    else :
                        echo '<div class="col-12 text-center text-muted"><p>No success stories published yet.</p></div>';
                    endif;
                    ?>

                </div>
            </div>
        </div>
    </div>
</section>

<?php get_footer(); ?>