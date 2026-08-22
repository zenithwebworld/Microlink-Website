<?php get_header(); ?>

<?php
$paged = isset($_GET['page']) ? intval($_GET['page']) : 1;

$solutions = new WP_Query([
    'post_type' => 'solution',
    'posts_per_page' => 9,
    'paged' => $paged,
    'meta_query' => [
        [
            'key' => 'is_primary_page',
            'value' => '1',
            'compare' => '='
        ]
    ]
]);
?>

<section class="innerbanner-section">
    <div class="video-thumb">
        <div class="thumbnail-container object-fit">
            <div class="thumbnail">
                <img src="<?php echo get_template_directory_uri(); ?>/assets/images/i-banner.jpg" alt="Contact Banner" title="Contact Banner" width="1920" height="500">
            </div>
        </div>
        <div class="caption">
            <div class="container">
                <div class="row">
                    <div class="col-lg-8">
                        <h1 class="cm-title text-white">Solutions</h1>
                        <div class="breadcrumb-nav mt-3">
                            <a href="<?php echo esc_url(home_url('/')); ?>" class="text-white">Home</a>
                            <span class="text-white mx-2">-</span>
                            <span class="text-white">Solutions</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="solution-section-02 section-gap">
    <div class="container">

        <div class="row align-items-center mb-5">
            <div class="col-12">
                <h2 class="fw-bold mb-2">
                    Transforming Vision into Result <span class="text-primary">Customer Success Stories</span></h2>
                <p class="text-muted">
                    See how we turn complex business challenges into measurable results through strategic technology implementation.
                </p>
            </div>
        </div>

        <div class="row g-4">

            <?php if ($solutions->have_posts()) : ?>
                <?php while ($solutions->have_posts()) : $solutions->the_post();

                    $title = get_the_title();
                    $desc = get_post_meta(get_the_ID(), 'short_descirption', true);
                    $img = get_the_post_thumbnail_url(get_the_ID(), 'full');
                    $list_raw = get_post_meta(get_the_ID(), 'categories', true);
                    $link = get_permalink();
                ?>

                <!-- SAME HTML -->
                <div class="col-lg-4 col-md-6">
                    <div class="solution-item position-relative">
                        <figure class="thumbnail-container object-fit">
                            <div class="thumbnail">
                                <img src="<?php echo esc_url($img); ?>" alt="">
                            </div>
                        </figure>
                        <div class="solution-content d-flex flex-column h-100">
                            <div class="flex-grow-1">
                                <h3 class="mb-3">
                                    <a href="<?php echo esc_url($link); ?>" class="text-white"><?php echo esc_html($title); ?></a>
                                </h3>
                                <p class="text-white mb-3"><?php echo esc_html($desc); ?></p>

                                <div class="solution-list mt-4s">
                                    <?php echo html_entity_decode($list_raw); ?>
                                </div>
                            </div>

                            <div class="solution-btn">
                                <a href="<?php echo esc_url($link); ?>" class="btn btn-primary">Read more</a>
                            </div>
                        </div>
                    </div>
                </div>
                <?php endwhile; wp_reset_postdata(); ?>
            <?php endif; ?>
        </div>

        <!-- PAGINATION -->
        <div class="row mt-5">
            <div class="col-12 d-flex justify-content-center">
                <nav>
                    <ul class="pagination">

                        <?php
                        $total_pages = $solutions->max_num_pages;

                        if ($total_pages > 1) :
                            if ($paged > 1) :
                        ?>
                            <li class="page-item">
                                <a class="page-link" href="?page=<?php echo $paged - 1; ?>">Previous</a>
                            </li>
                        <?php else : ?>
                            <li class="page-item disabled">
                                <a class="page-link">Previous</a>
                            </li>
                        <?php endif; ?>

                        <?php for ($i = 1; $i <= $total_pages; $i++) : ?>
                            <li class="page-item <?php echo ($i == $paged) ? 'active' : ''; ?>">
                                <a class="page-link" href="?page=<?php echo $i; ?>"><?php echo $i; ?></a>
                            </li>
                        <?php endfor; ?>

                        <?php if ($paged < $total_pages) : ?>
                            <li class="page-item">
                                <a class="page-link" href="?page=<?php echo $paged + 1; ?>">Next</a>
                            </li>
                        <?php else : ?>
                            <li class="page-item disabled">
                                <a class="page-link">Next</a>
                            </li>
                        <?php endif; ?>

                        <?php endif; ?>

                    </ul>
                </nav>
            </div>
        </div>
    </div>
</section>

<?php get_footer(); ?>