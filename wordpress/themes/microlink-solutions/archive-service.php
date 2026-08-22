<?php get_header(); ?>

<section class="innerbanner-section">
    <div class="video-thumb">
        <div class="thumbnail-container object-fit">
            <div class="thumbnail">
                <img src="<?php echo esc_url(site_url('wp-content/uploads/2026/03/i-banner.jpg')); ?>" alt="Contact Banner" title="Contact Banner" width="1920" height="500">
            </div>
        </div>
        <div class="caption">
            <div class="container">
                <div class="row">
                    <div class="col-lg-8">
                        <h1 class="cm-title text-white">Our Services</h1>
                        <div class="breadcrumb-nav mt-3">
                            <a href="<?php echo esc_url(home_url('/')); ?>" class="text-white" title="Home">
                                Home
                            </a>
                            <span class="text-white mx-2">-</span>
                            <span class="text-white">Our Services</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="service-cards-section section-gap double-gap">
    <div class="container">
        <div class="row g-4">

            <?php
            $paged = (get_query_var('paged')) ? get_query_var('paged') : 1;

            $services = new WP_Query([
                'post_type' => 'service',
                'posts_per_page' => 6,
                'paged' => $paged,
                'orderby' => 'menu_order',
                'order' => 'ASC'
            ]);

            if ($services->have_posts()) :
                $delay = 100;

                while ($services->have_posts()) : $services->the_post();

                    $title = get_the_title();
                    $desc = get_post_meta(get_the_ID(), '_service_short_desc', true);
                    $icon = get_post_meta(get_the_ID(), '_service_icon', true);
                    $link = get_post_meta(get_the_ID(), '_service_link', true);
                    $link = $link ?: get_permalink();
                    $features_raw = get_post_meta(get_the_ID(), 'services_list', true);
            ?>

            <div class="col-lg-4 col-md-6">
                <div class="item">
                <div class="service-card c-card h-100" data-aos="fade-up" data-aos-delay="<?php echo esc_attr($delay); ?>">
                    <div class="service-icon bg-soft me-3">
                        <i class="n-icon text-primary"
                            data-icon="<?php echo esc_attr($icon); ?>"
                            data-iconwidth="35px"
                            data-iconheight="35px"></i>
                    </div>
                    <h5 class="mt-3"><?php echo esc_html($title); ?></h5>
                    <p class="text-muted"><?php echo esc_html($desc); ?></p>

                    <?php echo html_entity_decode($features_raw); ?>
                <div>
                    <a href="<?php echo esc_url($link); ?>" class="btn btn-link button-up mt-4" title="Read More">Read More</a>
                </div>
                </div>
            </div>
            </div>

            <?php
                $delay += 40;
                endwhile;
                wp_reset_postdata();
            endif;
            ?>
        </div>
        <div class="row mt-5">
            <div class="col-12 d-flex justify-content-center">
                <nav aria-label="Page navigation">
                    <ul class="pagination">
                        <?php
                        $total_pages = $services->max_num_pages;

                        if ($total_pages > 1) {

                            // PREVIOUS
                            if ($paged > 1) {
                                echo '<li class="page-item">
                                        <a class="page-link" href="' . get_pagenum_link($paged - 1) . '">Previous</a>
                                    </li>';
                            }

                            // PAGE NUMBERS
                            for ($i = 1; $i <= $total_pages; $i++) {
                                $active = ($i == $paged) ? 'active' : '';

                                echo '<li class="page-item ' . $active . '">
                                        <a class="page-link" href="' . get_pagenum_link($i) . '">' . $i . '</a>
                                    </li>';
                            }

                            // NEXT
                            if ($paged < $total_pages) {
                                echo '<li class="page-item">
                                        <a class="page-link" href="' . get_pagenum_link($paged + 1) . '">Next</a>
                                    </li>';
                            }
                        } ?>
                    </ul>
                </nav>
            </div>
        </div>
    </div>
</section>

<?php get_footer(); ?>