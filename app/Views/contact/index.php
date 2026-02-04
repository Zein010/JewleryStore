<div class="container my-5 py-5">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="text-center mb-5" data-aos="fade-up">
                <p class="text-uppercase text-muted small mb-2" style="letter-spacing: 2px;">Get in Touch</p>
                <h1 class="display-5 brand-font mb-4">Contact Us</h1>
                <p class="lead text-muted">We would love to hear from you. Visit our boutique or send us a message.</p>
            </div>

            <div class="row g-5">
                <div class="col-md-5" data-aos="fade-right">
                    <div class="p-4 bg-light h-100">
                        <h4 class="brand-font mb-4">Boutique Information</h4>
                        
                        <div class="mb-4">
                            <h6 class="text-uppercase small text-muted mb-2">Address</h6>
                            <p><?= nl2br(esc($site_settings['contact_address'] ?? '123 Luxury Ave, New York, NY 10012')) ?></p>
                        </div>

                        <div class="mb-4">
                            <h6 class="text-uppercase small text-muted mb-2">Phone</h6>
                            <p><a href="tel:<?= esc($site_settings['contact_phone'] ?? '') ?>" class="text-decoration-none text-dark"><?= esc($site_settings['contact_phone'] ?? '+1 (555) 123-4567') ?></a></p>
                        </div>

                        <div class="mb-4">
                            <h6 class="text-uppercase small text-muted mb-2">Email</h6>
                            <p><a href="mailto:<?= esc($site_settings['contact_email'] ?? '') ?>" class="text-decoration-none text-dark"><?= esc($site_settings['contact_email'] ?? 'concierge@luxe.co') ?></a></p>
                        </div>

                        <div class="mt-5">
                            <h6 class="text-uppercase small text-muted mb-3">Follow Us</h6>
                            <div class="d-flex gap-3">
                                <?php if (!empty($site_settings['facebook_link'])): ?>
                                    <a href="<?= esc($site_settings['facebook_link']) ?>" class="text-dark fs-5"><i class="fab fa-facebook-f"></i></a>
                                <?php endif; ?>
                                <?php if (!empty($site_settings['instagram_link'])): ?>
                                    <a href="<?= esc($site_settings['instagram_link']) ?>" class="text-dark fs-5"><i class="fab fa-instagram"></i></a>
                                <?php endif; ?>
                                <?php if (!empty($site_settings['pinterest_link'])): ?>
                                    <a href="<?= esc($site_settings['pinterest_link']) ?>" class="text-dark fs-5"><i class="fab fa-pinterest"></i></a>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-7" data-aos="fade-left">
                    <?php if (session()->getFlashdata('success')): ?>
                        <div class="alert alert-success rounded-0 mb-4">
                            <?= session()->getFlashdata('success') ?>
                        </div>
                    <?php endif; ?>

                    <form action="<?= base_url('contact/send') ?>" method="post">
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="name" class="form-label font-serif text-muted">Name</label>
                                <input type="text" class="form-control rounded-0 py-2" id="name" name="name" required>
                            </div>
                            <div class="col-md-6">
                                <label for="email" class="form-label font-serif text-muted">Email</label>
                                <input type="email" class="form-control rounded-0 py-2" id="email" name="email" required>
                            </div>
                        </div>
                        
                        <div class="mb-3">
                            <label for="subject" class="form-label font-serif text-muted">Subject</label>
                            <input type="text" class="form-control rounded-0 py-2" id="subject" name="subject" required>
                        </div>

                        <div class="mb-4">
                            <label for="message" class="form-label font-serif text-muted">Message</label>
                            <textarea class="form-control rounded-0" id="message" name="message" rows="6" required></textarea>
                        </div>

                        <button type="submit" class="btn btn-dark rounded-0 px-5 py-3 text-uppercase" style="letter-spacing: 1px;">Send Message</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
