<?php
/**
 * SMTP Configuration Admin Page and WP Mailer hook
 */

if (!defined('ABSPATH')) {
    exit;
}

// Add Admin Menu Page
function microlink_add_smtp_settings_menu() {
    add_submenu_page(
        'edit.php?post_type=contact_submission',
        __('SMTP Settings', _THEME_DOMAIN),
        __('SMTP Settings', _THEME_DOMAIN),
        'manage_options',
        'microlink-smtp-settings',
        'microlink_render_smtp_settings_page'
    );
}
add_action('admin_menu', 'microlink_add_smtp_settings_menu');

// Register SMTP Settings
function microlink_register_smtp_settings() {
    register_setting('microlink_smtp_options_group', 'microlink_smtp_host', 'sanitize_text_field');
    register_setting('microlink_smtp_options_group', 'microlink_smtp_port', 'absint');
    register_setting('microlink_smtp_options_group', 'microlink_smtp_encryption', 'sanitize_text_field');
    register_setting('microlink_smtp_options_group', 'microlink_smtp_username', 'sanitize_text_field');
    register_setting('microlink_smtp_options_group', 'microlink_smtp_password', 'sanitize_text_field');
    register_setting('microlink_smtp_options_group', 'microlink_smtp_from_email', 'sanitize_email');
    register_setting('microlink_smtp_options_group', 'microlink_smtp_from_name', 'sanitize_text_field');
    register_setting('microlink_smtp_options_group', 'microlink_admin_notification_email', 'sanitize_text_field');
}
add_action('admin_init', 'microlink_register_smtp_settings');

// Capture wp_mail errors for troubleshooting
function microlink_capture_mail_failure($wp_error) {
    if (is_wp_error($wp_error)) {
        update_option('microlink_last_mail_error', array(
            'time'    => current_time('mysql'),
            'message' => $wp_error->get_error_message(),
            'data'    => $wp_error->get_error_data(),
        ));
    }
}
add_action('wp_mail_failed', 'microlink_capture_mail_failure');

// Helper to retrieve the latest mail error message
function microlink_get_last_mail_error() {
    global $phpmailer;
    $err = '';
    if (!empty($phpmailer) && !empty($phpmailer->ErrorInfo)) {
        $err = trim($phpmailer->ErrorInfo);
    }
    if (empty($err)) {
        $last_err = get_option('microlink_last_mail_error');
        if (!empty($last_err['message'])) {
            $err = trim($last_err['message']);
        }
    }
    return !empty($err) ? $err : __('Mail delivery error (SMTP connection or rejection)', _THEME_DOMAIN);
}


// Ensure WordPress core From and From Name match SMTP settings
function microlink_filter_wp_mail_from($default_from) {
    $from_email = get_option('microlink_smtp_from_email');
    return (!empty($from_email) && is_email($from_email)) ? $from_email : $default_from;
}
add_filter('wp_mail_from', 'microlink_filter_wp_mail_from');

function microlink_filter_wp_mail_from_name($default_name) {
    $from_name = get_option('microlink_smtp_from_name');
    return !empty($from_name) ? $from_name : $default_name;
}
add_filter('wp_mail_from_name', 'microlink_filter_wp_mail_from_name');

