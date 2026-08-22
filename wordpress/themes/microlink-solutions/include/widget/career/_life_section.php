<?php
// Hero Section Widget
class Career_Life_Section_Widget extends WP_Widget {
    function __construct() {
        parent::__construct(
            'career_life_section',
            __('Career :: Life @Microlink', _THEME_DOMAIN),
            array('description' => __('Update life content', _THEME_DOMAIN))
        );
    }

    // Frontend Output
    public function widget($args, $instance) {
        echo $args['before_widget']; ?>

        <section class="gallery-section section-gap">
            <div class="container">
                <div class="row">
                    <div class="col-12">
                        <div class="row justify-content-between align-items-center cm-nav">
                            <div class="col-lg-8">
                                <h2 class="cm-title text-black fs-40">Life @Microlink</h2>
                                <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Tempora vero nisi sint corrupti, illum non similique impedit ratione officia, alias, iure quaerat nobis earum officiis provident veniam? Eligendi, voluptates eos.</p>
                            </div>
                            <div class="col-lg-4 text-lg-end">

                                <div class="d-inline-flex">
                                    <ul class="nav nav-pills  mb-4">
                                        <li class="nav-item">
                                            <button class="nav-link active" data-bs-toggle="tab" data-bs-target="#photos">
                                                Photos
                                            </button>
                                        </li>
                                        <li class="nav-item">
                                            <button class="nav-link" data-bs-toggle="tab" data-bs-target="#videos">
                                                Videos
                                            </button>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>

                        <div class="tab-content mt-4 mt-lg-5">

                        <!-- PHOTOS -->
                        <div class="tab-pane fade show active" id="photos">
                            <div class="row g-4">

                                <div class="col-md-4 col-lg-3">
                                    <a href="https://images.unsplash.com/photo-1558494949-ef010cbdcc31"
                                    data-fancybox="gallery"
                                    class="media-item position-relative">
 
                                        <figure class="thumbnail-container object-fit">
                                            <div class="thumbnail">
                                                <img src="https://images.unsplash.com/photo-1558494949-ef010cbdcc31"
                                                    alt="Data Center"
                                                    width="720" height="480">
                                            </div>
                                        </figure>

                                    </a>
                                </div>
                                <div class="col-md-4 col-lg-3">
                                    <a href="https://lh3.googleusercontent.com/aida-public/AB6AXuDhdiikxYCjhNj_dp5OSKZfiqaBmDWM9i0xUM59whDDWulvvkGu-lj3s9hX0TyYmVa23ni8mSc60IMCDKVusLJUeZkvALQL9MMW_QpurHXTgRMSweYH2uadDqTAL7JjG8TSoyQtgIOiA5hJn52bUoyaX0BwtQR-4O7LIsrh-alDbzAvHrszCxbRLruUYkyE84vc7wBQm3tBZftdqmQ-dvQd_IB_xjpHEsOzdtOlB_1qpV6XmVYbh-1QEBmjDKPnWfjJbRGdpiHEHcQ"
                                    data-fancybox="gallery"
                                    class="media-item position-relative">
 
                                        <figure class="thumbnail-container object-fit">
                                            <div class="thumbnail">
                                                <img src="https://lh3.googleusercontent.com/aida-public/AB6AXuDhdiikxYCjhNj_dp5OSKZfiqaBmDWM9i0xUM59whDDWulvvkGu-lj3s9hX0TyYmVa23ni8mSc60IMCDKVusLJUeZkvALQL9MMW_QpurHXTgRMSweYH2uadDqTAL7JjG8TSoyQtgIOiA5hJn52bUoyaX0BwtQR-4O7LIsrh-alDbzAvHrszCxbRLruUYkyE84vc7wBQm3tBZftdqmQ-dvQd_IB_xjpHEsOzdtOlB_1qpV6XmVYbh-1QEBmjDKPnWfjJbRGdpiHEHcQ"
                                                    alt="Data Center"
                                                    width="720" height="480">
                                            </div>
                                        </figure>

                                    </a>
                                </div>
                                <div class="col-md-4 col-lg-3">
                                    <a href="https://lh3.googleusercontent.com/aida-public/AB6AXuCJnwxldcr0eTURpZnQGTfWI0CQPQLMwivvh6Ehhr1CmqQZO6Yc8K8Qw4afQmIhnROwppO2NoXgocLGfoBOTpnfcgVw2o95-fSpXYZ0Z6ckGiiCNAlmHssnu1hfMY3xi83sei8Hie539dCrSE18MFEb_Z88yBZF-pTRqqv3LfsamMlUiNmo9tVpJQtJbOK1Xp1mCSZg5IcHlNgmHtw7gJBjWCkoLjM45qH4BJ4GfCfhA3FM19fovSbExjduT9ZZ4_5hiD3Vqb7_4l8"
                                    data-fancybox="gallery"
                                    class="media-item position-relative">
 
                                        <figure class="thumbnail-container object-fit">
                                            <div class="thumbnail">
                                                <img src="https://lh3.googleusercontent.com/aida-public/AB6AXuCJnwxldcr0eTURpZnQGTfWI0CQPQLMwivvh6Ehhr1CmqQZO6Yc8K8Qw4afQmIhnROwppO2NoXgocLGfoBOTpnfcgVw2o95-fSpXYZ0Z6ckGiiCNAlmHssnu1hfMY3xi83sei8Hie539dCrSE18MFEb_Z88yBZF-pTRqqv3LfsamMlUiNmo9tVpJQtJbOK1Xp1mCSZg5IcHlNgmHtw7gJBjWCkoLjM45qH4BJ4GfCfhA3FM19fovSbExjduT9ZZ4_5hiD3Vqb7_4l8"
                                                    alt="Data Center"
                                                    width="720" height="480">
                                            </div>
                                        </figure>

                                    </a>
                                </div>
                                <div class="col-md-4 col-lg-3">
                                    <a href="https://lh3.googleusercontent.com/aida-public/AB6AXuCFukaP8PLUm1bLtzcr1kJXJwznblPNHucYzA4sYXfdJqtOLIZky-KrGJr7QzzHD9iPooDqwmvM5GGGWS-tY9mzkP9uXGFuMzkKwjP47jqisltMunEOJKhBIoOFaeU9cNuQGhit3tlKgyv0r4IVlAtmBX5KyZYlC751H9oXUH43QUt7QV2Td0roFnHrI23GiH8Pbw4IM6t5xNtB-ehcKz2J6m68hD9x7jDrQoLQ9AZINwo7aVDepgMQdwRHA-wGIUcbvxFgL07sIho"
                                    data-fancybox="gallery"
                                    class="media-item position-relative">
 
                                        <figure class="thumbnail-container object-fit">
                                            <div class="thumbnail">
                                                <img src="https://lh3.googleusercontent.com/aida-public/AB6AXuCFukaP8PLUm1bLtzcr1kJXJwznblPNHucYzA4sYXfdJqtOLIZky-KrGJr7QzzHD9iPooDqwmvM5GGGWS-tY9mzkP9uXGFuMzkKwjP47jqisltMunEOJKhBIoOFaeU9cNuQGhit3tlKgyv0r4IVlAtmBX5KyZYlC751H9oXUH43QUt7QV2Td0roFnHrI23GiH8Pbw4IM6t5xNtB-ehcKz2J6m68hD9x7jDrQoLQ9AZINwo7aVDepgMQdwRHA-wGIUcbvxFgL07sIho"
                                                    alt="Data Center"
                                                    width="720" height="480">
                                            </div>
                                        </figure>

                                    </a>
                                </div>
                                <div class="col-md-4 col-lg-3">
                                    <a href="https://lh3.googleusercontent.com/aida-public/AB6AXuB7yWOEnLcMFuOsvx6_Tu68LuMYRMJfPgDAUT5NRq_5Qn8WN2yAsUo6s-S9BVzXq3QZgnRegHq_NhKCN9EZW0ouvLDs85gR0JgqPgA7HZv8_g1Bb3La2Bu-Lr00Ns0jZU-KEGsFgvo1b-IQAApw1T7PT8xY41eYMFtGH2CJLD-KshgJV2wgX3HI_tmKuzu4wmY9Kg4hHYYnRvuj53uFCT4CkO33QLmw2uno_XW9hFEr3eK5DkG0btq1KTZvugDxjK-V25OgzzwA8Pg"
                                    data-fancybox="gallery"
                                    class="media-item position-relative">
 
                                        <figure class="thumbnail-container object-fit">
                                            <div class="thumbnail">
                                                <img src="https://lh3.googleusercontent.com/aida-public/AB6AXuB7yWOEnLcMFuOsvx6_Tu68LuMYRMJfPgDAUT5NRq_5Qn8WN2yAsUo6s-S9BVzXq3QZgnRegHq_NhKCN9EZW0ouvLDs85gR0JgqPgA7HZv8_g1Bb3La2Bu-Lr00Ns0jZU-KEGsFgvo1b-IQAApw1T7PT8xY41eYMFtGH2CJLD-KshgJV2wgX3HI_tmKuzu4wmY9Kg4hHYYnRvuj53uFCT4CkO33QLmw2uno_XW9hFEr3eK5DkG0btq1KTZvugDxjK-V25OgzzwA8Pg"
                                                    alt="Data Center"
                                                    width="720" height="480">
                                            </div>
                                        </figure>

                                    </a>
                                </div>

                                <div class="col-md-4 col-lg-3">
                                    <a href="https://images.unsplash.com/photo-1563986768609-322da13575f3"
                                    data-fancybox="gallery"
                                    class="media-item position-relative">
 
                                        <figure class="thumbnail-container object-fit">
                                            <div class="thumbnail">
                                                <img src="https://images.unsplash.com/photo-1563986768609-322da13575f3"
                                                    alt="Cyber Security"
                                                    width="720" height="480">
                                            </div>
                                        </figure>

                                    </a>
                                </div>
                                <div class="col-md-4 col-lg-3">
                                    <a href="https://lh3.googleusercontent.com/aida-public/AB6AXuB7yWOEnLcMFuOsvx6_Tu68LuMYRMJfPgDAUT5NRq_5Qn8WN2yAsUo6s-S9BVzXq3QZgnRegHq_NhKCN9EZW0ouvLDs85gR0JgqPgA7HZv8_g1Bb3La2Bu-Lr00Ns0jZU-KEGsFgvo1b-IQAApw1T7PT8xY41eYMFtGH2CJLD-KshgJV2wgX3HI_tmKuzu4wmY9Kg4hHYYnRvuj53uFCT4CkO33QLmw2uno_XW9hFEr3eK5DkG0btq1KTZvugDxjK-V25OgzzwA8Pg"
                                    data-fancybox="gallery"
                                    class="media-item position-relative">
 
                                        <figure class="thumbnail-container object-fit">
                                            <div class="thumbnail">
                                                <img src="https://lh3.googleusercontent.com/aida-public/AB6AXuB7yWOEnLcMFuOsvx6_Tu68LuMYRMJfPgDAUT5NRq_5Qn8WN2yAsUo6s-S9BVzXq3QZgnRegHq_NhKCN9EZW0ouvLDs85gR0JgqPgA7HZv8_g1Bb3La2Bu-Lr00Ns0jZU-KEGsFgvo1b-IQAApw1T7PT8xY41eYMFtGH2CJLD-KshgJV2wgX3HI_tmKuzu4wmY9Kg4hHYYnRvuj53uFCT4CkO33QLmw2uno_XW9hFEr3eK5DkG0btq1KTZvugDxjK-V25OgzzwA8Pg"
                                                    alt="Cyber Security"
                                                    width="720" height="480">
                                            </div>
                                        </figure>

                                    </a>
                                </div>
                                <div class="col-md-4 col-lg-3">
                                    <a href="https://lh3.googleusercontent.com/aida-public/AB6AXuALVGxbzQmzK6VYH3r2BMAtkGNwakuvr5pbjwc272HztIyqiaNZqZZ_5EbDh3JC9wb3m8w-_CB7ue0eHFe2UDE2jGo4RRIr5hiQo6iA_ejYV7Ulf7UkQc9Tmh82B73IIkCbQ3mbEGjQFUDY5bbHRvlZ9CPwmUP0gcnUJ3I0HbA4f7IDuBXQ2EEwkTZaDWr9Cno0pGHEJwLinZ3013KEtSCA_SFq5iHAhzRBNKXNCgcVb4RMI5JMO7QMpu5BXFLjh8junkI5OyDxzxA"
                                    data-fancybox="gallery"
                                    class="media-item position-relative">
 
                                        <figure class="thumbnail-container object-fit">
                                            <div class="thumbnail">
                                                <img src="https://lh3.googleusercontent.com/aida-public/AB6AXuALVGxbzQmzK6VYH3r2BMAtkGNwakuvr5pbjwc272HztIyqiaNZqZZ_5EbDh3JC9wb3m8w-_CB7ue0eHFe2UDE2jGo4RRIr5hiQo6iA_ejYV7Ulf7UkQc9Tmh82B73IIkCbQ3mbEGjQFUDY5bbHRvlZ9CPwmUP0gcnUJ3I0HbA4f7IDuBXQ2EEwkTZaDWr9Cno0pGHEJwLinZ3013KEtSCA_SFq5iHAhzRBNKXNCgcVb4RMI5JMO7QMpu5BXFLjh8junkI5OyDxzxA"
                                                    alt="Cyber Security"
                                                    width="720" height="480">
                                            </div>
                                        </figure>

                                    </a>
                                </div>

                            </div>
                             <div class="row mt-5">
                                <div class="col-12 d-flex justify-content-center">
                                    <nav aria-label="Page navigation">
                                        <ul class="pagination">
                                            <li class="page-item disabled">
                                                <a class="page-link" href="#" tabindex="-1" aria-disabled="true">Previous</a>
                                            </li>
                                            <li class="page-item active" aria-current="page">
                                                <a class="page-link" href="#">1</a>
                                            </li>
                                            <li class="page-item">
                                                <a class="page-link" href="#">2</a>
                                            </li>
                                            <li class="page-item">
                                                <a class="page-link" href="#">3</a>
                                            </li>
                                            <li class="page-item">
                                                <a class="page-link" href="#">Next</a>
                                            </li>
                                        </ul>
                                    </nav>
                                </div>
                            </div>
                        </div>

                        <!-- VIDEOS -->
                        <div class="tab-pane fade" id="videos">
                            <div class="row g-4">

                                <div class="col-md-4 col-lg-3">
                                    <a data-fancybox
                                    href="https://www.youtube.com/watch?v=inWWhr5tnEA"
                                    class="media-item position-relative">
 
                                        <figure class="thumbnail-container object-fit">
                                            <div class="thumbnail">
                                                <img src="https://images.unsplash.com/photo-1518770660439-4636190af475"
                                                    alt="Cyber Security Video"
                                                    width="720" height="480">
                                            </div>
                                        </figure>

                                        <div class="play-btn">▶</div>

                                    </a>
                                </div>

                                <div class="col-md-4 col-lg-3">
                                    <a data-fancybox
                                    href="https://www.youtube.com/watch?v=2LaAJq1lB1Q"
                                    class="media-item position-relative">
 
                                        <figure class="thumbnail-container object-fit">
                                            <div class="thumbnail">
                                                <img src="https://images.unsplash.com/photo-1550751827-4bd374c3f58b"
                                                    alt="Cloud Video"
                                                    width="720" height="480">
                                            </div>
                                        </figure>

                                        <div class="play-btn">▶</div>

                                    </a>
                                </div>

                            </div>
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
    public function form($instance) { ?>

    <?php }

    // Save Data (FIXED SAFE VERSION)
    public function update($new_instance, $old_instance) {
        $instance = [];
        return $instance;
    }
}

// Register Widget
function register_career_life_section_widget() {
    register_widget('Career_Life_Section_Widget');
}
add_action('widgets_init', 'register_career_life_section_widget');