<?php
/**
 * The template for displaying the footer
 *
 * @package microlink-solutions
 */

$footer_email    = get_theme_mod('footer_email', 'info@microlink.co.in');
$footer_phone    = get_theme_mod('footer_phone', '+91 98244 08739');
$footer_address  = get_theme_mod('footer_address', '4th Floor, Sarthik Complex, Near Iscon Circle, Satellite, Ahmedabad, Gujarat 380015');

$footer_facebook = get_theme_mod('footer_facebook', '#');
$footer_twitter  = get_theme_mod('footer_twitter', '#');
$footer_linkedin = get_theme_mod('footer_linkedin', '#');

$company_title   = get_theme_mod('footer_company_title', 'Company');
$quick_title     = get_theme_mod('footer_quick_title', 'Quick Links');
$services_title  = get_theme_mod('footer_services_title', 'Our Services');
?>
<footer id="colophon" class="site-footer footer-section bg-light">
    <div class="container">
        <div class="row">
            <div class="col-lg-4">
                <div class="footer-card">
                    <div class="footer-logo-wrap mb-3 mb-lg-4">
                        <?php 
                        if (has_custom_logo()) {
                            the_custom_logo();
                        } else {
                            echo '<a href="' . esc_url(home_url('/')) . '"><img src="' . esc_url(site_url('wp-content/uploads/2026/03/new-logo.png')) . '" alt="' . esc_attr(get_bloginfo('name')) . '" class="footer-logo-img"></a>';
                        }
                        ?>
                    </div>
                    <div class="footer-contact row mb-sm-3">
                        <?php if (!empty($footer_email) || !empty($footer_phone)) : ?>
                            <div class="d-flex mb-3 col-md-6 col-lg-12">
                                <span class="icon-circle me-3">
                                    <i class="n-icon" data-icon="s-user" data-iconwidth="22px" data-iconheight="22px"></i>
                                </span>
                                <div>
                                    <?php if (!empty($footer_email)) : ?>
                                        <div class="p-tag">
                                            <a href="mailto:<?php echo esc_attr($footer_email); ?>"><?php echo esc_html($footer_email); ?></a>
                                        </div>
                                    <?php endif; ?>
                                    <?php if (!empty($footer_phone)) : ?>
                                        <div class="p-tag">
                                            <a href="tel:<?php echo esc_attr($footer_phone); ?>"><?php echo esc_html($footer_phone); ?></a>
                                        </div>
                                    <?php endif; ?>
                                </div>
                            </div>
                        <?php endif; ?>

                        <?php if (!empty($footer_address)) : ?>
                            <div class="d-flex mb-3 col-md-6 col-lg-12">
                                <span class="icon-circle me-3">
                                    <i class="n-icon" data-icon="s-location" data-iconwidth="22px" data-iconheight="22px"></i>
                                </span>
                                <p><?php echo esc_html($footer_address); ?></p>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
            <div class="col-lg-8">
                <div class="row">
                    <div class="col-sm-6 col-md-4">
                        <h6 class="fw-bold title"><?php echo esc_html($company_title); ?></h6>
                        <ul class="list-unstyled">
                            <?php wp_nav_menu([
                                'theme_location' => 'footer_company',
                                'container'      => false,
                                'items_wrap'     => '%3$s',
                                'walker'         => new Footer_Menu_Walker()
                            ]); ?>
                        </ul>
                    </div>
                    <div class="col-sm-6 col-md-4">
                        <h6 class="fw-bold title"><?php echo esc_html($quick_title); ?></h6>
                        <ul class="list-unstyled">
                            <?php wp_nav_menu([
                                'theme_location' => 'footer_quick',
                                'container'      => false,
                                'items_wrap'     => '%3$s',
                                'walker'         => new Footer_Menu_Walker()
                            ]); ?>
                        </ul>
                    </div>
                    <div class="col-sm-6 col-md-4">
                        <h6 class="fw-bold title"><?php echo esc_html($services_title); ?></h6>
                        <ul class="list-unstyled">
                            <?php wp_nav_menu([
                                'theme_location' => 'footer_services',
                                'container'      => false,
                                'items_wrap'     => '%3$s',
                                'walker'         => new Footer_Menu_Walker()
                            ]); ?>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <div class="footer-bottom d-flex justify-content-between align-items-center mt-4">
            <span>© <?php echo date("Y"); ?> <?php bloginfo('name'); ?>. All rights reserved</span>

            <div class="social-icons">
                <?php if (!empty($footer_facebook)) : ?>
                    <a href="<?php echo esc_url($footer_facebook); ?>" class="me-2 icon-circle" target="_blank" rel="noopener">
                        <i class="n-icon" data-icon="s-facebook" data-iconwidth="22px" data-iconheight="22px"></i>
                    </a>
                <?php endif; ?>
                <?php if (!empty($footer_twitter)) : ?>
                    <a href="<?php echo esc_url($footer_twitter); ?>" class="me-2 icon-circle" target="_blank" rel="noopener">
                        <i class="n-icon" data-icon="s-twitter" data-iconwidth="22px" data-iconheight="22px"></i>
                    </a>
                <?php endif; ?>
                <?php if (!empty($footer_linkedin)) : ?>
                    <a href="<?php echo esc_url($footer_linkedin); ?>" class="icon-circle" target="_blank" rel="noopener">
                        <i class="n-icon" data-icon="s-linkedIn" data-iconwidth="22px" data-iconheight="22px"></i>
                    </a>
                <?php endif; ?>
            </div>
        </div>
    </div>
</footer>

</div>

<?php wp_footer(); ?>
</body>
</html>