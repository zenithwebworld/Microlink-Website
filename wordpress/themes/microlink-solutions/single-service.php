<?php get_header(); ?>

<?php
// Dynamic data
$title = get_the_title();
$content = apply_filters('the_content', get_the_content());
?>

<section class="inner-banner-01 position-relative bg-light">
    <div class="container py-lg-7 py-4">
        <div class="row align-items-center">
            <div class="col">
                <h1 class="display-2"><?php echo esc_html($title); ?></h1>
            </div>
            <div class="col-auto text-end">
                <div class="d-flex align-items-center justify-content-end">
                    <ul class="custom-breadcrumb-1">
                        <li><a href="<?php echo esc_url(home_url('/')); ?>">Home</a></li>
                        <li><a href="<?php echo esc_url(home_url('/services')); ?>">Service</a></li>
                        <li class="active">
                            <a href="#"><?php echo esc_html($title); ?></a>
                        </li>
                    </ul>
                    <button type="button" class="border-0 bg-light ms-3" data-bs-toggle="modal" data-bs-target="#ShareBackdrop">
                        <i class="n-icon" data-icon="s-share" data-iconwidth="19px" data-iconheight="19px"></i>
                    </button>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="blog-details section-gap">
    <div class="container">
        <div class="row g-lg-5 g-4">
            <div class="col-8">
                <h2 class="mb-3"><?php echo esc_html($title); ?></h2>
                <div class="cms">
                    <?php echo $content; ?>
                </div>
            </div>
            <div class="col-4">
                <div class="card sidebar-card mb-4 position-sticky top-25">
                    <div class="card-body p-4">
                        <h4 class="mb-4 text-primary">Related Services</h4>

                        <?php
                        $related = new WP_Query([
                            'post_type' => 'service',
                            'post__not_in' => [get_the_ID()]
                        ]);

                        if ($related->have_posts()) :
                            while ($related->have_posts()) : $related->the_post();

                                $r_title = get_the_title();
                                $r_link = get_permalink();
                                $r_icon = get_post_meta(get_the_ID(), '_service_icon', true);
                                $r_desc = get_post_meta(get_the_ID(), '_service_short_desc', true);
                        ?>

                        <a href="<?php echo esc_url($r_link); ?>" class="service-item d-flex align-items-center">
                            <div class="icon-box">
                                <span class="material-icons">
                                    <i class="n-icon"
                                       data-icon="<?php echo esc_attr($r_icon); ?>"
                                       data-iconwidth="35px"
                                       data-iconheight="35px"></i>
                                </span>
                            </div>
                            <div class="ms-3">
                                <h6 class="mb-0"><?php echo esc_html($r_title); ?></h6>
                                <small class="text-muted"><?php echo esc_html($r_desc); ?></small>
                            </div>
                        </a>

                        <?php
                            endwhile;
                            wp_reset_postdata();
                        endif;
                        ?>

                    </div>
                </div>
            </div>

        </div>
    </div>
</section>

<?php get_footer(); ?>