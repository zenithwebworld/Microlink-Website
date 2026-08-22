<?php

class Career_Intro_Section_Widget extends WP_Widget {
    function __construct() {
        parent::__construct(
            'career_intro_section',
            __('Career :: Intro', _THEME_DOMAIN),
            array('description' => __('Update intro content', _THEME_DOMAIN))
        );
    }

    // Frontend Output
    public function widget($args, $instance) {
        echo $args['before_widget']; ?>

        <section class="section-gap double-gap">
            <div class="container">

                <div class="text-center mb-5">
                    <h2 class="cm-title text-black fs-40">Empowering <span>Talent</span> Since 1996 </h2>
                    <div class="mx-auto mb-4"
                        style="width:70px;height:4px;background:var(--primary-color);border-radius:5px;"></div>
                    <p class="text-muted mx-auto" style="max-width:600px;">
                        We build a culture of excellence, innovation, and trust. Join our mission to deliver cutting-edge IT
                        infrastructure across the globe.
                    </p>
                </div>

                <div class="row g-4">

                    <div class="col-md-6 col-lg-4 col-xl-3">
                        <div class="feature-card h-100">
                            <div class="icon-circle">
                                <span class="material-symbols-outlined"><i class="n-icon" data-icon="s-psychology" data-iconwidth="35px" data-iconheight="35px"></i></span>
                            </div>
                            <h5 class="fw-bold mb-2">Enterprise Mindset</h5>
                            <p class="text-muted small">We approach every challenge with strategic precision and high-level enterprise expertisestrategic precision and high-level enterprise expertise.</p>
                        </div>
                    </div>

                    <div class="col-md-6 col-lg-4 col-xl-3">
                        <div class="feature-card h-100">
                            <div class="icon-circle">
                                <span class="material-symbols-outlined"><i class="n-icon" data-icon="s-security" data-iconwidth="35px" data-iconheight="35px"></i></span>
                            </div>
                            <h5 class="fw-bold mb-2">Security First</h5>
                            <p class="text-muted small">Integrity and data protection are at the core of our solutions and workplace culture strategic precision and high-level enterprise expertise.</p>
                        </div>
                    </div>

                    <div class="col-md-6 col-lg-4 col-xl-3">
                        <div class="feature-card h-100">
                            <div class="icon-circle">
                                <span class="material-symbols-outlined"><i class="n-icon" data-icon="s-expert_team" data-iconwidth="35px" data-iconheight="35px"></i></span>
                            </div>
                            <h5 class="fw-bold mb-2">Expert Team</h5>
                            <p class="text-muted small">strategic precision and high-level enterprise expertiseWork alongside certified industry veterans and innovative thinkers. </p>
                        </div>
                    </div>

                    <div class="col-md-6 col-lg-4 col-xl-3">
                        <div class="feature-card h-100">
                            <div class="icon-circle">
                                <span class="material-symbols-outlined"><i class="n-icon" data-icon="s-continuous-growth" data-iconwidth="35px" data-iconheight="35px"></i></span>
                            </div>
                            <h5 class="fw-bold mb-2">Continuous Growth</h5>
                            <p class="text-muted small">We scale strategic precision and high-level enterprise expertise careers as fast as we scale infrastructure.</p>
                        </div>
                    </div>

                </div>
            </div>
        </section>
        
        <?php echo $args['after_widget'];
    }

    // Backend Form
    public function form($instance) { ?>

    <?php }

    // Save Data (FIXED SAFE VERSION)
    public function update($new_instance, $old_instance) {
        $instance = [];
        return $instance;
    }
}

// Register Widget
function register_career_intro_section_widget() {
    register_widget('Career_Intro_Section_Widget');
}
add_action('widgets_init', 'register_career_intro_section_widget');