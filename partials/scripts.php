<!-- JavaScript Files -->
<script src="<?php echo BASE_URL; ?>/assets/js/lib/pace.js"></script>

<!-- jQuery -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script src="<?php echo BASE_URL; ?>/assets/js/lib/bootstrap.bundle.min.js"></script>
<script src="<?php echo BASE_URL; ?>/assets/js/lib/mixitup.min.js"></script>
<script src="<?php echo BASE_URL; ?>/assets/js/lib/wow.min.js"></script>
<script src="<?php echo BASE_URL; ?>/assets/js/lib/html5shiv.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/lity@2.4.1/dist/lity.min.js"></script>

<!-- Custom CSS for Active State Override -->
<style>
    .navbar-nav .nav-link.active {
        color: var(--color-blue5) !important;
        font-weight: 700 !important;
    }
</style>

<!-- Custom JavaScript -->
<script>
    // Initialize WOW.js
    new WOW().init();

    // Preloader
    window.addEventListener('load', function () {
        const preloader = document.getElementById('preloader');
        if (preloader) {
            preloader.classList.add('isdone');
            setTimeout(function () {
                preloader.style.display = 'none';
            }, 1500);
        }
    });

    // Back to top button
    const toTopBtn = document.querySelector('.to_top');
    if (toTopBtn) {
        window.addEventListener('scroll', function () {
            if (window.scrollY > 300) {
                toTopBtn.style.display = 'inline-flex';
            } else {
                toTopBtn.style.display = 'none';
            }
        });

        toTopBtn.addEventListener('click', function (e) {
            e.preventDefault();
            window.scrollTo({
                top: 0,
                behavior: 'smooth'
            });
        });
    }

    // Smooth scroll for all anchor links (Fixed offset)
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function (e) {
            const href = this.getAttribute('href');
            if (href !== '#' && href !== '#!') {
                e.preventDefault();
                const target = document.querySelector(href);
                if (target) {
                    const offsetTop = target.offsetTop - 85;
                    window.scrollTo({
                        top: offsetTop,
                        behavior: 'smooth'
                    });
                }
            }
        });
    });

    // Sticky Navbar & Scroll Spy Logic
    const navbar = document.querySelector('.navbar.style-4');

    function handleStickyNavbar() {
        if (!navbar) return;
        const navbarOffset = navbar.offsetTop;
        if (window.scrollY > 100) {
            navbar.classList.add('nav-scroll');
            document.body.classList.add('navbar-sticky');
        } else {
            navbar.classList.remove('nav-scroll');
            document.body.classList.remove('navbar-sticky');
        }
    }

    function handleScrollSpy() {
        const navLinks = document.querySelectorAll('.navbar-nav .nav-link');
        const scrollPosition = window.scrollY + 130;

        let currentId = '';

        // 1. Identify all valid targets from the navbar links
        const targets = [];
        navLinks.forEach(link => {
            const href = link.getAttribute('href');
            if (href && href.includes('#')) {
                const id = href.split('#')[1];
                if (id) {
                    const element = document.getElementById(id);
                    if (element) {
                        targets.push(element);
                    }
                }
            }
        });

        // 2. Find which target is currently active
        targets.forEach(section => {
            const sectionTop = section.offsetTop;
            const sectionHeight = section.offsetHeight;

            if (scrollPosition >= sectionTop && scrollPosition < sectionTop + sectionHeight) {
                currentId = section.getAttribute('id');
            }
        });

        // Normalize current ID for comparison
        const currentNormalized = currentId ? currentId.toLowerCase() : '';

        // 3. Update active class
        navLinks.forEach(link => {
            const href = link.getAttribute('href');
            if (!href || !href.includes('#')) return;

            const linkHash = href.split('#')[1].toLowerCase();

            // Remove active from all first
            link.classList.remove('active');

            // Exact match check
            if (currentNormalized && linkHash === currentNormalized) {
                link.classList.add('active');
            }
        });
    }

    function onScrollOrLoad() {
        handleStickyNavbar();
        handleScrollSpy();
    }

    window.addEventListener('scroll', onScrollOrLoad);
    window.addEventListener('load', onScrollOrLoad);
    window.addEventListener('resize', onScrollOrLoad);

    // Run immediately
    onScrollOrLoad();

    // Initialize Screenshots Swiper
    setTimeout(function () {
        if (typeof Swiper !== 'undefined') {
            new Swiper('.screenshots-swiper', {
                spaceBetween: 0,
                slidesPerView: 5,
                pagination: false,
                navigation: false,
                mousewheel: false,
                keyboard: true,
                loop: true,
                autoplay: {
                    delay: 4000,
                    disableOnInteraction: false,
                },
                speed: 1000,
                centeredSlides: true,
                breakpoints: {
                    0: {
                        slidesPerView: 2,
                    },
                    480: {
                        slidesPerView: 2,
                    },
                    787: {
                        slidesPerView: 3,
                    },
                    991: {
                        slidesPerView: 3,
                    },
                    1200: {
                        slidesPerView: 5,
                    }
                }
            });
        }
    }, 100);
</script>

<!-- Swiper JS -->
<script src="https://cdn.jsdelivr.net/npm/swiper@8/swiper-bundle.min.js"></script>
</body>

</html>