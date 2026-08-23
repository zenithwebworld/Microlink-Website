<?php
// Candidate Application Form Widget
class Candidate_Form_Section_Widget extends WP_Widget {
    function __construct() {
        parent::__construct(
            'candidate_form_section',
            __('Career :: Application Form', _THEME_DOMAIN),
            array('description' => __('Display candidate job application form section', _THEME_DOMAIN))
        );
    }

    // Frontend Output
    public function widget($args, $instance) {
        echo $args['before_widget'];

        $title        = !empty($instance['title']) ? $instance['title'] : 'Application Form';
        $subtitle     = !empty($instance['subtitle']) ? $instance['subtitle'] : 'Take the next step in your career with Microlink. Fill out the application details below and our recruitment team will review your profile.';
        $form_title   = !empty($instance['form_title']) ? $instance['form_title'] : 'Send us your Application';
        $recipient    = !empty($instance['recipient_email']) ? $instance['recipient_email'] : 'jobs@microlink.co.in';

        $submission_status = '';
        $submission_msg    = '';

        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['candidate_widget_form_nonce'])) {
            if (wp_verify_nonce($_POST['candidate_widget_form_nonce'], 'submit_candidate_widget_form')) {
                
                $full_name       = sanitize_text_field($_POST['full_name'] ?? '');
                $email           = sanitize_email($_POST['email'] ?? '');
                $phone           = sanitize_text_field($_POST['phone'] ?? '');
                $gender          = sanitize_text_field($_POST['gender'] ?? '');
                $app_title       = sanitize_text_field($_POST['title'] ?? '');
                $skills          = sanitize_text_field($_POST['skills'] ?? '');
                $experience      = sanitize_text_field($_POST['experience'] ?? '');
                $current_salary  = sanitize_text_field($_POST['current_salary'] ?? '');
                $expected_salary = sanitize_text_field($_POST['expected_salary'] ?? '');
                $notice_period   = sanitize_text_field($_POST['notice_period'] ?? '');
                $social_link     = esc_url_raw($_POST['social_link'] ?? '');
                $comment         = sanitize_textarea_field($_POST['comment'] ?? '');

                if (!preg_match('/^[A-Za-z\s\'\.-]{2,50}$/', $full_name)) {
                    $submission_status = 'danger';
                    $submission_msg    = 'Please enter a valid full name (letters and spaces only).';
                } elseif (!is_email($email) || !preg_match('/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/', $email)) {
                    $submission_status = 'danger';
                    $submission_msg    = 'Please enter a valid email address (e.g. name@example.com).';
                } elseif (!preg_match('/^\+\d{1,4}[- .]?\d{6,14}$/', $phone)) {
                    $submission_status = 'danger';
                    $submission_msg    = 'Please enter a valid phone number with country code starting with + (e.g. +91 98244 08739).';
                } elseif (!empty($full_name) && !empty($email) && !empty($phone)) {
                    $to      = $recipient;
                    $subject = 'New Job Application: ' . $full_name . ' - ' . ($app_title ?: 'Candidate');
                    
                    $headers   = array('Content-Type: text/html; charset=UTF-8');
                    $headers[] = 'Reply-To: ' . $full_name . ' <' . $email . '>';

                    $message  = '<html><body style="font-family: Arial, sans-serif; line-height: 1.6; color: #333;">';
                    $message .= '<h2 style="color: #e43b2f;">New Candidate Application Received</h2>';
                    $message .= '<table style="width: 100%; max-width: 600px; border-collapse: collapse; border: 1px solid #eee;">';
                    $message .= '<tr><td style="padding: 8px 12px; font-weight: bold; background: #f9f9f9;">Full Name:</td><td style="padding: 8px 12px;">' . esc_html($full_name) . '</td></tr>';
                    $message .= '<tr><td style="padding: 8px 12px; font-weight: bold; background: #f9f9f9;">Email:</td><td style="padding: 8px 12px;"><a href="mailto:' . esc_attr($email) . '">' . esc_html($email) . '</a></td></tr>';
                    $message .= '<tr><td style="padding: 8px 12px; font-weight: bold; background: #f9f9f9;">Phone:</td><td style="padding: 8px 12px;">' . esc_html($phone) . '</td></tr>';
                    $message .= '<tr><td style="padding: 8px 12px; font-weight: bold; background: #f9f9f9;">Gender:</td><td style="padding: 8px 12px;">' . esc_html($gender) . '</td></tr>';
                    $message .= '<tr><td style="padding: 8px 12px; font-weight: bold; background: #f9f9f9;">Title / Applied For:</td><td style="padding: 8px 12px;">' . esc_html($app_title) . '</td></tr>';
                    $message .= '<tr><td style="padding: 8px 12px; font-weight: bold; background: #f9f9f9;">Key Skills:</td><td style="padding: 8px 12px;">' . esc_html($skills) . '</td></tr>';
                    $message .= '<tr><td style="padding: 8px 12px; font-weight: bold; background: #f9f9f9;">Experience:</td><td style="padding: 8px 12px;">' . esc_html($experience) . ' Years</td></tr>';
                    $message .= '<tr><td style="padding: 8px 12px; font-weight: bold; background: #f9f9f9;">Current Salary:</td><td style="padding: 8px 12px;">' . esc_html($current_salary) . '</td></tr>';
                    $message .= '<tr><td style="padding: 8px 12px; font-weight: bold; background: #f9f9f9;">Expected Salary:</td><td style="padding: 8px 12px;">' . esc_html($expected_salary) . '</td></tr>';
                    $message .= '<tr><td style="padding: 8px 12px; font-weight: bold; background: #f9f9f9;">Notice Period:</td><td style="padding: 8px 12px;">' . esc_html($notice_period) . ' Days</td></tr>';
                    if (!empty($social_link)) {
                        $message .= '<tr><td style="padding: 8px 12px; font-weight: bold; background: #f9f9f9;">Social Profile:</td><td style="padding: 8px 12px;"><a href="' . esc_url($social_link) . '" target="_blank">' . esc_html($social_link) . '</a></td></tr>';
                    }
                    if (!empty($comment)) {
                        $message .= '<tr><td style="padding: 8px 12px; font-weight: bold; background: #f9f9f9;">Comment:</td><td style="padding: 8px 12px;">' . nl2br(esc_html($comment)) . '</td></tr>';
                    }
                    $message .= '</table>';
                    $message .= '</body></html>';

                    $attachments = array();

                    // Handle Resume File Upload
                    if (!empty($_FILES['resume_file']['name'])) {
                        require_once(ABSPATH . 'wp-admin/includes/file.php');
                        $uploaded_file = $_FILES['resume_file'];
                        $upload_overrides = array('test_form' => false);
                        $movefile = wp_handle_upload($uploaded_file, $upload_overrides);

                        if ($movefile && !isset($movefile['error'])) {
                            $attachments[] = $movefile['file'];
                        }
                    }

                    $sent = wp_mail($to, $subject, $message, $headers, $attachments);

                    if ($sent) {
                        $submission_status = 'success';
                        $submission_msg    = 'Thank you! Your application has been sent successfully to our recruitment team (' . esc_html($recipient) . ').';
                    } else {
                        $submission_status = 'danger';
                        $submission_msg    = 'Thank you! Your details have been recorded. You can also email directly to ' . esc_html($recipient) . '.';
                    }
                } else {
                    $submission_status = 'danger';
                    $submission_msg    = 'Please fill in all required fields (Full Name, Email Address, and Phone Number).';
                }
            } else {
                $submission_status = 'danger';
                $submission_msg    = 'Security check failed. Please refresh the page and try again.';
            }
        }

        $prefill_title = sanitize_text_field($_GET['job_title'] ?? $_GET['job_id'] ?? '');
        ?>

        <section class="contact-section section-gap">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-lg-10">

                        <div class="mb-4 text-center">
                            <h2 class="fw-bold"><?php echo esc_html($title); ?></h2>
                            <p class="text-muted"><?php echo esc_html($subtitle); ?></p>
                        </div>

                        <?php if (!empty($submission_msg)) : ?>
                            <div class="alert alert-<?php echo esc_attr($submission_status); ?> alert-dismissible fade show mb-4" role="alert">
                                <strong><?php echo $submission_status === 'success' ? 'Success!' : 'Notice:'; ?></strong> <?php echo esc_html($submission_msg); ?>
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        <?php endif; ?>

                        <div class="card contact-form-card p-4 p-md-5 border-0 shadow-sm rounded-3">
                            <h4 class="fw-bold mb-2 text-black"><?php echo esc_html($form_title); ?></h4>
                            <p class="text-muted mb-4">
                                Fill out the form below and your application will be routed directly to <strong><?php echo esc_html($recipient); ?></strong>.
                            </p>

                            <form action="" method="POST" enctype="multipart/form-data">
                                <?php wp_nonce_field('submit_candidate_widget_form', 'candidate_widget_form_nonce'); ?>

                                <div class="row g-4">
                                    <div class="col-md-6">
                                        <label class="form-label fw-bold text-dark">Full Name *</label>
                                        <input type="text" name="full_name" class="form-control form-control-lg text-only-input" placeholder="Your name" pattern="^[A-Za-z\s'\.-]{2,50}$" title="Please enter a valid name (letters and spaces only)." required>
                                    </div>

                                    <div class="col-md-6">
                                        <label class="form-label fw-bold text-dark">Email Address *</label>
                                        <input type="email" name="email" class="form-control form-control-lg" placeholder="your@email.com" pattern="^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$" title="Please enter a valid email address (e.g. user@domain.com)." required>
                                    </div>

                                    <div class="col-md-6">
                                        <label class="form-label fw-bold text-dark">Phone Number (with Country Code) *</label>
                                        <input type="tel" name="phone" class="form-control form-control-lg phone-input" placeholder="+91 98244 08739" pattern="^\+\d{1,4}[- .]?\d{6,14}$" title="Please enter phone number with country code starting with + (e.g. +91 98244 08739)." required>
                                    </div>

                                    <div class="col-md-6">
                                        <label class="form-label fw-bold text-dark">Gender *</label>
                                        <select name="gender" class="form-select form-select-lg" required>
                                            <option value="" selected disabled>Select Gender</option>
                                            <option value="Male">Male</option>
                                            <option value="Female">Female</option>
                                            <option value="Other">Other</option>
                                        </select>
                                    </div>

                                    <div class="col-md-6">
                                        <label class="form-label fw-bold text-dark">Title / Post Applied For *</label>
                                        <input type="text" name="title" class="form-control form-control-lg text-only-input" placeholder="e.g. Software Developer" value="<?php echo esc_attr($prefill_title); ?>" pattern="^[A-Za-z\s'\.-]{2,100}$" title="Please enter a valid title using letters and spaces." required>
                                    </div>

                                    <div class="col-md-6">
                                        <label class="form-label fw-bold text-dark">Key Skills *</label>
                                        <input type="text" name="skills" class="form-control form-control-lg" placeholder="e.g. Java, Python, SQL" required>
                                    </div>

                                    <div class="col-md-6">
                                        <label class="form-label fw-bold text-dark">Years of Experience *</label>
                                        <input type="number" step="0.5" min="0" max="60" name="experience" class="form-control form-control-lg number-only-input" placeholder="e.g. 5" required>
                                    </div>

                                    <div class="col-md-6">
                                        <label class="form-label fw-bold text-dark">Current Salary *</label>
                                        <input type="text" name="current_salary" class="form-control form-control-lg" placeholder="e.g. 10 LPA" required>
                                    </div>

                                    <div class="col-md-6">
                                        <label class="form-label fw-bold text-dark">Expected Salary *</label>
                                        <input type="text" name="expected_salary" class="form-control form-control-lg" placeholder="e.g. 15 LPA" required>
                                    </div>

                                    <div class="col-md-6">
                                        <label class="form-label fw-bold text-dark">Notice Period (Days) *</label>
                                        <input type="number" min="0" max="365" name="notice_period" class="form-control form-control-lg number-only-input" placeholder="e.g. 30" required>
                                    </div>

                                    <div class="col-md-6">
                                        <label class="form-label fw-bold text-dark">Add Your Social Link</label>
                                        <input type="url" name="social_link" class="form-control form-control-lg" placeholder="e.g. https://linkedin.com/in/yourprofile">
                                    </div>

                                    <div class="col-md-6">
                                        <label class="form-label fw-bold text-dark">Upload Resume *</label>
                                        <input type="file" name="resume_file" class="form-control form-control-lg" accept=".pdf,.doc,.docx" required>
                                        <div class="form-text">PDF or DOCX (Max. 10MB)</div>
                                    </div>

                                    <div class="col-md-12">
                                        <label class="form-label fw-bold text-dark">Comments / Cover Note</label>
                                        <textarea name="comment" class="form-control form-control-lg" rows="4" placeholder="Add your comments..."></textarea>
                                    </div>

                                </div>

                                <!-- Submit Button -->
                                <div class="mt-4">
                                    <button type="submit" class="btn btn-primary btn-lg rounded-3 px-4" title="Submit Application">
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
    public function form($instance) {
        $title           = $instance['title'] ?? 'Application Form';
        $subtitle        = $instance['subtitle'] ?? '';
        $form_title      = $instance['form_title'] ?? 'Send us your Application';
        $recipient_email = $instance['recipient_email'] ?? 'jobs@microlink.co.in';
        ?>
        <p>
            <label>Section Title</label>
            <input class="widefat" name="<?php echo $this->get_field_name('title'); ?>" value="<?php echo esc_attr($title); ?>">
        </p>
        <p>
            <label>Section Subtitle</label>
            <textarea class="widefat" rows="2" name="<?php echo $this->get_field_name('subtitle'); ?>"><?php echo esc_textarea($subtitle); ?></textarea>
        </p>
        <p>
            <label>Form Card Heading</label>
            <input class="widefat" name="<?php echo $this->get_field_name('form_title'); ?>" value="<?php echo esc_attr($form_title); ?>">
        </p>
        <p>
            <label>Recipient Email Address</label>
            <input class="widefat" type="email" name="<?php echo $this->get_field_name('recipient_email'); ?>" value="<?php echo esc_attr($recipient_email); ?>">
        </p>
    <?php }

    // Save Data
    public function update($new_instance, $old_instance) {
        $instance = [];
        $instance['title']           = !empty($new_instance['title']) ? sanitize_text_field($new_instance['title']) : '';
        $instance['subtitle']        = !empty($new_instance['subtitle']) ? sanitize_textarea_field($new_instance['subtitle']) : '';
        $instance['form_title']      = !empty($new_instance['form_title']) ? sanitize_text_field($new_instance['form_title']) : '';
        $instance['recipient_email'] = !empty($new_instance['recipient_email']) ? sanitize_email($new_instance['recipient_email']) : 'jobs@microlink.co.in';
        return $instance;
    }
}

// Register Widget
function register_candidate_form_section_widget() {
    register_widget('Candidate_Form_Section_Widget');
}
add_action('widgets_init', 'register_candidate_form_section_widget');
