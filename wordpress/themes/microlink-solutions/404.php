<?php get_header(); ?>

<section class="error-404-section section-gap double-gap">
    <div class="container">
        <div class="row">
            <div class="col-lg-8 mx-auto text-center">
                <div class="error-404-content">
                    <div class="error-404-icon-wrapper mb-4">
                        <div class="error-404-icon">404</div>
                        <div class="error-404-animation"></div>
                    </div>

                    <h1 class="error-404-title">Page Not Found</h1>
                    
                    <p class="error-404-subtitle">Oops! The page you're looking for doesn't exist</p>

                    <p class="error-404-message">
                        We're sorry, but we couldn't find the page you were looking for. It might have been moved or deleted. Please check the URL or use the navigation below to find what you're looking for.
                    </p>

                    <div class="error-404-actions">
                        <a href="<?php echo site_url(); ?>" class="btn btn-primary me-2 me-md-3" title="Go to Home">Go to Home</a>
                        <a href="<?php echo site_url('contact'); ?>" class="btn btn-outline-primary" title="Contact Us">Contact Us</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
	
<?php get_footer();