<?php
// Hero Section Widget
class Sitemap_Section_Widget extends WP_Widget {
    function __construct() {
        parent::__construct(
            'sitemap_section',
            __('Sitemap :: All Section', _THEME_DOMAIN),
            array('description' => __('Update Sitemap all section content', _THEME_DOMAIN))
        );
    }

    // Frontend Output
    public function widget($args, $instance) {
        echo $args['before_widget']; ?>

        <section class="section-gap">
            <div class="container">
                <div class="row">
                    <div class="col-12">
                        <div class="sitemap-page">
                            <div class="container">
                                <div class="bg-white page-min-height px-lg-5 px-3 pb-3">
                                    <ul class="main">
                                        <li>
                                            <a href="#">Company</a>
                                            <ul>
                                                <li><a href="#">About Us</a></li>
                                                <li><a href="#">Leadership</a></li>
                                                <li><a href="#">Career</a></li>
                                                <li><a href="#">Awards & Recognition</a></li>
                                                <li><a href="#">Life @Microlink</a></li>
                                            </ul>
                                        </li>
                                        <li class="full-width">
                                            <a href="#">Solutions</a>
                                            <ul>
                                                <li>
                                                    <a href="#">Digital Transformation</a>
                                                    <ul>
                                                        <li><a href="#">Internet of Things (IOT)</a></li>
                                                        <li><a href="#">Data Analytics</a></li>
                                                        <li><a href="#">Business Process Transformation</a></li>
                                                        <li><a href="#">Process Integration</a></li>
                                                        <li><a href="#">Industry 4.0 Practices</a></li>
                                                        <li><a href="#">Software Practices</a></li>
                                                    </ul>
                                                </li>
                                                <li>
                                                    <a href="#">Converged Network</a>
                                                    <ul>
                                                        <li><a href="#">Structured Cabling System</a></li>
                                                        <li><a href="#">Digital Networking</a></li>
                                                        <li><a href="#">Wireless & Mobility</a></li>
                                                        <li><a href="#">Security</a></li>
                                                        <li><a href="#">Unified Communication</a></li>
                                                        <li><a href="#">Network Management System</a></li>
                                                    </ul>
                                                </li>
                                                <li>
                                                    <a href="#">System Infrastructure</a>
                                                    <ul>
                                                        <li><a href="#">Hyper Converged Infrastructure</a></li>
                                                        <li><a href="#">Servers</a></li>
                                                        <li><a href="#">Storage Systems</a></li>
                                                        <li><a href="#">Data Availability</a></li>
                                                        <li><a href="#">Virtualization</a></li>
                                                        <li><a href="#">Cloud Computing</a></li>
                                                    </ul>
                                                </li>
                                                <li>
                                                    <a href="#">Data Centre</a>
                                                    <ul>
                                                        <li><a href="#">Cooling Infrastructure</a></li>
                                                        <li><a href="#">Power & Distribution</a></li>
                                                        <li><a href="#">Rack & Cabinet</a></li>
                                                        <li><a href="#">Data Centre Security</a></li>
                                                        <li><a href="#">Design & Build</a></li>
                                                        <li><a href="#">Management & Automation</a></li>
                                                    </ul>
                                                </li>
                                                <li>
                                                    <a href="#">Collaboration</a>
                                                    <ul>
                                                        <li><a href="#">Audio Visual Solutions</a></li>
                                                        <li><a href="#">Conferencing Solutions</a></li>
                                                        <li><a href="#">Video Wall & Displays</a></li>
                                                        <li><a href="#">Boardroom Solutions</a></li>
                                                        <li><a href="#">PA Systems</a></li>
                                                        <li><a href="#">Digital Signage</a></li>
                                                    </ul>
                                                </li>
                                                <li>
                                                    <a href="#">ELV</a>
                                                    <ul>
                                                        <li><a href="#">Surveillance & Video Analytics</a></li>
                                                        <li><a href="#">Access Control & Visitor Management</a></li>
                                                        <li><a href="#">Fire Detection & Suppression</a></li>
                                                        <li><a href="#">IBMS</a></li>
                                                        <li><a href="#">Boom Barrier & Parking</a></li>
                                                    </ul>
                                                </li>
                                                <li>
                                                    <a href="#">IT Services</a>
                                                    <ul>
                                                        <li><a href="#">Infrastructure Management</a></li>
                                                        <li><a href="#">Consultation & Advisory</a></li>
                                                        <li><a href="#">System Integration</a></li>
                                                        <li><a href="#">Application Management</a></li>
                                                        <li><a href="#">Maintenance Service</a></li>
                                                        <li><a href="#">IT Outsourcing</a></li>
                                                    </ul>
                                                </li>
                                            </ul>
                                        </li>
                                        <li>
                                            <a href="#">Services</a>
                                            <ul>
                                                <li><a href="#">Consulting Services</a></li>
                                                <li><a href="#">Managed Services</a></li>
                                                <li><a href="#">SOC Services</a></li>
                                                <li><a href="#">Program Management Services</a></li>
                                            </ul>
                                        </li>
                                        <li><a href="#">Services</a></li>
                                        <li><a href="#">Partnership</a></li>
                                        <li><a href="#">Blogs</a></li>
                                        <li><a href="#">Contact Us</a></li>
                                    </ul>
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
    }

    // Save Data
    public function update($new_instance, $old_instance) {
        $instance = [];
        return $instance;
    }
}

// Register Widget
function register_sitemap_section_widget() {
    register_widget('Sitemap_Section_Widget');
}
add_action('widgets_init', 'register_sitemap_section_widget');