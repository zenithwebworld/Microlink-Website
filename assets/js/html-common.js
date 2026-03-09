/* Menu Open Function S */
    function openNav() {
        $("body").addClass('menu-overlap');
    }
    $('#menu-open').on('click',function() {
        openNav();
    });
/* Menu Open Function E */

/* Menu Close Function S */
    function closeNav() {
        $("body").removeClass('menu-overlap');
    }
    $('#menu-close, .nav-overlay').on('click',function() {
        closeNav();
    });
/* Menu Close Function E */

/* Responsive Class Add S */
    $( document ).ready(function() {
        $(".menu ul li").find("ul").before('<span class="is-open"><img class="lazy" src="assets/images/plus.svg" alt="Menu Close" title="Menu Close" width="20" height="20"></span>');
        $(".menu ul li").find("ul").parent("li").addClass("is-open-a");
        $(".menu .is-open").click(function(event) {
            event.preventDefault();
            $(this).toggleClass("is-close");
        });
    });
/* Responsive Class Add E */

/* Tab Menu Height Calc S */
    $("#menu > ul > li > a").hover(function(){
        var liMaxHeight = -1;
        $(".tab-menu li ul").each(function(index) {
            if ($(this).outerHeight() > liMaxHeight) {
                liMaxHeight = $(this).outerHeight();
            }
        });
        $(".tab-menu").css("min-height", liMaxHeight);
        $(".tab-menu > li > ul").css("min-height", liMaxHeight);
        //console.log($(".tab-menu > li > ul").css("min-height", liMaxHeight));
    });
/* Tab Menu Height Calc E */

/* Hide Header on on scroll down S */
    var didScroll;
    var lastScrollTop = 0;
    var delta = 5;
    var navbarHeight = $('header').outerHeight();

    $(window).scroll(function(event){
        didScroll = true;
    });

    setInterval(function() {
        if (didScroll) {
            hasScrolled();
            didScroll = false;
        }
    }, 250);

    function hasScrolled() {
        var st = $(this).scrollTop();
        if(Math.abs(lastScrollTop - st) <= delta)
            return;
        if (st > lastScrollTop && st > navbarHeight){
            $('header').removeClass('nav-down').addClass('nav-up');
        } else {
            if(st + $(window).height() < $(document).height()) {
                $('header').removeClass('nav-up').addClass('nav-down');
            }
        }    
        lastScrollTop = st;
    }
    $(window).scroll(function() {
        var scroll = $(window).scrollTop();
        if (scroll >= 80) {
            $("header").addClass("mobile-stick");
        } else{
            $("header").removeClass("mobile-stick");
        }
    });
/* Hide Header on on scroll down E */

window.addEventListener('load', function () {
    AOS.init({
        duration: 1200, // animation duration in ms (slower)
        delay: 200,     // global delay added to each animation
        easing: 'ease-in-out',
        once: false,    // allow animations to happen every time element enters
        // disable AOS on small screens (mobile)
        disable: function() { return window.innerWidth < 1024; }
    });
});


/* Section 1 S */
    function Marquee(selector, speed) {
        const parentSelector = document.querySelector(selector);
        const clone = parentSelector.innerHTML;
        const firstElement = parentSelector.children[0];
        let i = 0;
        /* console.log(firstElement); */
        parentSelector.insertAdjacentHTML('beforeend', clone);
        parentSelector.insertAdjacentHTML('beforeend', clone);
        // animate at ~60fps using a 16ms interval
        setInterval(function () {
                firstElement.style.marginLeft = `-${i}px`;
                if (i > firstElement.clientWidth) {
                    i = 0;
                }
                i = i + speed;
            }, 16);
    }
        if ($(".partner-marquee-slider").length) {
            window.addEventListener('load', function(){ Marquee('.partner-marquee-slider', 0.6); });
        }
