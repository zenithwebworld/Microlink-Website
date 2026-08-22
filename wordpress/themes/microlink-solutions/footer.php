<footer id="colophon" class="site-footer footer-section bg-light">
    <div class="container">
        <div class="row">
            <div class="col-lg-4">
                <div class="footer-card">
                    <div class="mb-2 mb-lg-5">
                        <a href="<?php echo home_url(); ?>">
                            <img 
                                src="<?php echo site_url('wp-content/uploads/2026/03/new-logo.png'); ?>"
                                alt="<?php bloginfo('name'); ?>" 
                                style="height: 70px; width: auto;"
                                width="87" height="25"
                            >
                        </a>
                    </div>
                    <div class="footer-contact row mb-sm-3">
                        <div class="d-flex mb-3 col-md-6 col-lg-12">
                            <span class="icon-circle me-3">
                                <i class="n-icon" data-icon="s-user" data-iconwidth="22px" data-iconheight="22px"></i>
                            </span>
                            <div>
                                <div class="p-tag">
                                    <a href="mailto:info@microlink.co.in">info@microlink.co.in</a>
                                </div>
                                <div class="p-tag">
                                    <a href="tel:+919824408739">+91 98244 08739</a>
                                </div>
                            </div>
                        </div>
                        <div class="d-flex mb-3 col-md-6 col-lg-12">
                            <span class="icon-circle me-3">
                                <i class="n-icon" data-icon="s-location" data-iconwidth="22px" data-iconheight="22px"></i>
                            </span>
                            <p>4th Floor, Sarthik Complex, Near Iscon Circle, Satellite, Ahmedabad, Gujarat 380015</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-8">
                <div class="row">
                    <div class="col-sm-6 col-md-4">
                        <h6 class="fw-bold title">Company</h6>
                        <ul class="list-unstyled">
                            <?php wp_nav_menu([
                                'theme_location' => 'footer_company',
                                'container' => false,
                                'items_wrap' => '%3$s',
                                'walker' => new Footer_Menu_Walker()
                            ]); ?>
                        </ul>
                    </div>
                    <div class="col-sm-6 col-md-4">
                        <h6 class="fw-bold title">Quick Links</h6>
                        <ul class="list-unstyled">
                            <?php wp_nav_menu([
                                'theme_location' => 'footer_quick',
                                'container' => false,
                                'items_wrap' => '%3$s',
                                'walker' => new Footer_Menu_Walker()
                            ]); ?>
                        </ul>
                    </div>
                    <div class="col-sm-6 col-md-4">
                        <h6 class="fw-bold title">Our Services</h6>
                        <ul class="list-unstyled">
                            <?php wp_nav_menu([
                                'theme_location' => 'footer_services',
                                'container' => false,
                                'items_wrap' => '%3$s',
                                'walker' => new Footer_Menu_Walker()
                            ]); ?>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <div class="footer-bottom d-flex justify-content-between align-items-center mt-4">
            <span>© <?php echo date("Y"); ?> <?php bloginfo('name'); ?>. All rights reserved</span>

            <div class="social-icons">
                <a href="#" class="me-2 icon-circle">
                    <i class="n-icon" data-icon="s-facebook" data-iconwidth="22px" data-iconheight="22px"></i>
                </a>
                <a href="#" class="me-2 icon-circle">
                    <i class="n-icon" data-icon="s-twitter" data-iconwidth="22px" data-iconheight="22px"></i>
                </a>
                <a href="#" class="icon-circle">
                    <i class="n-icon" data-icon="s-linkedIn" data-iconwidth="22px" data-iconheight="22px"></i>
                </a>
            </div>
        </div>
    </div>
</footer>

</div>

<?php wp_footer(); ?>
</body>
</html>