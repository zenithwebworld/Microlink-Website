<?php get_header(); ?>
	<div class="breadcrumb-section bg-img jarallax" style="background: #02549e;">
        <div class="container">
            <div class="breadcrumb-content">
                <div class="divider" style="height: 40px;"></div>
                <h1 style="font-size: 50px;"><?php echo wp_kses_post(get_the_title()); ?></h1>
                <ul class="list-unstyled">
                    <li><a href="<?php echo site_url(); ?>">Home</a></li>
                    <li><a href="<?php echo site_url('blog'); ?>">Blog</a></li>
                    <li><?php echo wp_kses_post(get_the_title()); ?></li>
                </ul>
            </div>
        </div>
        <div class="divider" style="height: 50px;"></div>
    </div>
    <div class="blog-section">
    	<div class="divider"></div>
    	<div class="container">
    		<div class="row g-5 g-md-4 g-xxl-5">
    			<div class="col-12">
    				<?php starliner_dream_post_thumbnail(); ?>
    			</div>
    			<div class="col-12 col-md-7 col-lg-8">
    				<div class="pe-lg-3">
    					<div class="single-blog-content wow fadeInUp" data-wow-duration="1000ms" data-wow-delay="200ms">
    						<div class="post-body">
    							<h3 class="post-title mb-4"><?php echo wp_kses_post(get_the_title()); ?></h3>
    							<div class="d-flex flex-column gap-4">
    								<?php the_content(); ?>
    							</div>
    						</div>
    					</div>
    					<div class="divider-sm"></div>
    				</div>
    			</div>
    			<div class="col-12 col-md-5 col-lg-4">
    				<div class="d-flex flex-column gap-5">
    					<?php get_sidebar(); ?>
    				</div>
    			</div>
    		</div>
    	</div>
    	<div class="divider"></div>
    </div>
<?php get_footer();