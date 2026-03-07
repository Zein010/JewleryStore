    <nav class="navbar navbar-expand-lg sticky-top">
        <div class="container">
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mainNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="mainNav">
                <ul class="navbar-nav mx-auto align-items-center">
                    <li class="nav-item"><a class="nav-link" href="<?= base_url('shop') ?>">Collections</a></li>
                    
                    <?php if (!empty($header_category)): ?>
                        <li class="nav-item"><a class="nav-link" href="<?= base_url('shop/category/' . $header_category['slug']) ?>"><?= esc($header_category['name']) ?></a></li>
                    <?php endif; ?>
                    <li class="nav-item">
                        <a class="navbar-brand brand-font mx-4" href="<?= base_url('/') ?>">
                            <?php if (!empty($site_settings['company_logo'])): ?>
                                <img src="<?= base_url('uploads/settings/' . $site_settings['company_logo']) ?>" alt="<?= esc($site_settings['company_name']) ?>" style="max-height: 50px;">
                            <?php else: ?>
                                <?= esc($site_settings['company_name'] ?? 'LUXE & CO.') ?>
                            <?php endif; ?>
                        </a>
                    </li>
                    <li class="nav-item"><a class="nav-link" href="<?= base_url('shop/category/atelier') ?>">The Atelier</a></li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?= base_url('favorites') ?>">
                            <i class="far fa-heart"></i> Favorites
                        </a>
                    </li>
                    <li class="nav-item"><a class="nav-link" href="<?= base_url('contact') ?>">Contact</a></li>
                </ul>
            </div>
        </div>
    </nav>
