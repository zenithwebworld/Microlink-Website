<?php

// Define variables
define('_S_VERSION', time());
define('_THEME_DOMAIN', "microlink-solutions");

// Sets up theme defaults and registers support for various WordPress features.
function microlink_solutions_setup() {
	add_theme_support('automatic-feed-links');
	add_theme_support('title-tag');
	add_theme_support('post-thumbnails');
	register_nav_menus(
		array(
			'primary-menu' => esc_html__( 'Primary Menu', 'microlink-solutions' ),
		)
	);
	add_theme_support(
		'html5',
		array(
			'search-form',
			'comment-form',
			'comment-list',
			'gallery',
			'caption',
			'style',
			'script',
		)
	);
	add_theme_support(
		'custom-background',
		apply_filters(
			'microlink_solutions_custom_background_args',
			array(
				'default-color' => 'ffffff',
				'default-image' => '',
			)
		)
	);
	add_theme_support( 'customize-selective-refresh-widgets' );
	add_theme_support(
		'custom-logo',
		array(
			'height' => 250,
			'width' => 250,
			'flex-width' => true,
			'flex-height' => true,
		)
	);
    register_nav_menus([
        'footer_company' => 'Footer Company Menu',
        'footer_quick'   => 'Footer Quick Links',
        'footer_services'=> 'Footer Services Menu',
    ]);
}
add_action( 'after_setup_theme', 'microlink_solutions_setup' );

// Set the content width in pixels, based on the theme's design and stylesheet.
function microlink_solutions_content_width() {
	$GLOBALS['content_width'] = apply_filters( 'microlink_solutions_content_width', 640 );
}
add_action( 'after_setup_theme', 'microlink_solutions_content_width', 0 );

// Register widget area.
function microlink_solutions_widgets_init() {
	register_sidebar(
		array(
			'name'          => esc_html__( 'Sidebar', 'microlink-solutions' ),
			'id'            => 'sidebar-1',
			'description'   => esc_html__( 'Add widgets here.', 'microlink-solutions' ),
			'before_widget' => '<section id="%1$s" class="widget %2$s">',
			'after_widget'  => '</section>',
			'before_title'  => '<h2 class="widget-title">',
			'after_title'   => '</h2>',
		)
	);
}
add_action( 'widgets_init', 'microlink_solutions_widgets_init' );

// Enqueue scripts and styles.
function microlink_solutions_scripts() {
	// Google Fonts
    wp_enqueue_style(
        'google-fonts',
        'https://fonts.googleapis.com/css2?family=Marcellus&family=Space+Grotesk:wght@300..700&display=swap',
        array(),
        null
    );

    // Bootstrap CSS
    wp_enqueue_style(
        'bootstrap-css',
        'https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css',
        array(),
        '5.0.2'
    );

	// AOS CSS
    wp_enqueue_style(
        'aos-css',
        'https://unpkg.com/aos@2.3.1/dist/aos.css',
        array(),
        '2.3.1'
    );

    // Owl Carousel CSS
    wp_enqueue_style(
        'owl-carousel',
        'https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.carousel.min.css',
        array(),
        '2.3.4'
    );

    wp_enqueue_style(
        'owl-theme',
        'https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.theme.default.min.css',
        array(),
        '2.3.4'
    );

    // Main CSS
    wp_enqueue_style(
        'main-style',
        get_template_directory_uri() . '/assets/css/main.css',
        array(),
        filemtime(get_template_directory() . '/assets/css/main.css')
    );

    // jQuery (WordPress default OR CDN)
    wp_deregister_script('jquery');
    wp_enqueue_script(
        'jquery',
        'https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js',
        array(),
        '3.7.1',
        true
    );

	// Bootstrap JS
    wp_enqueue_script(
        'bootstrap-js',
        'https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js',
        array('jquery'),
        '5.0.2',
        true
    );

    // AOS JS
    wp_enqueue_script(
        'aos-js',
        'https://unpkg.com/aos@2.3.1/dist/aos.js',
        array(),
        '2.3.1',
        true
    );

    // Owl Carousel JS
    wp_enqueue_script(
        'owl-carousel-js',
        'https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.min.js',
        array('jquery'),
        '2.3.4',
        true
    );

    // Custom JS
    wp_enqueue_script(
        'svg-icons',
        get_template_directory_uri() . '/assets/js/svgicon.js',
        array(),
        null,
        true
    );

    wp_enqueue_script(
        'main-js',
        get_template_directory_uri() . '/assets/js/html-common.js',
        array('jquery'),
        null,
        true
    );

	wp_enqueue_style( 'microlink-solutions-style', get_stylesheet_uri(), array(), _S_VERSION );
}
add_action( 'wp_enqueue_scripts', 'microlink_solutions_scripts' );

