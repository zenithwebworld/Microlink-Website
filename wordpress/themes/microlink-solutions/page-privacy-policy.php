<?php

// Template Name: Privacy Policy

get_header(); ?>

<section class="inner-banner-01 position-relative bg-light">
    <div class="container bg-light py-lg-7 py-4">
        <div class="row align-items-center">
            <div class="col">
                <h1 class="display-2">
                    <?php echo the_title(); ?>
                </h1>
            </div>
            <div class="col-auto text-end">
                <div class="d-flex align-items-center justify-content-end">
                    <ul class="custom-breadcrumb-1">
                        <li><a href="<?php echo site_url(); ?>" title="Home">Home</a></li>
                        <li class="active">
                            <a title="<?php echo the_title(); ?>"><?php echo the_title(); ?></a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="section-gap " data-aos="fade-up">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="cms pe-lg-5">
                    <?php echo apply_filters('the_content', the_content()); ?>
                </div>
            </div>
            <div class="col-lg-4 ps-lg-5 border-start mt-lg-0 d-none d-lg-block">
                <div class="position-sticky sticky-top">
                    <h2>Get in Touch</h2>

                    <div class="p-tag fw-bold mt-3 mt-lg-4 text-black">You can call us on:</div>
                    <div class="p-tag n-mt-1 text-body primary-link"><a href="#" title="Call Us">+1 (650) 595-3900</a></div>
                    
                    <div class="p-tag fw-bold mt-3 mt-lg-4 text-black">Email us at:</div>
                    <div class="p-tag n-mt-1 text-body primary-link"><a href="#" title="Call Us">service@loremipsum.com</a></div>

                    <div class="p-tag fw-bold mt-3 mt-lg-4 text-black">Mailing Address:</div>
                    <div class="p-tag n-mt-1 text-body primary-link">225 Shoreway Rd, San Carlos, California-94070, United States</div>

                    <div class="p-tag fw-bold mt-3 mt-lg-4 text-black">We are open:</div>
                    <div class="p-tag n-mt-1 text-body primary-link">Monday to Friday: 9:00 am to 4:00 pm (Administration Building)</div>                    
                </div>
            </div>
		</div>
    </div>
</section>

<?php get_footer(); ?>