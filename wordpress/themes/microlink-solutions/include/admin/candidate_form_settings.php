<?php
/**
 * Candidate Application Form Settings Admin Page
 *
 * @package microlink-solutions
 */

if (!defined('ABSPATH')) {
    exit;
}

// Add Admin Menu Page
function microlink_add_candidate_form_settings_menu() {
    // Add under Jobs CPT menu
    add_submenu_page(
        'edit.php?post_type=job',
        __('Application Form Settings', _THEME_DOMAIN),
        __('Application Form Settings', _THEME_DOMAIN),
        'manage_options',
        'microlink-candidate-form-settings',
        'microlink_render_candidate_form_settings_page'
    );

    // Also register under Settings menu for easy discoverability
    add_options_page(
        __('Candidate Form Settings', _THEME_DOMAIN),
        __('Candidate Application Form', _THEME_DOMAIN),
        'manage_options',
        'microlink-candidate-form-settings',
        'microlink_render_candidate_form_settings_page'
    );
}
add_action('admin_menu', 'microlink_add_candidate_form_settings_menu');

// Enqueue WP Media Uploader for Banner Selection
function microlink_candidate_form_admin_scripts($hook) {
    if (isset($_GET['page']) && $_GET['page'] === 'microlink-candidate-form-settings') {
        wp_enqueue_media();
    }
}
add_action('admin_enqueue_scripts', 'microlink_candidate_form_admin_scripts');

// Register Settings
function microlink_register_candidate_form_settings() {
    register_setting('microlink_candidate_form_group', 'candidate_form_title', [
        'type'              => 'string',
        'sanitize_callback' => 'sanitize_text_field',
        'default'           => 'Application Form',
    ]);

    register_setting('microlink_candidate_form_group', 'candidate_form_subtitle', [
        'type'              => 'string',
        'sanitize_callback' => 'sanitize_textarea_field',
        'default'           => 'Take the next step in your career with Microlink. Fill out the application details below and our recruitment team will review your profile.',
    ]);

    register_setting('microlink_candidate_form_group', 'candidate_form_heading', [
        'type'              => 'string',
        'sanitize_callback' => 'sanitize_text_field',
        'default'           => 'Send us your Application',
    ]);

    register_setting('microlink_candidate_form_group', 'candidate_form_recipient_email', [
        'type'              => 'string',
        'sanitize_callback' => 'sanitize_email',
        'default'           => 'jobs@microlink.co.in',
    ]);

    register_setting('microlink_candidate_form_group', 'candidate_form_banner_title', [
        'type'              => 'string',
        'sanitize_callback' => 'sanitize_text_field',
        'default'           => 'Application Form',
    ]);

    register_setting('microlink_candidate_form_group', 'candidate_form_banner_image', [
        'type'              => 'string',
        'sanitize_callback' => 'esc_url_raw',
        'default'           => '',
    ]);
}
add_action('admin_init', 'microlink_register_candidate_form_settings');

