<?php
// Hero Section Widget
class Application_Form_Section_Widget extends WP_Widget {
    function __construct() {
        parent::__construct(
            'application_form_section',
            __('Application Form', _THEME_DOMAIN),
            array('description' => __('Application form', _THEME_DOMAIN))
        );
    }

    // Frontend Output
    public function widget($args, $instance) {
        echo $args['before_widget']; ?>

        <section class="contact-section section-gap">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-lg-10">

                        <div class="mb-4 text-center">
                            <h5 class="text-primary fw-semibold"></h5>
                            <h2 class="fw-bold">Application Form</h2>
                            <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Quae dicta quia tempore dolores?
                                Labore magni neque veniam unde temporibus provident, accusantium enim quidem impedit
                                eaque accusamus recusandae earum necessitatibus architecto!</p>
                        </div>

                        <div class="card contact-form-card p-4 p-md-5">
                            <h4 class="fw-bold mb-2">Send us your Application</h4>
                            <p class="text-muted mb-4">
                                Fill out the form below and our recruitment team will get back to you as soon as
                                possible.
                            </p>

                            <form>

                                <!-- Basic Info -->
                                <div class="row g-4">
                                    <div class="col-md-6">
                                        <label class="form-label fw-bold">Full Name *</label>
                                        <input type="text" class="form-control form-control-lg text-only-input" placeholder="Your name" pattern="^[A-Za-z\s'\.-]{2,50}$" title="Please enter a valid name (letters and spaces only)." required>
                                    </div>

                                    <div class="col-md-6">
                                        <label class="form-label fw-bold">Email Address *</label>
                                        <input type="email" class="form-control form-control-lg" placeholder="your@email.com" pattern="^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$" title="Please enter a valid email address (e.g. user@domain.com)." required>
                                    </div>

                                    <div class="col-md-6">
                                        <label class="form-label fw-bold">Phone Number (with Country Code) *</label>
                                        <input type="tel" class="form-control form-control-lg phone-input" placeholder="+91 98244 08739" pattern="^\+\d{1,4}[- .]?\d{6,14}$" title="Please enter phone number with country code starting with + (e.g. +91 98244 08739)." required>
                                    </div>

                                    <div class="col-md-6">
                                        <label class="form-label fw-bold">Gender *</label>
                                        <select class="form-select form-select-lg" required>
                                            <option selected disabled value="">Select Gender</option>
                                            <option>Male</option>
                                            <option>Female</option>
                                            <option>Other</option>
                                        </select>
                                    </div>

                                    <div class="col-md-6">
                                        <label class="form-label fw-bold">Title *</label>
                                        <input type="text" class="form-control form-control-lg text-only-input" placeholder="e.g. Software Developer" pattern="^[A-Za-z\s'\.-]{2,100}$" title="Please enter a valid title using letters and spaces." required>
                                    </div>

                                    <div class="col-md-6">
                                        <label class="form-label fw-bold">Key Skills *</label>
                                        <input type="text" class="form-control form-control-lg" placeholder="e.g. Java, Python, SQL" required>
                                    </div>

                                    <div class="col-md-6">
                                        <label class="form-label fw-bold">Years of Experience *</label>
                                        <input type="number" step="0.5" min="0" max="60" class="form-control form-control-lg number-only-input" placeholder="e.g. 5" required>
                                    </div>

                                    <div class="col-md-6">
                                        <label class="form-label fw-bold">Current Salary *</label>
                                        <input type="text" class="form-control form-control-lg" placeholder="e.g. 10 LPA" required>
                                    </div>

                                    <div class="col-md-6">
                                        <label class="form-label fw-bold">Expected Salary *</label>
                                        <input type="text" class="form-control form-control-lg" placeholder="e.g. 15 LPA" required>
                                    </div>

                                    <div class="col-md-6">
                                        <label class="form-label fw-bold">Notice Period (Days) *</label>
                                        <input type="number" min="0" max="365" class="form-control form-control-lg number-only-input" placeholder="e.g. 30" required>
                                    </div>

                                    <div class="col-md-6">
                                        <label class="form-label fw-bold">Add Your Social Link</label>
                                        <input type="url" class="form-control form-control-lg" placeholder="e.g. https://linkedin.com/in/yourprofile">
                                    </div>

                                    <div class="col-md-12">
                                        <label class="form-label fw-bold">Upload Resume *</label>
                                        <input type="file" class="form-control form-control-lg" accept=".pdf,.doc,.docx" required>
                                        <div class="form-text">PDF or DOCX (Max. 10MB)</div>
                                    </div>
                                    <div class="col-md-12">
                                        <label class="form-label fw-bold">Comment</label>
                                        <textarea class="form-control form-control-lg" rows="5" placeholder="Add your comments..."></textarea>
                                    </div>

                                </div>

                                <!-- Submit Button -->
                                <div class="mt-4">
                                    <button type="submit" class="btn btn-primary" title="Submit Application">
                                        Submit Application
                                    </button>
                                </div>

                            </form>
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
function register_application_form_section_widget() {
    register_widget('Application_Form_Section_Widget');
}
add_action('widgets_init', 'register_application_form_section_widget');