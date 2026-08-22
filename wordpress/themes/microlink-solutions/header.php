<!doctype html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo('charset'); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">

	<meta http-equiv="X-UA-Compatible" content="IE=Edge">
	<meta name="theme-color" content="#26a69a">

	<!-- SEO Control -->
	<meta name="robots" content="noindex, nofollow">
	<meta name="googlebot" content="noindex">

	<link rel="profile" href="https://gmpg.org/xfn/11">

	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<?php wp_body_open(); ?>
	<div id="wrapper">
		<header class="header-section">
			<div class="container">
				<div class="row">
					<div class="col-sm-12 d-flex align-items-center position-relative">
						<div class="part-auto part-01 me-2">
							<a href="<?php echo home_url(); ?>" title="<?php bloginfo('name'); ?>">
								<img 
									src="<?php echo site_url('wp-content/uploads/2026/03/new-logo.png'); ?>"
									alt="<?php bloginfo('name'); ?>" 
									style="height: 70px; width: auto;"
									width="87" height="25"
								>
							</a>
						</div>
						<div class="part-menu part-02 navbar-width">
							<nav class="menu" id="menu">
								<div class="mobile-company-name">
									<div class="company-name">Grow Personal</div>
									<button class="btn btn-link p-0 menu-close lh-sm" id="menu-close">
										<img src="<?php echo get_template_directory_uri(); ?>/assets/images/menu-close.svg" width="24" height="24">
									</button>
								</div>
								<?php wp_nav_menu([
									'theme_location' => 'primary-menu',
									'container' => false,
									'menu_class' => 'brand-nav brand-navbar',
									'menu_id' => 'menu_ul',
									'walker' => new Advanced_Mega_Menu_Walker(),
								]); ?>
							</nav>
							<div class="nav-overlay"></div>
						</div>
						<div class="part-auto part-04 ps-3">
							<a href="<?php echo home_url('/contact'); ?>" class="btn btn-primary d-none d-md-inline-block">
								<span>Contact Us</span>
							</a>

							<button class="btn btn-link p-0 lh-sm menu-open ms-2" id="menu-open">
								<img src="<?php echo get_template_directory_uri(); ?>/assets/images/menu-open.svg" width="24" height="24">
							</button>
						</div>
					</div>
				</div>
			</div>
		</header>