// Render Admin Settings Page
function microlink_render_candidate_form_settings_page() {
    if (!current_user_can('manage_options')) {
        return;
    }

    $title           = get_option('candidate_form_title', 'Application Form');
    $subtitle        = get_option('candidate_form_subtitle', 'Take the next step in your career with Microlink. Fill out the application details below and our recruitment team will review your profile.');
    $form_heading    = get_option('candidate_form_heading', 'Send us your Application');
    $recipient_email = get_option('candidate_form_recipient_email', 'jobs@microlink.co.in');
    $banner_title    = get_option('candidate_form_banner_title', 'Application Form');
    $banner_image    = get_option('candidate_form_banner_image', '');

    $candidate_page_url = home_url('/candidate-form');
    ?>
    <div class="wrap">
        <h1>
            <span class="dashicons dashicons-id-alt" style="font-size:32px; width:32px; height:32px;"></span>
            <?php _e('Candidate Application Form Settings', _THEME_DOMAIN); ?>
        </h1>
        <p><?php _e('Manage candidate application page headings, content, banner image, and recipient email address.', _THEME_DOMAIN); ?></p>

        <?php settings_errors(); ?>

        <div style="display:flex; gap:25px; margin-top:20px; flex-wrap:wrap;">
            <!-- Main Settings Form -->
            <div style="flex:2; min-width:340px; background:#fff; padding:25px; border:1px solid #ccd0d4; border-radius:8px; box-shadow:0 1px 3px rgba(0,0,0,0.05);">
                <form method="post" action="options.php">
                    <?php
                    settings_fields('microlink_candidate_form_group');
                    do_settings_sections('microlink_candidate_form_group');
                    ?>

                    <h2 style="margin-top:0; border-bottom:1px solid #eee; padding-bottom:10px;">
                        <span class="dashicons dashicons-text-page"></span> <?php _e('Form Content & Headings', _THEME_DOMAIN); ?>
                    </h2>

                    <table class="form-table" role="presentation">
                        <tr>
                            <th scope="row"><label for="candidate_form_title"><?php _e('Section Title', _THEME_DOMAIN); ?> *</label></th>
                            <td>
                                <input name="candidate_form_title" type="text" id="candidate_form_title" value="<?php echo esc_attr($title); ?>" class="regular-text" style="width:100%; max-width:550px;" required>
                                <p class="description"><?php _e('Main heading displayed on the candidate application section (e.g. Application Form).', _THEME_DOMAIN); ?></p>
                            </td>
                        </tr>

                        <tr>
                            <th scope="row"><label for="candidate_form_subtitle"><?php _e('Section Subtitle / Description', _THEME_DOMAIN); ?></label></th>
                            <td>
                                <textarea name="candidate_form_subtitle" id="candidate_form_subtitle" rows="3" class="regular-text" style="width:100%; max-width:550px;"><?php echo esc_textarea($subtitle); ?></textarea>
                                <p class="description"><?php _e('Introduction paragraph displayed beneath the section title.', _THEME_DOMAIN); ?></p>
                            </td>
                        </tr>

                        <tr>
                            <th scope="row"><label for="candidate_form_heading"><?php _e('Form Box Title', _THEME_DOMAIN); ?> *</label></th>
                            <td>
                                <input name="candidate_form_heading" type="text" id="candidate_form_heading" value="<?php echo esc_attr($form_heading); ?>" class="regular-text" style="width:100%; max-width:550px;" required>
                                <p class="description"><?php _e('Card heading displayed immediately above the application form fields (e.g. Send us your Application).', _THEME_DOMAIN); ?></p>
                            </td>
                        </tr>

                        <tr>
                            <th scope="row"><label for="candidate_form_recipient_email"><?php _e('Recipient Email Address', _THEME_DOMAIN); ?> *</label></th>
                            <td>
                                <input name="candidate_form_recipient_email" type="email" id="candidate_form_recipient_email" value="<?php echo esc_attr($recipient_email); ?>" class="regular-text" style="width:100%; max-width:550px;" required>
                                <p class="description"><?php _e('Where submitted candidate applications and resumes will be sent (e.g. jobs@microlink.co.in).', _THEME_DOMAIN); ?></p>
                            </td>
                        </tr>
                    </table>

                    <h2 style="margin-top:30px; border-bottom:1px solid #eee; padding-bottom:10px;">
                        <span class="dashicons dashicons-format-image"></span> <?php _e('Banner Settings', _THEME_DOMAIN); ?>
                    </h2>

                    <table class="form-table" role="presentation">
                        <tr>
                            <th scope="row"><label for="candidate_form_banner_title"><?php _e('Banner Title', _THEME_DOMAIN); ?></label></th>
                            <td>
                                <input name="candidate_form_banner_title" type="text" id="candidate_form_banner_title" value="<?php echo esc_attr($banner_title); ?>" class="regular-text" style="width:100%; max-width:550px;">
                                <p class="description"><?php _e('Title displayed inside the top inner banner and breadcrumb navigation.', _THEME_DOMAIN); ?></p>
                            </td>
                        </tr>

                        <tr>
                            <th scope="row"><label for="candidate_form_banner_image"><?php _e('Banner Image URL', _THEME_DOMAIN); ?></label></th>
                            <td>
                                <div style="display:flex; gap:10px; align-items:center; max-width:550px;">
                                    <input name="candidate_form_banner_image" type="text" id="candidate_form_banner_image" value="<?php echo esc_attr($banner_image); ?>" class="regular-text" style="flex:1;" placeholder="<?php echo esc_attr(get_template_directory_uri() . '/assets/images/i-banner.jpg'); ?>">
                                    <button type="button" class="button button-secondary" id="upload_candidate_banner_btn">
                                        📁 <?php _e('Media Gallery', _THEME_DOMAIN); ?>
                                    </button>
                                </div>
                                <p class="description"><?php _e('Optional custom banner image (1920x500 recommended). Leave blank to use default banner.', _THEME_DOMAIN); ?></p>
                                
                                <div id="candidate_banner_preview" style="margin-top:10px; max-width:320px; <?php echo empty($banner_image) ? 'display:none;' : ''; ?>">
                                    <img src="<?php echo esc_url($banner_image); ?>" style="width:100%; height:auto; border-radius:6px; border:1px solid #ddd;" alt="Banner Preview">
                                </div>
                            </td>
                        </tr>
                    </table>

                    <?php submit_button(__('Save Settings', _THEME_DOMAIN), 'primary', 'submit', true, ['style' => 'margin-top:20px; padding:6px 24px; font-size:15px;']); ?>
                </form>
            </div>

            <!-- Quick Information & Preview Box -->
            <div style="flex:1; min-width:280px; max-width:380px;">
                <div style="background:#fff; padding:20px; border:1px solid #ccd0d4; border-radius:8px; box-shadow:0 1px 3px rgba(0,0,0,0.05); margin-bottom:20px;">
                    <h3 style="margin-top:0; border-bottom:1px solid #eee; padding-bottom:10px;">
                        <span class="dashicons dashicons-admin-links"></span> <?php _e('Candidate Page Link', _THEME_DOMAIN); ?>
                    </h3>
                    <p><?php _e('Candidate application form is rendered on the dedicated page template:', _THEME_DOMAIN); ?></p>
                    <p>
                        <a href="<?php echo esc_url($candidate_page_url); ?>" target="_blank" class="button button-secondary" style="width:100%; text-align:center;">
                            🔗 <?php _e('View Live Application Page', _THEME_DOMAIN); ?>
                        </a>
                    </p>
                </div>

                <div style="background:#f8f9fa; padding:20px; border:1px solid #e2e8f0; border-radius:8px;">
                    <h3 style="margin-top:0; color:#1e293b;">
                        <span class="dashicons dashicons-info"></span> <?php _e('Form Submissions', _THEME_DOMAIN); ?>
                    </h3>
                    <ul style="margin:0; padding-left:18px; color:#475569; font-size:13px; line-height:1.6;">
                        <li><strong><?php _e('Uploaded Resumes:', _THEME_DOMAIN); ?></strong> <?php _e('PDF and DOCX attachments are directly attached to incoming emails.', _THEME_DOMAIN); ?></li>
                        <li><strong><?php _e('Email Delivery:', _THEME_DOMAIN); ?></strong> <?php _e('Ensure SMTP Settings are configured under WP Admin -> Contact Submissions -> SMTP Settings for 100% reliable inbox delivery.', _THEME_DOMAIN); ?></li>
                        <li><strong><?php _e('Form Validation:', _THEME_DOMAIN); ?></strong> <?php _e('Full Name, Email, Phone, and Resume file are strictly validated before submission.', _THEME_DOMAIN); ?></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <script>
    jQuery(document).ready(function($) {
        $('#upload_candidate_banner_btn').on('click', function(e) {
            e.preventDefault();
            var custom_uploader = wp.media({
                title: '<?php _e('Select Candidate Page Banner', _THEME_DOMAIN); ?>',
                button: { text: '<?php _e('Use this Banner', _THEME_DOMAIN); ?>' },
                multiple: false
            }).on('select', function() {
                var attachment = custom_uploader.state().get('selection').first().toJSON();
                $('#candidate_form_banner_image').val(attachment.url);
                $('#candidate_banner_preview img').attr('src', attachment.url);
                $('#candidate_banner_preview').show();
            }).open();
        });

        $('#candidate_form_banner_image').on('input change', function() {
            var val = $(this).val().trim();
            if (val) {
                $('#candidate_banner_preview img').attr('src', val);
                $('#candidate_banner_preview').show();
            } else {
                $('#candidate_banner_preview').hide();
            }
        });
    });
    </script>
    <?php
}