// Include files
require get_template_directory() . '/inc/class-mega-menu-walker.php';

// Include Post Type
require get_template_directory() . '/include/post_type/solution.php';
require get_template_directory() . '/include/post_type/services.php';
require get_template_directory() . '/include/post_type/partners.php';
require get_template_directory() . '/include/post_type/testimonial.php';
require get_template_directory() . '/include/post_type/teams.php';
require get_template_directory() . '/include/post_type/stories.php';
require get_template_directory() . '/include/post_type/jobs.php';
require get_template_directory() . '/include/post_type/life.php';
require get_template_directory() . '/include/post_type/awards.php';
require get_template_directory() . '/include/post_type/case_studies.php';

// Include widgets (Common)
require get_template_directory() . '/include/widget/common/_page_header.php';
require get_template_directory() . '/include/widget/common/_case_studies_section.php';

// Include widgets (Homepage)
require get_template_directory() . '/include/widget/homepage/_hero_section.php';
require get_template_directory() . '/include/widget/homepage/_about_section.php';
require get_template_directory() . '/include/widget/homepage/_counter_section.php';
require get_template_directory() . '/include/widget/homepage/_solution_section.php';
require get_template_directory() . '/include/widget/homepage/_service_section.php';
require get_template_directory() . '/include/widget/homepage/_partner_section.php';
require get_template_directory() . '/include/widget/homepage/_testimonials_section.php';
require get_template_directory() . '/include/widget/homepage/_blog_section.php';

// Include widgets (About)
require get_template_directory() . '/include/widget/about/_intro_section.php';
require get_template_directory() . '/include/widget/about/_vision_section.php';
require get_template_directory() . '/include/widget/about/_philosophy_section.php';
require get_template_directory() . '/include/widget/about/_stories_section.php';

// Include widgets (Career)
require get_template_directory() . '/include/widget/career/_intro_section.php';
require get_template_directory() . '/include/widget/career/_positions_section.php';
require get_template_directory() . '/include/widget/career/_life_section.php';

// Include widgets (Other Pages)
require get_template_directory() . '/include/widget/contact/_all_section.php';
require get_template_directory() . '/include/widget/partnership/_all_section.php';
require get_template_directory() . '/include/widget/leadership/_all_section.php';
require get_template_directory() . '/include/widget/awards-recognition/_all_section.php';
require get_template_directory() . '/include/widget/application-form/_all_section.php';
require get_template_directory() . '/include/widget/sitemap/_all_section.php';

// Add menu type field
function add_menu_type_field($item_id, $item) {
    $value = get_post_meta($item_id, '_menu_type', true); ?>
    <p class="description description-wide">
        <label>
            Menu Type<br>
            <select name="menu_type[<?php echo $item_id; ?>]" style="width:100%;">
                <option value="">Default</option>
                <option value="company" <?php selected($value, 'company'); ?>>Company (Option-1)</option>
                <option value="solutions" <?php selected($value, 'solutions'); ?>>Solutions (Mega)</option>
                <option value="services" <?php selected($value, 'services'); ?>>Services (Dropdown)</option>
            </select>
        </label>
    </p>
    <?php
}
add_action('wp_nav_menu_item_custom_fields', 'add_menu_type_field', 10, 2);

function save_menu_type_field($menu_id, $menu_item_db_id) {
    if (isset($_POST['menu_type'][$menu_item_db_id])) {
        update_post_meta(
            $menu_item_db_id,
            '_menu_type',
            sanitize_text_field($_POST['menu_type'][$menu_item_db_id])
        );
    }
}
add_action('wp_update_nav_menu_item', 'save_menu_type_field', 10, 2);

function add_menu_item_description_field($item_id, $item, $depth, $args) {
	$desc = get_post_meta($item->ID, '_menu_item_desc', true); ?>
    <p class="description description-wide">
        <label for="edit-menu-item-desc-<?php echo esc_attr($item->ID); ?>">
            Item Description<br>
            <textarea 
                id="edit-menu-item-desc-<?php echo esc_attr($item->ID); ?>"
                class="widefat"
                rows="3"
                cols="20"
                name="menu_item_desc[<?php echo esc_attr($item->ID); ?>]"
            ><?php echo esc_textarea($desc); ?></textarea>
        </label>
    </p>
<?php }
add_action('wp_nav_menu_item_custom_fields', 'add_menu_item_description_field', 10, 4);

