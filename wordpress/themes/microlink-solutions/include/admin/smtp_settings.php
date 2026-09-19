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
}
add_action('admin_init', 'microlink_register_smtp_settings');

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
            $subject = 'SMTP Test Email - ' . get_bloginfo('name');
            $fields  = array(
                'Status'     => 'SMTP configuration is working correctly!',
                'Tested On'  => current_time('mysql'),
                'Site URL'   => get_site_url(),
            );
            $message = custom_get_styled_email_template('SMTP Test Email', $fields, 'Microlink Solutions SMTP Test');
            $headers = array('Content-Type: text/html; charset=UTF-8');

            $sent = wp_mail($test_to, $subject, $message, $headers);
            if ($sent) {
                $test_email_status = '<div class="notice notice-success is-dismissible"><p>Test email sent successfully to <strong>' . esc_html($test_to) . '</strong>!</p></div>';
            } else {
                global $ts_mail_errors, $phpmailer;
                $err = isset($ts_mail_errors) ? implode(', ', (array)$ts_mail_errors) : '';
                if (empty($err) && isset($phpmailer->ErrorInfo)) {
                    $err = $phpmailer->ErrorInfo;
                }
                $test_email_status = '<div class="notice notice-error is-dismissible"><p>Failed to send test email. Error: ' . esc_html($err ?: 'Unknown error') . '</p></div>';
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
    if ($from_email === 'pnaresh776@gmail.com') {
        $from_email = 'info@microlink.co.in';
    }

    $from_name  = get_option('microlink_smtp_from_name', get_bloginfo('name'));
    ?>
    <div class="wrap">
        <h1><span class="dashicons dashicons-email-alt" style="font-size:32px; width:32px; height:32px;"></span> <?php _e('SMTP Details & Email Settings', _THEME_DOMAIN); ?></h1>
        <p><?php _e('Configure SMTP server parameters to reliably send form notifications and system emails.', _THEME_DOMAIN); ?></p>

        <?php echo $test_email_status; ?>

        <div style="display: flex; gap: 20px; margin-top: 20px; flex-wrap: wrap;">
            <div style="flex: 2; min-width: 320px; background: #fff; padding: 20px; border: 1px solid #ccd0d4; border-radius: 8px; box-shadow: 0 1px 3px rgba(0,0,0,0.05);">
                <form method="post" action="options.php">
                    <?php
                    settings_fields('microlink_smtp_options_group');
                    do_settings_sections('microlink_smtp_options_group');
                    ?>
                    <table class="form-table" role="presentation">
                        <tr>
                            <th scope="row"><label for="microlink_smtp_host"><?php _e('SMTP Host', _THEME_DOMAIN); ?></label></th>
                            <td>
                                <input name="microlink_smtp_host" type="text" id="microlink_smtp_host" value="<?php echo esc_attr($host); ?>" class="regular-text" placeholder="e.g. smtp.gmail.com or mail.domain.com" required>
                                <p class="description"><?php _e('Your outgoing SMTP mail server address.', _THEME_DOMAIN); ?></p>
                            </td>
                        </tr>

                        <tr>
                            <th scope="row"><label for="microlink_smtp_encryption"><?php _e('Encryption Type', _THEME_DOMAIN); ?></label></th>
                            <td>
                                <select name="microlink_smtp_encryption" id="microlink_smtp_encryption">
                                    <option value="none" <?php selected($encryption, 'none'); ?>><?php _e('None (No Encryption)', _THEME_DOMAIN); ?></option>
                                    <option value="ssl" <?php selected($encryption, 'ssl'); ?>><?php _e('SSL', _THEME_DOMAIN); ?></option>
                                    <option value="tls" <?php selected($encryption, 'tls'); ?>><?php _e('TLS (Recommended)', _THEME_DOMAIN); ?></option>
                                </select>
                            </td>
                        </tr>

                        <tr>
                            <th scope="row"><label for="microlink_smtp_port"><?php _e('SMTP Port', _THEME_DOMAIN); ?></label></th>
                            <td>
                                <input name="microlink_smtp_port" type="number" id="microlink_smtp_port" value="<?php echo esc_attr($port); ?>" class="small-text" placeholder="587" required>
                                <p class="description"><?php _e('Common ports: 587 (TLS), 465 (SSL), 25 (Plain).', _THEME_DOMAIN); ?></p>
                            </td>
                        </tr>

                        <tr>
                            <th scope="row"><label for="microlink_smtp_username"><?php _e('SMTP Username', _THEME_DOMAIN); ?></label></th>
                            <td>
                                <input name="microlink_smtp_username" type="text" id="microlink_smtp_username" value="<?php echo esc_attr($username); ?>" class="regular-text" autocomplete="off">
                            </td>
                        </tr>

                        <tr>
                            <th scope="row"><label for="microlink_smtp_password"><?php _e('SMTP Password', _THEME_DOMAIN); ?></label></th>
                            <td>
                                <input name="microlink_smtp_password" type="password" id="microlink_smtp_password" value="<?php echo esc_attr($password); ?>" class="regular-text" autocomplete="new-password">
                            </td>
                        </tr>

                        <tr>
                            <th scope="row"><label for="microlink_smtp_from_email"><?php _e('From Email Address', _THEME_DOMAIN); ?></label></th>
                            <td>
                                <input name="microlink_smtp_from_email" type="email" id="microlink_smtp_from_email" value="<?php echo esc_attr($from_email); ?>" class="regular-text" required>
                                <p class="description"><?php _e('Email address used as sender in sent messages.', _THEME_DOMAIN); ?></p>
                            </td>
                        </tr>

                        <tr>
                            <th scope="row"><label for="microlink_smtp_from_name"><?php _e('From Name', _THEME_DOMAIN); ?></label></th>
                            <td>
                                <input name="microlink_smtp_from_name" type="text" id="microlink_smtp_from_name" value="<?php echo esc_attr($from_name); ?>" class="regular-text" required>
                            </td>
                        </tr>
                    </table>

                    <?php submit_button(__('Save SMTP Settings', _THEME_DOMAIN)); ?>
                </form>
            </div>

            <div style="flex: 1; min-width: 280px; background: #fff; padding: 20px; border: 1px solid #ccd0d4; border-radius: 8px; height: fit-content; box-shadow: 0 1px 3px rgba(0,0,0,0.05);">
                <h2><span class="dashicons dashicons-email-alt2"></span> <?php _e('Send Test Email', _THEME_DOMAIN); ?></h2>
                <p><?php _e('Verify your SMTP configuration by sending a test email to any recipient.', _THEME_DOMAIN); ?></p>
                
                <form method="post" action="">
                    <?php wp_nonce_field('microlink_test_email_nonce'); ?>
                    <p>
                        <label for="test_email_to"><strong><?php _e('Recipient Email:', _THEME_DOMAIN); ?></strong></label><br>
                        <input type="email" name="test_email_to" id="test_email_to" class="widefat" value="<?php echo esc_attr(wp_get_current_user()->user_email); ?>" required>
                    </p>
                    <p>
                        <input type="submit" name="send_test_email" class="button button-secondary" value="<?php _e('Send Test Email Now', _THEME_DOMAIN); ?>">
                    </p>
                </form>
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
    $from_email = get_option('microlink_smtp_from_email');
    $from_name  = get_option('microlink_smtp_from_name');

    if (!empty($host)) {
        $phpmailer->isSMTP();
        $phpmailer->Host       = $host;
        $phpmailer->Port       = !empty($port) ? intval($port) : 587;
        
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
        }
    }
}
add_action('phpmailer_init', 'microlink_configure_phpmailer');