// Render Admin Settings Form
function microlink_render_smtp_settings_page() {
    if (!current_user_can('manage_options')) {
        return;
    }

    // Handle test email action
    $test_email_status = '';
    if (isset($_POST['send_test_email']) && check_admin_referer('microlink_test_email_nonce')) {
        $test_to = sanitize_email($_POST['test_email_to']);
        if (is_email($test_to)) {
            $from_email = get_option('microlink_smtp_from_email', 'info@microlink.co.in');
            $from_name  = get_option('microlink_smtp_from_name', get_bloginfo('name'));

            $subject = 'SMTP Test Email - ' . get_bloginfo('name');
            $fields  = array(
                'Status'     => 'SMTP configuration is working correctly!',
                'Tested On'  => current_time('mysql'),
                'Site URL'   => get_site_url(),
                'Sent To'    => $test_to,
                'Sent From'  => $from_name . ' <' . $from_email . '>',
            );
            $message = custom_get_styled_email_template('SMTP Test Email', $fields, 'Microlink Solutions SMTP Test');
            $headers = array(
                'Content-Type: text/html; charset=UTF-8',
                'From: ' . $from_name . ' <' . $from_email . '>',
            );

            // Hook temporary debug output collector
            $GLOBALS['microlink_smtp_debug_output'] = '';
            $debug_callback = function($phpmailer) {
                $phpmailer->SMTPDebug = 2;
                $phpmailer->Debugoutput = function($str, $level) {
                    $GLOBALS['microlink_smtp_debug_output'] .= esc_html(trim($str)) . "\n";
                };
            };
            add_action('phpmailer_init', $debug_callback);

            $sent = wp_mail($test_to, $subject, $message, $headers);
            remove_action('phpmailer_init', $debug_callback);

            if ($sent) {
                $test_email_status = '<div class="notice notice-success is-dismissible"><p><strong>Success!</strong> Test email sent successfully to <strong>' . esc_html($test_to) . '</strong>!</p></div>';
            } else {
                global $phpmailer;
                $err = isset($phpmailer->ErrorInfo) ? $phpmailer->ErrorInfo : '';
                if (empty($err)) {
                    $last_err = get_option('microlink_last_mail_error');
                    if (!empty($last_err['message'])) {
                        $err = $last_err['message'];
                    }
                }
                $debug_log = !empty($GLOBALS['microlink_smtp_debug_output']) ? '<pre style="max-height:220px; overflow:auto; background:#212529; color:#f8f9fa; padding:12px; border-radius:6px; font-size:12px; margin-top:10px;">' . $GLOBALS['microlink_smtp_debug_output'] . '</pre>' : '';
                $test_email_status = '<div class="notice notice-error is-dismissible"><p><strong>Failed to send test email.</strong> Error: ' . esc_html($err ?: 'Unknown error') . '</p>' . $debug_log . '</div>';
            }
        } else {
            $test_email_status = '<div class="notice notice-warning is-dismissible"><p>Please enter a valid email address for testing.</p></div>';
        }
    }

    $host       = get_option('microlink_smtp_host', '');
    $port       = get_option('microlink_smtp_port', '587');
    $encryption = get_option('microlink_smtp_encryption', 'tls');
    $username   = get_option('microlink_smtp_username', '');
    $password   = get_option('microlink_smtp_password', '');
    $from_email = get_option('microlink_smtp_from_email', 'info@microlink.co.in');
    $from_name  = get_option('microlink_smtp_from_name', get_bloginfo('name'));
    $admin_notify_email = get_option('microlink_admin_notification_email', 'info@microlink.co.in');

    $last_error = get_option('microlink_last_mail_error');
    ?>
    <div class="wrap">
        <h1><span class="dashicons dashicons-email-alt" style="font-size:32px; width:32px; height:32px;"></span> <?php _e('SMTP Details & Email Settings', _THEME_DOMAIN); ?></h1>
        <p><?php _e('Configure SMTP server parameters to reliably send form notifications and system emails.', _THEME_DOMAIN); ?></p>

        <?php echo $test_email_status; ?>

        <?php if (empty($host)): ?>
            <div class="notice notice-warning">
                <p><strong><span class="dashicons dashicons-warning"></span> SMTP is currently not configured!</strong> Outgoing emails are currently sent via PHP mail() which fails SPF/DMARC checks for <code>microlink.co.in</code>. Please fill in the SMTP details below and save.</p>
            </div>
        <?php endif; ?>

        <div style="display: flex; gap: 20px; margin-top: 20px; flex-wrap: wrap;">
            <div style="flex: 2; min-width: 320px; background: #fff; padding: 20px; border: 1px solid #ccd0d4; border-radius: 8px; box-shadow: 0 1px 3px rgba(0,0,0,0.05);">
                <form method="post" action="options.php">
                    <?php
                    settings_fields('microlink_smtp_options_group');
                    do_settings_sections('microlink_smtp_options_group');
                    ?>
                    <table class="form-table" role="presentation">
                        <tr>
                            <th scope="row"><label for="microlink_smtp_host"><?php _e('SMTP Host', _THEME_DOMAIN); ?> *</label></th>
                            <td>
                                <input name="microlink_smtp_host" type="text" id="microlink_smtp_host" value="<?php echo esc_attr($host); ?>" class="regular-text" placeholder="e.g. hostmx01.logix.in or smtp.office365.com" required>
                                <p class="description"><?php _e('Your outgoing SMTP mail server address.', _THEME_DOMAIN); ?></p>
                            </td>
                        </tr>

                        <tr>
                            <th scope="row"><label for="microlink_smtp_encryption"><?php _e('Encryption Type', _THEME_DOMAIN); ?></label></th>
                            <td>
                                <select name="microlink_smtp_encryption" id="microlink_smtp_encryption">
                                    <option value="none" <?php selected($encryption, 'none'); ?>><?php _e('None (No Encryption)', _THEME_DOMAIN); ?></option>
                                    <option value="ssl" <?php selected($encryption, 'ssl'); ?>><?php _e('SSL (Port 465)', _THEME_DOMAIN); ?></option>
                                    <option value="tls" <?php selected($encryption, 'tls'); ?>><?php _e('TLS / STARTTLS (Port 587 - Recommended)', _THEME_DOMAIN); ?></option>
                                </select>
                            </td>
                        </tr>

                        <tr>
                            <th scope="row"><label for="microlink_smtp_port"><?php _e('SMTP Port', _THEME_DOMAIN); ?> *</label></th>
                            <td>
                                <input name="microlink_smtp_port" type="number" id="microlink_smtp_port" value="<?php echo esc_attr($port); ?>" class="small-text" placeholder="587" required>
                                <p class="description"><?php _e('Common ports: 587 (TLS), 465 (SSL), 25 (Plain).', _THEME_DOMAIN); ?></p>
                            </td>
                        </tr>

                        <tr>
                            <th scope="row"><label for="microlink_smtp_username"><?php _e('SMTP Username', _THEME_DOMAIN); ?></label></th>
                            <td>
                                <input name="microlink_smtp_username" type="text" id="microlink_smtp_username" value="<?php echo esc_attr($username); ?>" class="regular-text" placeholder="e.g. info@microlink.co.in" autocomplete="off">
                                <p class="description"><?php _e('Your full email address or SMTP username.', _THEME_DOMAIN); ?></p>
                            </td>
                        </tr>

                        <tr>
                            <th scope="row"><label for="microlink_smtp_password"><?php _e('SMTP Password', _THEME_DOMAIN); ?></label></th>
                            <td>
                                <input name="microlink_smtp_password" type="password" id="microlink_smtp_password" value="<?php echo esc_attr($password); ?>" class="regular-text" autocomplete="new-password">
                                <p class="description"><?php _e('Your email account password or app-specific password.', _THEME_DOMAIN); ?></p>
                            </td>
                        </tr>

                        <tr>
                            <th scope="row"><label for="microlink_smtp_from_email"><?php _e('From Email Address', _THEME_DOMAIN); ?> *</label></th>
                            <td>
                                <input name="microlink_smtp_from_email" type="email" id="microlink_smtp_from_email" value="<?php echo esc_attr($from_email); ?>" class="regular-text" placeholder="info@microlink.co.in" required>
                                <p class="description"><?php _e('Outgoing sender address. Must match your SMTP authenticated account or SPF authorized domain.', _THEME_DOMAIN); ?></p>
                            </td>
                        </tr>

                        <tr>
                            <th scope="row"><label for="microlink_smtp_from_name"><?php _e('From Name', _THEME_DOMAIN); ?> *</label></th>
                            <td>
                                <input name="microlink_smtp_from_name" type="text" id="microlink_smtp_from_name" value="<?php echo esc_attr($from_name); ?>" class="regular-text" required>
                                <p class="description"><?php _e('Display name in recipient email inbox (e.g. Microlink Solutions).', _THEME_DOMAIN); ?></p>
                            </td>
                        </tr>

                        <tr>
                            <th scope="row"><label for="microlink_admin_notification_email"><?php _e('Admin Notification Recipient(s)', _THEME_DOMAIN); ?></label></th>
                            <td>
                                <input name="microlink_admin_notification_email" type="text" id="microlink_admin_notification_email" value="<?php echo esc_attr($admin_notify_email); ?>" class="regular-text" placeholder="info@microlink.co.in">
                                <p class="description"><?php _e('Recipient email for contact inquiries. Separate multiple addresses with commas.', _THEME_DOMAIN); ?></p>
                            </td>
                        </tr>
                    </table>

                    <?php submit_button(__('Save SMTP Settings', _THEME_DOMAIN)); ?>
                </form>
            </div>

            <div style="flex: 1; min-width: 280px; display: flex; flex-direction: column; gap: 20px;">
                <div style="background: #fff; padding: 20px; border: 1px solid #ccd0d4; border-radius: 8px; box-shadow: 0 1px 3px rgba(0,0,0,0.05);">
                    <h2><span class="dashicons dashicons-email-alt2"></span> <?php _e('Send Test Email', _THEME_DOMAIN); ?></h2>
                    <p><?php _e('Verify your SMTP configuration by sending a test email to any recipient.', _THEME_DOMAIN); ?></p>
                    
                    <form method="post" action="">
                        <?php wp_nonce_field('microlink_test_email_nonce'); ?>
                        <p>
                            <label for="test_email_to"><strong><?php _e('Recipient Email:', _THEME_DOMAIN); ?></strong></label><br>
                            <input type="email" name="test_email_to" id="test_email_to" class="widefat" value="<?php echo esc_attr(wp_get_current_user()->user_email); ?>" required>
                        </p>
                        <p>
                            <input type="submit" name="send_test_email" class="button button-primary" value="<?php _e('Send Test Email Now', _THEME_DOMAIN); ?>">
                        </p>
                    </form>
                </div>

                <div style="background: #fdfdfd; padding: 18px; border: 1px solid #ccd0d4; border-radius: 8px; font-size: 13px; line-height: 1.5;">
                    <h3 style="margin-top: 0;"><span class="dashicons dashicons-shield"></span> SPF & DMARC Information</h3>
                    <p style="margin-bottom: 8px;"><strong>microlink.co.in</strong> has an active DMARC policy (<code>p=quarantine</code>) and SPF record:</p>
                    <code style="display:block; padding:6px; background:#edf2f7; border-radius:4px; font-size:11px; word-break:break-all; margin-bottom:10px;">include:_spfnew.logix.in include:spf.protection.outlook.com include:sendgrid.net</code>
                    <p style="margin: 0; color: #495057;">Emails sent without authenticating through one of these authorized providers will be quarantined or rejected by receiving mail servers.</p>
                </div>

                <?php if (!empty($last_error)): ?>
                    <div style="background: #fff8f8; padding: 18px; border: 1px solid #f5c2c7; border-radius: 8px; font-size: 13px;">
                        <h4 style="margin-top: 0; color: #842029;"><span class="dashicons dashicons-warning"></span> Last Email Error Detected</h4>
                        <p style="margin: 0 0 5px; color: #842029;"><strong>Time:</strong> <?php echo esc_html($last_error['time'] ?? 'Unknown'); ?></p>
                        <p style="margin: 0; color: #842029;"><strong>Error:</strong> <?php echo esc_html($last_error['message'] ?? 'Unknown'); ?></p>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
    <?php
}