function save_menu_item_description_field($menu_id, $menu_item_db_id) {
    if (!isset($_POST['menu_item_desc'])) {
        return;
    }

    if (isset($_POST['menu_item_desc'][$menu_item_db_id])) {
        $sanitized_value = sanitize_textarea_field($_POST['menu_item_desc'][$menu_item_db_id]);
        update_post_meta(
            $menu_item_db_id,
            '_menu_item_desc',
            $sanitized_value
        );
    } else {
        delete_post_meta($menu_item_db_id, '_menu_item_desc');
    }
}
add_action('wp_update_nav_menu_item', 'save_menu_item_description_field', 10, 2);

class Footer_Menu_Walker extends Walker_Nav_Menu {

    function start_el(&$output, $item, $depth=0, $args=[], $id=0) {

        $output .= '<li>';

        $output .= '<i class="n-icon text-primary me-2" 
            data-icon="s-right-dubble" 
            data-iconwidth="12px" 
            data-iconheight="12px"></i>';

        $output .= '<a href="' . esc_url($item->url) . '">' 
                    . esc_html($item->title) . 
                   '</a>';

        $output .= '</li>';
    }
}

// Register Footer Customizer Settings
function microlink_solutions_customize_register($wp_customize) {
    $wp_customize->add_section('footer_settings_section', array(
        'title'    => __('Footer Settings', _THEME_DOMAIN),
        'priority' => 130,
    ));

    // Footer Contact Email
    $wp_customize->add_setting('footer_email', array(
        'default'           => 'info@microlink.co.in',
        'sanitize_callback' => 'sanitize_email',
    ));
    $wp_customize->add_control('footer_email', array(
        'label'   => __('Footer Email', _THEME_DOMAIN),
        'section' => 'footer_settings_section',
        'type'    => 'email',
    ));

    // Footer Contact Phone
    $wp_customize->add_setting('footer_phone', array(
        'default'           => '+91 98244 08739',
        'sanitize_callback' => 'sanitize_text_field',
    ));
    $wp_customize->add_control('footer_phone', array(
        'label'   => __('Footer Phone', _THEME_DOMAIN),
        'section' => 'footer_settings_section',
        'type'    => 'text',
    ));

    // Footer Address
    $wp_customize->add_setting('footer_address', array(
        'default'           => '4th Floor, Sarthik Complex, Near Iscon Circle, Satellite, Ahmedabad, Gujarat 380015',
        'sanitize_callback' => 'sanitize_textarea_field',
    ));
    $wp_customize->add_control('footer_address', array(
        'label'   => __('Footer Address', _THEME_DOMAIN),
        'section' => 'footer_settings_section',
        'type'    => 'textarea',
    ));

    // Office Hours
    $wp_customize->add_setting('footer_office_hours', array(
        'default'           => 'Monday to Friday: 9:00 am to 6:00 pm',
        'sanitize_callback' => 'sanitize_text_field',
    ));
    $wp_customize->add_control('footer_office_hours', array(
        'label'   => __('Office Hours', _THEME_DOMAIN),
        'section' => 'footer_settings_section',
        'type'    => 'text',
    ));

    // Social Links
    $wp_customize->add_setting('footer_facebook', array(
        'default'           => '#',
        'sanitize_callback' => 'esc_url_raw',
    ));
    $wp_customize->add_control('footer_facebook', array(
        'label'   => __('Facebook URL', _THEME_DOMAIN),
        'section' => 'footer_settings_section',
        'type'    => 'url',
    ));

    $wp_customize->add_setting('footer_twitter', array(
        'default'           => '#',
        'sanitize_callback' => 'esc_url_raw',
    ));
    $wp_customize->add_control('footer_twitter', array(
        'label'   => __('Twitter URL', _THEME_DOMAIN),
        'section' => 'footer_settings_section',
        'type'    => 'url',
    ));

    $wp_customize->add_setting('footer_linkedin', array(
        'default'           => '#',
        'sanitize_callback' => 'esc_url_raw',
    ));
    $wp_customize->add_control('footer_linkedin', array(
        'label'   => __('LinkedIn URL', _THEME_DOMAIN),
        'section' => 'footer_settings_section',
        'type'    => 'url',
    ));
}
add_action('customize_register', 'microlink_solutions_customize_register');