/* Section 1 E */
$(function () {

    const D = 4000; // sab counters ka same total time (ms) - increased for slower animation

    function animateCounter(el, from, to, duration) {
        if (el._rafId) cancelAnimationFrame(el._rafId);
        let start = null;
        function step(timestamp) {
            if (!start) start = timestamp;
            const elapsed = timestamp - start;
            const progress = Math.min(elapsed / duration, 1);
            const value = Math.floor(from + (to - from) * progress);
            $(el).text(value);
            if (progress < 1) {
                el._rafId = requestAnimationFrame(step);
            } else {
                $(el).text(to);
                el._rafId = null;
            }
        }
        el._rafId = requestAnimationFrame(step);
    }

    const io = new IntersectionObserver(entries => {
        entries.forEach(entry => {
            const section = entry.target;
            $(section).find('.counter-number').each(function () {
                const el = this;
                const target = +$(el).data('target') || 0;
                const duration = +$(el).data('duration') || D;

                // If section left viewport, cancel any running animation and reset
                if (!entry.isIntersecting) {
                    if (el._rafId) cancelAnimationFrame(el._rafId);
                    el._rafId = null;
                    $(el).text(0);
                    return;
                }

                // Start (or restart) animation when section enters viewport
                $(el).text(0);
                animateCounter(el, 0, target, duration);
            });
        });
    }, { threshold: 0.5 });

    $('section').each((_, s) => io.observe(s));

});

/* Services Owl Init S */
$(document).ready(function () {
    $(".services-owl").owlCarousel({
        loop: true,
        margin: 25,
        nav: false,
        dots: true,
        autoplay: true,
        autoplayTimeout: 3000,
        autoplayHoverPause: true,
        navText: [
            '<i class="n-icon" data-icon="s-arrow-left" data-iconwidth="24px" data-iconheight="24px"></i>',
            '<i class="n-icon" data-icon="s-arrow-right" data-iconwidth="24px" data-iconheight="24px"></i>'
        ],
        responsive: {
            0: {
                items: 1,
            },
            600: {
                items: 2,
            },
            1000: {
                items: 3,
            },
        },
        onInitialized: function() {
            svgIcon(); // Recalling svgIcon function after Owl Carousel initialization
        }
    });
});
/* Services Owl Init E */

$(document).ready(function(){

    $(".solution-section-02 .owl-carousel").owlCarousel({
        loop: true,
        margin: 25,
        dots: false,
        nav: true,
        autoplay: true,
        autoplayTimeout: 3000,
        autoplayHoverPause: true,
        navText: [
            '<i class="n-icon" data-icon="s-arrow-left" data-iconwidth="24px" data-iconheight="24px"></i>',
            '<i class="n-icon" data-icon="s-arrow-right" data-iconwidth="24px" data-iconheight="24px"></i>'
        ],
        responsive: {
            0: {
                items: 1
            },
            767: {
                items: 2
            },
            1200: {
                items: 3
            }
        },
        onInitialized: function() {
            svgIcon(); // Recalling svgIcon function after Owl Carousel initialization
        }
    });
});

$(document).ready(function(){
    $(".testimonial-carousel").owlCarousel({
        loop: true,
        margin: 10,
        nav: true,
        navText: [
            '<i class="n-icon" data-icon="s-arrow-left" data-iconwidth="24px" data-iconheight="24px"></i>',
            '<i class="n-icon" data-icon="s-arrow-right" data-iconwidth="24px" data-iconheight="24px"></i>'
        ],
        dots: false,
        autoplay: true,
        autoplayTimeout: 5000,
        responsive: {
            0: {
                items: 1
            },
            600: {
                items: 1
            },
            1000: {
                items: 1
            }
        },
        onInitialized: function() {
            svgIcon(); // Recalling svgIcon function after Owl Carousel initialization
        }
    });
});
$(document).ready(function(){
    $(".portfolio-slider").owlCarousel({
        loop: true,
        margin: 10,
        nav: true,
        navText: [
            '<i class="n-icon" data-icon="s-arrow-left" data-iconwidth="24px" data-iconheight="24px"></i>',
            '<i class="n-icon" data-icon="s-arrow-right" data-iconwidth="24px" data-iconheight="24px"></i>'
        ],
        dots: false,
        autoplay: true,
        autoplayTimeout: 5000,
        responsive: {
            0:{ items:1 },
            992:{ items:2 },
        },
        onInitialized: function() {
            svgIcon(); // Recalling svgIcon function after Owl Carousel initialization
        }
    });
});