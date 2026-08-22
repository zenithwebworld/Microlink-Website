<?php
/**
 * Template Name: Privacy Policy
 *
 * @package microlink-solutions
 */

get_header();

$phone        = get_theme_mod('footer_phone', '+91 98244 08739');
$email        = get_theme_mod('footer_email', 'info@microlink.co.in');
$address      = get_theme_mod('footer_address', '4th Floor, Sarthik Complex, Near Iscon Circle, Satellite, Ahmedabad, Gujarat 380015');
$office_hours = get_theme_mod('footer_office_hours', 'Monday to Friday: 9:00 am to 6:00 pm');
?>

<!-- Banner Section -->
<section class="inner-banner-01 position-relative bg-light">
    <div class="container py-4">
        <div class="row align-items-center">
            <div class="col-lg-7 col-md-6">
                <h1 class="display-5 fw-bold text-black mb-0">
                    <?php echo get_the_title(); ?>
                </h1>
            </div>
            <div class="col-lg-5 col-md-6 text-md-end mt-3 mt-md-0">
                <div class="d-flex align-items-center justify-content-md-end">
                    <ul class="custom-breadcrumb-1 list-unstyled d-flex align-items-center gap-2 mb-0">
                        <li><a href="<?php echo esc_url(home_url('/')); ?>" title="Home" class="text-dark text-decoration-none">Home</a></li>
                        <li class="text-muted">/</li>
                        <li class="active text-primary fw-bold"><?php echo get_the_title(); ?></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Main Content & Dynamic Contact Sidebar -->
<section class="section-gap" data-aos="fade-up">
    <div class="container">
        <div class="row justify-content-center g-lg-5 g-4">
            <div class="col-lg-8">
                <div class="cms pe-lg-3">
                    <?php
                    while (have_posts()) : the_post();
                        the_content();
                    endwhile;
                    ?>
                </div>
            </div>
            <div class="col-lg-4 ps-lg-4 border-start mt-lg-0">
                <div class="position-sticky sticky-top top-25">
                    <h3 class="fw-bold text-black mb-3">Get in Touch</h3>

                    <?php if (!empty($phone)) : ?>
                        <div class="p-tag fw-bold mt-3 text-black">You can call us on:</div>
                        <div class="p-tag n-mt-1 text-body primary-link">
                            <a href="tel:<?php echo esc_attr($phone); ?>" title="Call Us" class="text-decoration-none text-primary fw-medium"><?php echo esc_html($phone); ?></a>
                        </div>
                    <?php endif; ?>

                    <?php if (!empty($email)) : ?>
                        <div class="p-tag fw-bold mt-3 text-black">Email us at:</div>
                        <div class="p-tag n-mt-1 text-body primary-link">
                            <a href="mailto:<?php echo esc_attr($email); ?>" title="Email Us" class="text-decoration-none text-primary fw-medium"><?php echo esc_html($email); ?></a>
                        </div>
                    <?php endif; ?>

                    <?php if (!empty($address)) : ?>
                        <div class="p-tag fw-bold mt-3 text-black">Mailing Address:</div>
                        <div class="p-tag n-mt-1 text-body text-secondary"><?php echo esc_html($address); ?></div>
                    <?php endif; ?>

                    <?php if (!empty($office_hours)) : ?>
                        <div class="p-tag fw-bold mt-3 text-black">We are open:</div>
                        <div class="p-tag n-mt-1 text-body text-secondary"><?php echo esc_html($office_hours); ?></div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</section>

<?php get_footer(); ?>