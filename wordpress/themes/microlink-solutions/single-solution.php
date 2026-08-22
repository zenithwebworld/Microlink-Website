<?php get_header();

$title = get_the_title();
$content = apply_filters('the_content', get_the_content());
$banner = get_the_post_thumbnail_url(get_the_ID(), 'full'); ?>

<section class="innerbanner-section">
    <div class="video-thumb">
        <div class="thumbnail-container object-fit">
            <div class="thumbnail">
                <img src="<?php echo esc_url(site_url('wp-content/uploads/2026/03/i-banner.jpg')); ?>" alt="Banner" width="1920" height="500">
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
                            <span class="text-white"><?php echo esc_html($title); ?></span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="blog-details section-gap">
    <div class="container">
        <div class="row g-lg-5 g-4">
            <div class="col-lg-8">
                <h2 class="mb-3">Overview</h2>
                <div class="cms">
                    <?php echo $content; ?>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="card sidebar-card mb-4 position-sticky top-25">
                    <div class="card-body p-4">
                        <h4 class="mb-4 text-primary">Related Solutions</h4>

                        <?php
                        $related = new WP_Query([
                            'post_type' => 'solution',
                            'post__not_in' => [get_the_ID()],
                            'meta_query' => [
                                [
                                    'key' => 'is_primary_page',
                                    'value' => '1',
                                    'compare' => '='
                                ]
                            ]
                        ]);

                        if ($related->have_posts()) :
                            while ($related->have_posts()) : $related->the_post();

                                $r_title = get_the_title();
                                $r_link = get_permalink();
                                $r_icon = get_post_meta(get_the_ID(), '_solution_icon', true);
                        ?>

                        <a href="<?php echo esc_url($r_link); ?>" class="service-item d-flex align-items-center">
                            <div class="icon-box mb-0">
                                <span class="material-icons">
                                    <i class="n-icon"
                                       data-icon="<?php echo esc_attr($r_icon); ?>"
                                       data-iconwidth="35px"
                                       data-iconheight="35px"></i>
                                </span>
                            </div>
                            <div class="ms-3">
                                <h6 class="mb-0"><?php echo esc_html($r_title); ?></h6>
                            </div>
                        </a>

                        <?php
                            endwhile;
                            wp_reset_postdata();
                        endif;
                        ?>

                        <a href="<?php echo esc_url(home_url('/contact')); ?>" class="btn btn-primary mt-4">
                            Talk to Our Experts
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<?php $partners = new WP_Query([
    'post_type' => 'partner',
    'posts_per_page' => -1,
    'meta_query' => [
        [
            'key' => 'link_solution_page',
            'value' => get_the_ID(),
            'compare' => '='
        ]
    ]
]);

if ($partners->have_posts()) { ?>
    <section class="section-gap double-gap partner-section">
        <img class="lazy banner-bg-1" src="<?php echo site_url('wp-content/uploads/2026/03/banner-bg-1.png'); ?>" alt="" title="" width="87" height="25">
        <img class="lazy banner-bg-2" src="<?php echo site_url('wp-content/uploads/2026/03/banner-bg-2.png'); ?>" alt="" title="" width="87" height="25">
        <div class="container-fluid">
            <div class="row justify-content-center">
                <div class="col-xl-5 mb-5 text-center" data-aos="fade-up" data-aos-delay="80">
                    <h2 class="cm-title fs-40 mb-3"> Meet our esteemed <span>Partners & OEM</span></h2>
                    <p class="text-white">Our partners and OEM are the backbone of our trust and success. Meet our Partners & OEMs for your Secure Digital Transformation journey</p>
                </div>
                <div class="col-12">
                    <div class="partner-marquee-slider overflow-hidden d-flex" data-aos="fade-left"
                        data-aos-delay="120">
                        <div class="display-1 text-white text-uppercase text-nowrap d-flex align-items-center">
                            <?php
                            $partners = new WP_Query([
                                'post_type' => 'partner',
                                'posts_per_page' => -1,
                                'meta_query' => [
                                    [
                                        'key' => 'link_solution_page',
                                        'value' => get_the_ID(),
                                        'compare' => '='
                                    ]
                                ]
                            ]);

                            while ($partners->have_posts()) : $partners->the_post();
                                $logo = get_the_post_thumbnail_url(get_the_ID(), 'full');    
                            ?>

                            <span>
                                <img src="<?php echo esc_url($logo); ?>" alt="<?php the_title(); ?>" title="<?php the_title(); ?>" width="891" height="594">
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
<?php } ?>

<section class="case-study-section section-gap common-owl">
    <div class="container">
        <div class="row align-items-end mb-4">
            <div class="col-lg-10">
                <h2 class="cm-title text-black fs-40 mb-2">Transforming Vision into Results <span> Customer Success Stories</span></h2>
                <p>See how we turn complex business challenges into measurable results through strategic technology implementation. Explore some of our proven success stories that showcase innovation, efficiency, and business growth in action.</p>
            </div>
            <div class="col-lg-2 text-lg-end mt-3 mt-lg-0">
                <!-- <a href="#" class="btn btn-primary">View all </a> -->
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <div class="owl-carousel portfolio-slider">
                    <?php
                    $stories = new WP_Query([
                        'post_type' => 'story',
                        'posts_per_page' => 6
                    ]);

                    if ($stories->have_posts()) :
                        while ($stories->have_posts()) : $stories->the_post();
                            $title = get_the_title();
                            $featured_image = get_the_post_thumbnail_url(get_the_ID(), 'full');
                            $badge1 = get_post_meta(get_the_ID(), 'badge_1', true);
                            $badge2 = get_post_meta(get_the_ID(), 'badge_2', true);
                            $desc = get_the_excerpt();
                    ?>

                    <div class="portfolio-card">
                        <div class="thumbnail-container object-fit rounded-3">
                            <div class="thumbnail">
                                <img src="<?php echo $featured_image; ?>" alt="<?php echo $title; ?>" width="891" height="594">
                            </div>
                            <div class="overlay">
                                <span class="badge bg-light text-dark"><?php echo esc_html($badge1); ?></span>
                                <span class="badge bg-light text-dark"><?php echo esc_html($badge2); ?></span>
                                <h4 class="my-3 text-white"><?php the_title(); ?></h4>
                                <p><?php echo esc_html($desc); ?></p>
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
        </div>
    </div>
</section>

<?php get_footer(); ?>