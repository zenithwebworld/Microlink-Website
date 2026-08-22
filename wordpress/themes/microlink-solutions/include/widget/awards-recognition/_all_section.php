<?php
// Awards Section Widget
class Awards_Section_Widget extends WP_Widget {
    function __construct() {
        parent::__construct(
            'awards_section',
            __('Awards :: All Section', _THEME_DOMAIN),
            array('description' => __('Update awards page content', _THEME_DOMAIN))
        );
    }

    // Frontend Output
    public function widget($args, $instance) {
        echo $args['before_widget'];

        $title    = !empty($instance['title']) ? $instance['title'] : 'Awards & Recognition';
        $subtitle = !empty($instance['subtitle']) ? $instance['subtitle'] : 'Over the years, Microlink has been honored for its commitment to innovation, quality, and customer excellence. These recognitions reflect our dedication to delivering reliable solutions and building long-term partnerships based on trust and performance.';

        $items = [];
        for ($i = 1; $i <= 8; $i++) {
            $img   = $instance["img_$i"] ?? '';
            $label = $instance["label_$i"] ?? '';
            if (!empty($img)) {
                $items[] = [
                    'img'   => $img,
                    'label' => $label ?: 'Award Image'
                ];
            }
        }
        ?>

        <section class="gallery-section section-gap">
            <div class="container">
                <div class="row">
                    <div class="col-12">
                        <div class="row justify-content-between align-items-center cm-nav">
                            <div class="col-lg-8">
                                <h2 class="cm-title text-black fs-40 mb-2"><?php echo wp_kses_post($title); ?></h2>
                                <p><?php echo esc_html($subtitle); ?></p>
                            </div>
                        </div>

                        <div class="mt-5">
                            <div class="row g-4">
                                <?php if (!empty($items)) : ?>
                                    <?php foreach ($items as $item) : ?>
                                        <div class="col-md-4 col-lg-3">
                                            <a href="<?php echo esc_url($item['img']); ?>" data-fancybox="gallery" class="media-item position-relative">
                                                <figure class="thumbnail-container object-fit">
                                                    <div class="thumbnail">
                                                        <img src="<?php echo esc_url($item['img']); ?>" alt="<?php echo esc_attr($item['label']); ?>" width="720" height="480">
                                                    </div>
                                                </figure>
                                            </a>
                                        </div>
                                    <?php endforeach; ?>
                                <?php else : ?>
                                    <div class="col-12 text-center text-muted"><p>No awards added yet.</p></div>
                                <?php endif; ?>
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

        <hr>
        <h4>Award Items</h4>
        <?php for ($i = 1; $i <= 8; $i++) : ?>
            <p><strong>Award Item <?php echo $i; ?></strong></p>
            <p>
                <input class="widefat" placeholder="Image URL" name="<?php echo $this->get_field_name("img_$i"); ?>" value="<?php echo esc_attr($instance["img_$i"] ?? ''); ?>">
            </p>
            <p>
                <input class="widefat" placeholder="Alt Label" name="<?php echo $this->get_field_name("label_$i"); ?>" value="<?php echo esc_attr($instance["label_$i"] ?? ''); ?>">
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
            $instance["img_$i"]   = !empty($new_instance["img_$i"]) ? esc_url_raw($new_instance["img_$i"]) : '';
            $instance["label_$i"] = !empty($new_instance["label_$i"]) ? sanitize_text_field($new_instance["label_$i"]) : '';
        }

        return $instance;
    }
}

// Register Widget
function register_awards_section_widget() {
    register_widget('Awards_Section_Widget');
}
add_action('widgets_init', 'register_awards_section_widget');