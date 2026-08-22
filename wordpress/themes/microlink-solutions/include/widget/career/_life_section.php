<?php
// Career Life Section Widget
class Career_Life_Section_Widget extends WP_Widget {
    function __construct() {
        parent::__construct(
            'career_life_section',
            __('Career :: Life @Microlink', _THEME_DOMAIN),
            array('description' => __('Update life at Microlink content', _THEME_DOMAIN))
        );
    }

    // Frontend Output
    public function widget($args, $instance) {
        echo $args['before_widget'];

        $title    = !empty($instance['title']) ? $instance['title'] : 'Life @Microlink';
        $subtitle = !empty($instance['subtitle']) ? $instance['subtitle'] : 'Discover our vibrant work culture, team celebrations, and collaborative environment at Microlink.';

        $photos = [];
        for ($i = 1; $i <= 8; $i++) {
            $img = $instance["photo_$i"] ?? '';
            $alt = $instance["photo_alt_$i"] ?? '';
            if (!empty($img)) {
                $photos[] = ['img' => $img, 'alt' => $alt ?: 'Life photo'];
            }
        }

        $videos = [];
        for ($i = 1; $i <= 4; $i++) {
            $vurl  = $instance["video_url_$i"] ?? '';
            $vthumb = $instance["video_thumb_$i"] ?? '';
            $valt  = $instance["video_alt_$i"] ?? '';
            if (!empty($vurl)) {
                $videos[] = ['url' => $vurl, 'thumb' => $vthumb, 'alt' => $valt ?: 'Life video'];
            }
        }
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
                                    <ul class="nav nav-pills mb-4">
                                        <li class="nav-item">
                                            <button class="nav-link active" data-bs-toggle="tab" data-bs-target="#photos">Photos</button>
                                        </li>
                                        <?php if (!empty($videos)) : ?>
                                            <li class="nav-item">
                                                <button class="nav-link" data-bs-toggle="tab" data-bs-target="#videos">Videos</button>
                                            </li>
                                        <?php endif; ?>
                                    </ul>
                                </div>
                            </div>
                        </div>

                        <div class="tab-content mt-4 mt-lg-5">
                            <!-- PHOTOS -->
                            <div class="tab-pane fade show active" id="photos">
                                <div class="row g-4">
                                    <?php if (!empty($photos)) : ?>
                                        <?php foreach ($photos as $photo) : ?>
                                            <div class="col-md-4 col-lg-3">
                                                <a href="<?php echo esc_url($photo['img']); ?>" data-fancybox="gallery" class="media-item position-relative">
                                                    <figure class="thumbnail-container object-fit">
                                                        <div class="thumbnail">
                                                            <img src="<?php echo esc_url($photo['img']); ?>" alt="<?php echo esc_attr($photo['alt']); ?>" width="720" height="480">
                                                        </div>
                                                    </figure>
                                                </a>
                                            </div>
                                        <?php endforeach; ?>
                                    <?php else : ?>
                                        <div class="col-12 text-center text-muted"><p>No photos added yet.</p></div>
                                    <?php endif; ?>
                                </div>
                            </div>

                            <!-- VIDEOS -->
                            <?php if (!empty($videos)) : ?>
                                <div class="tab-pane fade" id="videos">
                                    <div class="row g-4">
                                        <?php foreach ($videos as $video) : ?>
                                            <div class="col-md-4 col-lg-3">
                                                <a data-fancybox href="<?php echo esc_url($video['url']); ?>" class="media-item position-relative">
                                                    <figure class="thumbnail-container object-fit">
                                                        <div class="thumbnail">
                                                            <?php if (!empty($video['thumb'])) : ?>
                                                                <img src="<?php echo esc_url($video['thumb']); ?>" alt="<?php echo esc_attr($video['alt']); ?>" width="720" height="480">
                                                            <?php else : ?>
                                                                <div class="bg-secondary text-white p-5 text-center"><?php echo esc_html($video['alt']); ?></div>
                                                            <?php endif; ?>
                                                        </div>
                                                    </figure>
                                                    <div class="play-btn">▶</div>
                                                </a>
                                            </div>
                                        <?php endforeach; ?>
                                    </div>
                                </div>
                            <?php endif; ?>
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

        <hr>
        <h4>Photo Gallery Items (Up to 8)</h4>
        <?php for ($i = 1; $i <= 8; $i++) : ?>
            <p>
                <label>Photo <?php echo $i; ?> Image URL</label>
                <input class="widefat" name="<?php echo $this->get_field_name("photo_$i"); ?>" value="<?php echo esc_attr($instance["photo_$i"] ?? ''); ?>">
            </p>
            <p>
                <input class="widefat" placeholder="Alt text" name="<?php echo $this->get_field_name("photo_alt_$i"); ?>" value="<?php echo esc_attr($instance["photo_alt_$i"] ?? ''); ?>">
            </p>
            <hr>
        <?php endfor; ?>

        <h4>Video Gallery Items (Up to 4)</h4>
        <?php for ($i = 1; $i <= 4; $i++) : ?>
            <p>
                <label>Video <?php echo $i; ?> URL</label>
                <input class="widefat" name="<?php echo $this->get_field_name("video_url_$i"); ?>" value="<?php echo esc_attr($instance["video_url_$i"] ?? ''); ?>">
            </p>
            <p>
                <input class="widefat" placeholder="Thumbnail Image URL" name="<?php echo $this->get_field_name("video_thumb_$i"); ?>" value="<?php echo esc_attr($instance["video_thumb_$i"] ?? ''); ?>">
            </p>
            <p>
                <input class="widefat" placeholder="Title/Alt text" name="<?php echo $this->get_field_name("video_alt_$i"); ?>" value="<?php echo esc_attr($instance["video_alt_$i"] ?? ''); ?>">
            </p>
            <hr>
        <?php endfor; ?>

    <?php }

    // Save Data
    public function update($new_instance, $old_instance) {
        $instance = [];
        $instance['title']    = !empty($new_instance['title']) ? wp_kses_post($new_instance['title']) : '';
        $instance['subtitle'] = !empty($new_instance['subtitle']) ? sanitize_textarea_field($new_instance['subtitle']) : '';

        for ($i = 1; $i <= 8; $i++) {
            $instance["photo_$i"]     = !empty($new_instance["photo_$i"]) ? esc_url_raw($new_instance["photo_$i"]) : '';
            $instance["photo_alt_$i"] = !empty($new_instance["photo_alt_$i"]) ? sanitize_text_field($new_instance["photo_alt_$i"]) : '';
        }

        for ($i = 1; $i <= 4; $i++) {
            $instance["video_url_$i"]   = !empty($new_instance["video_url_$i"]) ? esc_url_raw($new_instance["video_url_$i"]) : '';
            $instance["video_thumb_$i"] = !empty($new_instance["video_thumb_$i"]) ? esc_url_raw($new_instance["video_thumb_$i"]) : '';
            $instance["video_alt_$i"]   = !empty($new_instance["video_alt_$i"]) ? sanitize_text_field($new_instance["video_alt_$i"]) : '';
        }

        return $instance;
    }
}

// Register Widget
function register_career_life_section_widget() {
    register_widget('Career_Life_Section_Widget');
}
add_action('widgets_init', 'register_career_life_section_widget');