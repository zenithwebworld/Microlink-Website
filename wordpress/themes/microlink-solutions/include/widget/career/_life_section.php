<?php
// Career Life Section Widget (Dynamic Custom Post Type & Category Query)
class Career_Life_Section_Widget extends WP_Widget {
    function __construct() {
        parent::__construct(
            'career_life_section',
            __('Career :: Life @Microlink', _THEME_DOMAIN),
            array('description' => __('Display photos and videos from Life @ Microlink CPT as per category', _THEME_DOMAIN))
        );
    }

    // Frontend Output
    public function widget($args, $instance) {
        echo $args['before_widget'];

        $title    = !empty($instance['title']) ? $instance['title'] : 'Life @Microlink';
        $subtitle = !empty($instance['subtitle']) ? $instance['subtitle'] : 'Discover our vibrant work culture, team celebrations, and collaborative environment at Microlink.';
        ?>

        <section class="gallery-section section-gap">
            <div class="container">
                <div class="row">
                    <div class="col-12">
                        <div class="row justify-content-between align-items-center cm-nav">
                            <div class="col-lg-8">
                                <h2 class="cm-title text-black fs-40"><?php echo wp_kses_post($title); ?></h2>
                                <p><?php echo esc_html($subtitle); ?></p>
                            </div>
                            <div class="col-lg-4 text-lg-end">
                                <div class="d-inline-flex">
                                    <ul class="nav nav-pills mb-4" id="lifeTab" role="tablist">
                                        <li class="nav-item">
                                            <button class="nav-link active" data-bs-toggle="tab" data-bs-target="#life-photos" type="button">Photos</button>
                                        </li>
                                        <li class="nav-item">
                                            <button class="nav-link" data-bs-toggle="tab" data-bs-target="#life-videos" type="button">Videos</button>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>

                        <div class="tab-content mt-4 mt-lg-5" id="lifeTabContent">
                            <!-- PHOTOS TAB -->
                            <div class="tab-pane fade show active" id="life-photos" role="tabpanel">
                                <div class="row g-4">
                                    <?php
                                    $photos_query = new WP_Query([
                                        'post_type'      => 'life_microlink',
                                        'posts_per_page' => -1,
                                        'meta_query'     => [
                                            'relation' => 'OR',
                                            [
                                                'key'     => '_life_media_type',
                                                'value'   => 'photo',
                                                'compare' => '='
                                            ],
                                            [
                                                'key'     => '_life_media_type',
                                                'compare' => 'NOT EXISTS'
                                            ]
                                        ],
                                        'tax_query'      => [
                                            'relation' => 'OR',
                                            [
                                                'taxonomy' => 'life_category',
                                                'field'    => 'slug',
                                                'terms'    => ['photos', 'photo'],
                                            ]
                                        ]
                                    ]);

                                    // Fallback if no taxonomy filter matched
                                    if (!$photos_query->have_posts()) {
                                        $photos_query = new WP_Query([
                                            'post_type'      => 'life_microlink',
                                            'posts_per_page' => -1,
                                            'meta_query'     => [
                                                'relation' => 'OR',
                                                [
                                                    'key'     => '_life_media_type',
                                                    'value'   => 'photo',
                                                    'compare' => '='
                                                ],
                                                [
                                                    'key'     => '_life_media_type',
                                                    'compare' => 'NOT EXISTS'
                                                ]
                                            ]
                                        ]);
                                    }

                                    if ($photos_query->have_posts()) :
                                        while ($photos_query->have_posts()) : $photos_query->the_post();
                                            $img_url = get_post_meta(get_the_ID(), '_life_photo_url', true) ?: get_the_post_thumbnail_url(get_the_ID(), 'full');
                                            if (empty($img_url)) {
                                                continue;
                                            }
                                            $post_title = get_the_title();
                                    ?>
                                        <div class="col-md-4 col-lg-3">
                                            <a href="<?php echo esc_url($img_url); ?>" data-fancybox="gallery" class="media-item position-relative" title="<?php echo esc_attr($post_title); ?>">
                                                <figure class="thumbnail-container object-fit">
                                                    <div class="thumbnail">
                                                        <img src="<?php echo esc_url($img_url); ?>" alt="<?php echo esc_attr($post_title); ?>" width="720" height="480">
                                                    </div>
                                                </figure>
                                            </a>
                                        </div>
                                    <?php
                                        endwhile;
                                        wp_reset_postdata();
                                    else :
                                        echo '<div class="col-12 text-center text-muted"><p>No photos published yet. Add items in WP Admin -> Life @ Microlink.</p></div>';
                                    endif;
                                    ?>
                                </div>
                            </div>

                            <!-- VIDEOS TAB -->
                            <div class="tab-pane fade" id="life-videos" role="tabpanel">
                                <div class="row g-4">
                                    <?php
                                    $videos_query = new WP_Query([
                                        'post_type'      => 'life_microlink',
                                        'posts_per_page' => -1,
                                        'meta_query'     => [
                                            [
                                                'key'     => '_life_media_type',
                                                'value'   => 'video',
                                                'compare' => '='
                                            ]
                                        ],
                                        'tax_query'      => [
                                            [
                                                'taxonomy' => 'life_category',
                                                'field'    => 'slug',
                                                'terms'    => ['videos', 'video'],
                                            ]
                                        ]
                                    ]);

                                    // Fallback query if no taxonomy match
                                    if (!$videos_query->have_posts()) {
                                        $videos_query = new WP_Query([
                                            'post_type'      => 'life_microlink',
                                            'posts_per_page' => -1,
                                            'meta_query'     => [
                                                [
                                                    'key'     => '_life_media_type',
                                                    'value'   => 'video',
                                                    'compare' => '='
                                                ]
                                            ]
                                        ]);
                                    }

                                    if ($videos_query->have_posts()) :
                                        while ($videos_query->have_posts()) : $videos_query->the_post();
                                            $img_url   = get_the_post_thumbnail_url(get_the_ID(), 'full') ?: get_post_meta(get_the_ID(), '_life_photo_url', true);
                                            $video_url = get_post_meta(get_the_ID(), '_life_video_url', true);
                                            $post_title = get_the_title();
                                            if (empty($video_url)) {
                                                $video_url = get_permalink();
                                            }
                                    ?>
                                        <div class="col-md-4 col-lg-3">
                                            <a data-fancybox href="<?php echo esc_url($video_url); ?>" class="media-item position-relative" title="<?php echo esc_attr($post_title); ?>">
                                                <figure class="thumbnail-container object-fit">
                                                    <div class="thumbnail">
                                                        <?php if (!empty($img_url)) : ?>
                                                            <img src="<?php echo esc_url($img_url); ?>" alt="<?php echo esc_attr($post_title); ?>" width="720" height="480">
                                                        <?php else : ?>
                                                            <div class="bg-secondary text-white p-4 text-center d-flex align-items-center justify-content-center h-100">
                                                                <span><?php echo esc_html($post_title); ?></span>
                                                            </div>
                                                        <?php endif; ?>
                                                    </div>
                                                </figure>
                                                <div class="play-btn">▶</div>
                                            </a>
                                        </div>
                                    <?php
                                        endwhile;
                                        wp_reset_postdata();
                                    else :
                                        echo '<div class="col-12 text-center text-muted"><p>No videos published yet. Add items in WP Admin -> Life @ Microlink with type Video.</p></div>';
                                    endif;
                                    ?>
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
        $title    = $instance['title'] ?? '';
        $subtitle = $instance['subtitle'] ?? '';
        ?>

        <p><label>Section Title (HTML allowed e.g. &lt;span&gt;)</label>
        <input class="widefat" name="<?php echo $this->get_field_name('title'); ?>" value="<?php echo esc_attr($title); ?>"></p>

        <p><label>Section Subtitle</label>
        <textarea class="widefat" rows="3" name="<?php echo $this->get_field_name('subtitle'); ?>"><?php echo esc_textarea($subtitle); ?></textarea></p>

        <p class="description">
            <em>Note: Media items (Photos and Videos) are automatically queried from the <strong>Life @ Microlink</strong> Custom Post Type according to their Media Type and Category. In each post admin screen, you can choose a file directly from the Media Library or enter a direct URL!</em>
        </p>
    <?php }

    // Save Data
    public function update($new_instance, $old_instance) {
        $instance = [];
        $instance['title']    = !empty($new_instance['title']) ? wp_kses_post($new_instance['title']) : '';
        $instance['subtitle'] = !empty($new_instance['subtitle']) ? sanitize_textarea_field($new_instance['subtitle']) : '';
        return $instance;
    }
}

// Register Widget
function register_career_life_section_widget() {
    register_widget('Career_Life_Section_Widget');
}
add_action('widgets_init', 'register_career_life_section_widget');