// Hook into phpmailer_init to apply saved SMTP configuration
function microlink_configure_phpmailer($phpmailer) {
    $host       = get_option('microlink_smtp_host');
    $port       = get_option('microlink_smtp_port');
    $encryption = get_option('microlink_smtp_encryption');
    $username   = get_option('microlink_smtp_username');
    $password   = get_option('microlink_smtp_password');
    $from_email = get_option('microlink_smtp_from_email', 'info@microlink.co.in');
    $from_name  = get_option('microlink_smtp_from_name');

    if (!empty($host)) {
        $phpmailer->isSMTP();
        $phpmailer->Host       = $host;
        $phpmailer->Port       = !empty($port) ? intval($port) : 587;
        $phpmailer->Timeout    = 20;

        // OpenSSL SSL/TLS configuration to avoid handshake failures on self-signed or shared host certificates
        $phpmailer->SMTPOptions = array(
            'ssl' => array(
                'verify_peer'       => false,
                'verify_peer_name'  => false,
                'allow_self_signed' => true,
            ),
        );
        
        if (!empty($username)) {
            $phpmailer->SMTPAuth = true;
            $phpmailer->Username = $username;
            $phpmailer->Password = $password;
        } else {
            $phpmailer->SMTPAuth = false;
        }

        if ($encryption === 'ssl') {
            $phpmailer->SMTPSecure = 'ssl';
        } elseif ($encryption === 'tls') {
            $phpmailer->SMTPSecure = 'tls';
        } else {
            $phpmailer->SMTPSecure = '';
            $phpmailer->SMTPAutoTLS = false;
        }

        if (!empty($from_email)) {
            $phpmailer->From     = $from_email;
            $phpmailer->FromName = !empty($from_name) ? $from_name : get_bloginfo('name');
            // Crucial for SPF/DMARC: envelope sender must match the authenticated sender
            $phpmailer->Sender   = $from_email;
        }
    }
}
add_action('phpmailer_init', 'microlink_configure_phpmailer');
