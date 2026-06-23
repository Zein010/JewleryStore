<footer class="bg-white">
    <div class="container py-5">
        <div class="row g-4">
            
            <div class="col-lg-4 col-md-6" data-aos="fade-up">
                <h4 class="brand-font mb-4">
                    <?php if(!empty($site_settings['company_logo'])): ?>
                        <img src="<?= base_url('uploads/settings/' . $site_settings['company_logo']) ?>" alt="<?= esc($site_settings['company_name']) ?>" style="height: 80px;">
                    <?php else: ?>
                        <?= esc($site_settings['company_name'] ?? 'LUXE & CO.') ?>
                    <?php endif; ?>
                </h4>
                <p class="small text-muted pe-lg-5" style="line-height: 1.8;">
                    <?= nl2br(esc($site_settings['contact_address'] ?? 'Crafting timeless elegance.')) ?><br>
                    <?= esc($site_settings['contact_phone'] ?? '') ?><br>
                    <?= esc($site_settings['contact_email'] ?? '') ?>
                </p>
                <div class="mt-4">
                    <?php if(!empty($site_settings['instagram_link'])): ?>
                        <a href="<?= esc($site_settings['instagram_link']) ?>" class="text-dark me-3"><i class="fab fa-instagram"></i></a>
                    <?php endif; ?>
                    <?php if(!empty($site_settings['facebook_link'])): ?>
                        <a href="<?= esc($site_settings['facebook_link']) ?>" class="text-dark me-3"><i class="fab fa-facebook-f"></i></a>
                    <?php endif; ?>
                    <?php if(!empty($site_settings['pinterest_link'])): ?>
                        <a href="<?= esc($site_settings['pinterest_link']) ?>" class="text-dark"><i class="fab fa-pinterest-p"></i></a>
                    <?php endif; ?>
                </div>
            </div>

            <div class="col-lg-2 col-md-6" data-aos="fade-up" data-aos-delay="100">
                <h6 class="text-uppercase small fw-bold mb-4" style="letter-spacing: 2px;">Customer Care</h6>
                <ul class="list-unstyled footer-links">
                    <li><a href="<?= base_url('contact') ?>">Contact Us</a></li>
                    <!-- <li><a href="#">Track Your Order</a></li> -->
                    <!-- <li><a href="#">Book an Appointment</a></li> -->
                    <li><a href="<?= base_url('warranty') ?>">Craftsmanship & Care</a></li>
                    <!-- <li><a href="#">Jewelry Care Guide</a></li> -->
                </ul>
            </div>

            <div class="col-lg-2 col-md-6" data-aos="fade-up" data-aos-delay="200">
                <h6 class="text-uppercase small fw-bold mb-4" style="letter-spacing: 2px;">The Maison</h6>
                <ul class="list-unstyled footer-links">
                    <li><a href="<?= base_url('story') ?>">Our Story</a></li>
                    <!-- <li><a href="#">Store Locator</a></li> -->
                    <!-- <li><a href="#">Sustainability</a></li> -->
                    <!-- <li><a href="#">Careers</a></li> -->
                    <!-- <li><a href="#">Journal</a></li> -->
                </ul>
            </div>

            <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="300">
                <h6 class="text-uppercase small fw-bold mb-4" style="letter-spacing: 2px;">Newsletter</h6>
                <p class="small text-muted mb-4">Subscribe to receive the latest collection launches and private event invitations.</p>
                <form id="newsletterForm" class="position-relative">
                    <input type="email" class="form-control footer-input" placeholder="Your Email Address" required>
                    <button type="submit" class="btn-subscribe">Join</button>
                </form>
            </div>

        </div>

        <hr class="my-5 opacity-10">

        <div class="row align-items-center">
            <div class="col-md-6 text-center text-md-start">
                <p class="x-small text-muted mb-0" style="font-size: 0.75rem;">
                    &copy; <?= date('Y') ?> <?= esc($site_settings['company_name'] ?? 'LUXE & CO.') ?> | <a href="#" class="text-muted text-decoration-none">Privacy Policy</a> | <a href="#" class="text-muted text-decoration-none">Terms of Service</a>
                </p>
            </div>
            <div class="col-md-6 text-center text-md-end mt-3 mt-md-0">
                <span class="small text-muted text-uppercase" style="letter-spacing: 1px; font-size: 0.7rem;">Made with Passion in Beirut</span>
            </div>
        </div>
    </div>
</footer>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        $(document).ready(function() {
            // Init AOS
            AOS.init({ duration: 1000, once: true });

            // Smooth Scroll for "Discover Now"
            $('a[href^="#"]').on('click', function(event) {
                var target = $(this.getAttribute('href'));
                if( target.length ) {
                    event.preventDefault();
                    $('html, body').stop().animate({
                        scrollTop: target.offset().top - 100
                    }, 800);
                }
            });

            // Navbar scroll effect
            $(window).scroll(function() {
                if ($(window).scrollTop() > 50) {
                    $('.navbar').css('padding', '0.8rem 0');
                } else {
                    $('.navbar').css('padding', '1.5rem 0');
                }
            });
            
            // Handle missing images
            $('img').on('error', function() {
                // If asset image fails, try a placeholder or keep broken
                // $(this).attr('src', 'https://via.placeholder.com/400?text=Luxe+Image');
            });
        });
    </script>
    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {

            // Make sure Swiper library is loaded
            if (typeof Swiper === 'undefined') {
                console.warn('Swiper JS not loaded');
                return;
            }

            // Make sure the slider exists on the page
            const swiperContainer = document.querySelector('.showcaseSwiper');

            if (!swiperContainer) {
                return;
            }

            const swiper = new Swiper('.showcaseSwiper', {
                loop: true,
                centeredSlides: true,
                slidesPerView: 1.2,
                spaceBetween: 20,

                autoplay: {
                    delay: 5000,
                    disableOnInteraction: false
                },

                pagination: {
                    el: '.swiper-pagination',
                    clickable: true
                },

                navigation: {
                    nextEl: '.swiper-button-next',
                    prevEl: '.swiper-button-prev'
                },

                breakpoints: {
                    768: {
                        slidesPerView: 2
                    },
                    1200: {
                        slidesPerView: 3
                    }
                }
            });

            function playActiveVideo() {
                document
                    .querySelectorAll('.showcaseSwiper video')
                    .forEach(video => {
                        video.pause();
                    });

                const activeVideo = document.querySelector(
                    '.showcaseSwiper .swiper-slide-active video'
                );

                if (activeVideo) {
                    activeVideo.play().catch(() => {});
                }
            }

            playActiveVideo();

            swiper.on('slideChangeTransitionEnd', playActiveVideo);
        });
        </script>
</body>
</html>
