<?php
/**
 * Template Name: Candidate Application Form
 *
 * @package microlink-solutions
 */

get_header();
?>

<!-- Banner Section -->
<section class="innerbanner-section">
    <div class="video-thumb">
        <div class="thumbnail-container object-fit">
            <div class="thumbnail">
                <img src="<?php echo esc_url(get_template_directory_uri() . '/assets/images/i-banner.jpg'); ?>" alt="Application Form" width="1920" height="500">
            </div>
        </div>
        <div class="caption">
            <div class="container">
                <div class="row">
                    <div class="col-lg-8">
                        <h1 class="cm-title text-white">Application Form</h1>
                        <div class="breadcrumb-nav mt-3">
                            <a href="<?php echo esc_url(home_url('/')); ?>" class="text-white" title="Home">Home</a>
                            <span class="text-white mx-2">-</span>
                            <a href="<?php echo esc_url(home_url('/career')); ?>" class="text-white" title="Career">Career</a>
                            <span class="text-white mx-2">-</span>
                            <span class="text-white">Application Form</span>
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
    'title'           => 'Application Form',
    'subtitle'        => 'Take the next step in your career with Microlink. Fill out the application details below and our recruitment team will review your profile.',
    'form_title'      => 'Send us your Application',
    'recipient_email' => 'jobs@microlink.co.in'
]);
?>

<?php get_footer(); ?>
