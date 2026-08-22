<?php
// Hero Section Widget
class Partnership_Section_Widget extends WP_Widget {
    function __construct() {
        parent::__construct(
            'partnership_section',
            __('Partnership :: All Section', _THEME_DOMAIN),
            array('description' => __('Update partnership all section content', _THEME_DOMAIN))
        );
    }

    // Frontend Output
    public function widget($args, $instance) {
        echo $args['before_widget']; ?>

        <section class="partner-page section-gap">
            <div class="container">
                <div class="d-flex justify-content-end align-items-center flex-wrap cm-nav">
                    <ul class="nav nav-pills mt-3 mt-md-0" id="partnerTab" role="tablist">
                        <li class="nav-item">
                            <button class="nav-link active" data-bs-toggle="pill" data-bs-target="#all">All
                                Partners</button>
                        </li>
                        <li class="nav-item">
                            <button class="nav-link" data-bs-toggle="pill" data-bs-target="#network">Network</button>
                        </li>
                        <li class="nav-item">
                            <button class="nav-link" data-bs-toggle="pill" data-bs-target="#security">Security</button>
                        </li>
                        <li class="nav-item">
                            <button class="nav-link" data-bs-toggle="pill" data-bs-target="#digital-Operations">Digital IT Operations</button>
                        </li>
                        <li class="nav-item">
                            <button class="nav-link" data-bs-toggle="pill" data-bs-target="#cloud">Cloud</button>
                        </li>
                        <li class="nav-item">
                            <button class="nav-link" data-bs-toggle="pill" data-bs-target="#data-center"> Data Center</button>
                        </li>
                        <li class="nav-item">
                            <button class="nav-link" data-bs-toggle="pill" data-bs-target="#dc-infrastructure"> DC Infrastructure</button>
                        </li>
                        <li class="nav-item">
                            <button class="nav-link" data-bs-toggle="pill" data-bs-target="#collaboration"> Collaboration</button>
                        </li>
                    </ul>
                </div>

                <div class="tab-content">
                    <div class="tab-pane fade mt-5 show active" id="all">

                        <div class="row g-4">
                            <div class="col-12"><h3>Cloud & Infrastructure</h3></div>
                            <div class="col-md-6 col-lg-3">
                                <div class="partner-card">
                                    <div class="thumbnail-container">
                                        <div class="thumbnail">
                                            <img src="https://upload.wikimedia.org/wikipedia/commons/5/51/IBM_logo.svg">
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6 col-lg-3">
                                <div class="partner-card">
                                    <div class="thumbnail-container">
                                        <div class="thumbnail">
                                            <img src="https://upload.wikimedia.org/wikipedia/commons/9/93/Amazon_Web_Services_Logo.svg">
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6 col-lg-3">
                                <div class="partner-card">
                                    <div class="thumbnail-container">
                                        <div class="thumbnail">
                                            <img src="https://upload.wikimedia.org/wikipedia/commons/f/fa/Microsoft_Azure.svg">
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6 col-lg-3">
                                <div class="partner-card">
                                    <div class="thumbnail-container">
                                        <div class="thumbnail">
                                            <img src="https://upload.wikimedia.org/wikipedia/commons/5/51/Google_Cloud_logo.svg">
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                    <div class="tab-pane fade mt-5 show active" id="network">

                        <div class="row g-4">
                            <div class="col-12"><h3>Cloud & Infrastructure</h3></div>
                            <div class="col-md-6 col-lg-3">
                                <div class="partner-card">
                                    <div class="thumbnail-container">
                                        <div class="thumbnail">
                                            <img src="https://upload.wikimedia.org/wikipedia/commons/5/51/IBM_logo.svg">
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6 col-lg-3">
                                <div class="partner-card">
                                    <div class="thumbnail-container">
                                        <div class="thumbnail">
                                            <img src="https://upload.wikimedia.org/wikipedia/commons/9/93/Amazon_Web_Services_Logo.svg">
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6 col-lg-3">
                                <div class="partner-card">
                                    <div class="thumbnail-container">
                                        <div class="thumbnail">
                                            <img src="https://upload.wikimedia.org/wikipedia/commons/f/fa/Microsoft_Azure.svg">
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6 col-lg-3">
                                <div class="partner-card">
                                    <div class="thumbnail-container">
                                        <div class="thumbnail">
                                            <img src="https://upload.wikimedia.org/wikipedia/commons/5/51/Google_Cloud_logo.svg">
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                    <div class="tab-pane fade mt-5 show active" id="security">
                        <div class="row g-4">
                            
                        </div>
                    </div>
                    <div class="tab-pane fade mt-5 show active" id="cloud">
                        <div class="row g-4">
                            <div class="col-12"><h3>Cloud & Infrastructure</h4></div>
                            <div class="col-md-6 col-lg-3">
                                <div class="partner-card">
                                    <div class="thumbnail-container">
                                        <div class="thumbnail">
                                            <img src="https://upload.wikimedia.org/wikipedia/commons/5/51/IBM_logo.svg">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 col-lg-3">
                                <div class="partner-card">
                                    <div class="thumbnail-container">
                                        <div class="thumbnail">
                                            <img src="https://upload.wikimedia.org/wikipedia/commons/9/93/Amazon_Web_Services_Logo.svg">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane fade mt-5 show active" id="data-center">
                        <div class="row g-4">
                            <div class="col-12"><h3>Cloud & Infrastructure</h4></div>
                            <div class="col-md-6 col-lg-3">
                                <div class="partner-card">
                                    <div class="thumbnail-container">
                                        <div class="thumbnail">
                                            <img src="https://upload.wikimedia.org/wikipedia/commons/4/48/Dell_Logo.svg">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane fade mt-5 show active" id=" dc-infrastructure ">
                        <div class="row g-4">
                            <div class="col-12"><h3>Cloud & Infrastructure</h4></div>
                            <div class="col-md-6 col-lg-3">
                                <div class="partner-card">
                                    <div class="thumbnail-container">
                                        <div class="thumbnail">
                                            <img src="https://upload.wikimedia.org/wikipedia/commons/0/08/Cisco_logo_blue_2016.svg">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane fade mt-5 show active" id=" collaboration ">
                        <div class="row g-4">
                            <div class="col-12"><h3>Cloud & Infrastructure</h4></div>
                            <div class="col-md-6 col-lg-3">
                                <div class="partner-card">
                                    <div class="thumbnail-container">
                                        <div class="thumbnail">
                                            <img src="https://upload.wikimedia.org/wikipedia/commons/0/08/Cisco_logo_blue_2016.svg">
                                        </div>
                                    </div>
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
        ?>

        <?php
    }

    // Save Data
    public function update($new_instance, $old_instance) {
        $instance = [];

        return $instance;
    }
}

// Register Widget
function register_partnership_section_widget() {
    register_widget('Partnership_Section_Widget');
}
add_action('widgets_init', 'register_partnership_section_widget');