<?php
// Hero Section Widget
class Page_Header_Section_Widget extends WP_Widget {
    function __construct() {
        parent::__construct(
            'page_header_section',
            __('Common :: Page Header', _THEME_DOMAIN),
            array('description' => __('Update page header content', _THEME_DOMAIN))
        );
    }

    // Frontend Output
    public function widget($args, $instance) {
        echo $args['before_widget'];

        // Dynamic fields
        $banner = !empty($instance['banner']) ? $instance['banner'] : site_url('wp-content/uploads/2026/03/i-banner.jpg');
        $title = !empty($instance['title']) ? $instance['title'] : get_the_title();
        $breadcrumb = !empty($instance['breadcrumb']) ? $instance['breadcrumb'] : get_the_title();
        ?>

        <section class="innerbanner-section">
            <div class="video-thumb">
                <div class="thumbnail-container object-fit">
                    <div class="thumbnail">
                        <img src="<?php echo esc_url($banner); ?>" alt="Contact Banner" title="Contact Banner" width="1920" height="500">
                    </div>
                </div>
                <div class="caption">
                    <div class="container">
                        <div class="row">
                            <div class="col-lg-8">
                                <h1 class="cm-title text-white"><?php echo esc_html($title); ?></h1>
                                <div class="breadcrumb-nav mt-3">
                                    <a href="<?php echo esc_url(home_url('/')); ?>" class="text-white" title="Home">
                                        Home
                                    </a>
                                    <span class="text-white mx-2">-</span>
                                    <span class="text-white"><?php echo esc_html($breadcrumb); ?></span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        
        <?php echo $args['after_widget'];
    }

    // Backend Form
    public function form($instance) {

        $banner = $instance['banner'] ?? '';
        $title = $instance['title'] ?? '';
        $breadcrumb = $instance['breadcrumb'] ?? '';
        ?>

        <p>
            <label>Banner Image URL</label>
            <input class="widefat" name="<?php echo $this->get_field_name('banner'); ?>" value="<?php echo esc_attr($banner); ?>">
        </p>

        <p>
            <label>Page Title</label>
            <input class="widefat" name="<?php echo $this->get_field_name('title'); ?>" value="<?php echo esc_attr($title); ?>">
        </p>

        <p>
            <label>Breadcrumb Text</label>
            <input class="widefat" name="<?php echo $this->get_field_name('breadcrumb'); ?>" value="<?php echo esc_attr($breadcrumb); ?>">
        </p>

    <?php }

    // Save Data (FIXED SAFE VERSION)
    public function update($new_instance, $old_instance) {
        $instance = [];

        $instance['banner'] = !empty($new_instance['banner']) ? esc_url_raw($new_instance['banner']) : '';
        $instance['title'] = !empty($new_instance['title']) ? sanitize_text_field($new_instance['title']) : '';
        $instance['breadcrumb'] = !empty($new_instance['breadcrumb']) ? sanitize_text_field($new_instance['breadcrumb']) : '';

        return $instance;
    }
}

// Register Widget
function register_page_header_section_widget() {
    register_widget('Page_Header_Section_Widget');
}
add_action('widgets_init', 'register_page_header_section_widget');