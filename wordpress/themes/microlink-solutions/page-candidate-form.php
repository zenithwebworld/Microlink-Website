<?php
/**
 * Template Name: Candidate Application Form
 *
 * @package microlink-solutions
 */

get_header();

$title           = get_option('candidate_form_title', 'Application Form');
$subtitle        = get_option('candidate_form_subtitle', 'Take the next step in your career with Microlink. Fill out the application details below and our recruitment team will review your profile.');
$form_title      = get_option('candidate_form_heading', 'Send us your Application');
$recipient_email = get_option('candidate_form_recipient_email', 'jobs@microlink.co.in');

$banner_title    = get_option('candidate_form_banner_title', 'Application Form');
$banner_image    = get_option('candidate_form_banner_image', '');
$banner_image    = !empty($banner_image) ? $banner_image : get_template_directory_uri() . '/assets/images/i-banner.jpg';
?>

<!-- Banner Section -->
<section class="innerbanner-section">
    <div class="video-thumb">
        <div class="thumbnail-container object-fit">
            <div class="thumbnail">
                <img src="<?php echo esc_url($banner_image); ?>" alt="<?php echo esc_attr($banner_title); ?>" width="1920" height="500">
            </div>
        </div>
        <div class="caption">
            <div class="container">
                <div class="row">
                    <div class="col-lg-8">
                        <h1 class="cm-title text-white"><?php echo esc_html($banner_title); ?></h1>
                        <div class="breadcrumb-nav mt-3">
                            <a href="<?php echo esc_url(home_url('/')); ?>" class="text-white" title="Home">Home</a>
                            <span class="text-white mx-2">-</span>
                            <a href="<?php echo esc_url(home_url('/career')); ?>" class="text-white" title="Career">Career</a>
                            <span class="text-white mx-2">-</span>
                            <span class="text-white"><?php echo esc_html($banner_title); ?></span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Dynamic Form Widget Area -->
<?php
the_widget('Candidate_Form_Section_Widget', [
    'title'           => $title,
    'subtitle'        => $subtitle,
    'form_title'      => $form_title,
    'recipient_email' => $recipient_email
]);
?>

<?php get_footer(); ?>
