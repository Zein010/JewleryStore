<section class="container my-5 py-5">
    <div class="row mb-5">
        <div class="col-12 text-center" data-aos="fade-up">
            <h1 class="display-4 brand-font mb-3">My Favorites</h1>
            <p class="text-muted">Pieces you've saved to cherish later.</p>
        </div>
    </div>

    <?php if (empty($favorites)): ?>
        <div class="text-center py-5" data-aos="fade-up" data-aos-delay="100">
            <i class="far fa-heart fa-3x text-muted mb-4"></i>
            <h3 class="brand-font mb-3">Your favorites list is empty</h3>
            <p class="text-muted mb-4">Discover timeless pieces to add to your collection.</p>
            <a href="<?= base_url('shop') ?>" class="btn btn-dark rounded-0 px-4 py-2 text-uppercase" style="letter-spacing: 1px;">Explore Collection</a>
        </div>
    <?php else: ?>
        <div class="row g-4">
            <?php foreach ($favorites as $product): ?>
                <div class="col-sm-6 col-lg-3" data-aos="fade-up">
                    <div class="product-card h-100 border-0 position-relative">
                        <div class="product-img-wrapper mb-3 position-relative" style="background: #fafafa; padding: 20px; text-align: center; height: 350px; display: flex; align-items: center; justify-content: center;">
                            <a href="<?= base_url('product/' . $product['slug']) ?>">
                                <img src="<?= base_url('uploads/products/' . ($product['image_path'] ?? $product['image'])) ?>" class="img-fluid" alt="<?= esc($product['name']) ?>" style="max-height: 100%; max-width: 100%; object-fit: contain; transition: transform 0.5s ease;">
                            </a>
                            <div class="product-action position-absolute bottom-0 start-50 translate-middle-x mb-3" style="opacity: 0; transition: 0.3s; z-index: 10;">
                                <form action="<?= base_url('favorites/toggle') ?>" method="post" class="d-inline">
                                    <input type="hidden" name="product_id" value="<?= $product['id'] ?>">
                                    <button type="submit" class="btn btn-danger btn-sm rounded-circle d-inline-flex align-items-center justify-content-center" style="width: 40px; height: 40px; box-shadow: 0 4px 15px rgba(0,0,0,0.1);" title="Remove from Favorites">
                                        <i class="fas fa-heart"></i>
                                    </button>
                                </form>
                            </div>
                        </div>
                        <div class="product-info text-center px-2 pb-3">
                            <h5 class="brand-font mb-2">
                                <a href="<?= base_url('product/' . $product['slug']) ?>" class="text-dark text-decoration-none"><?= esc($product['name']) ?></a>
                            </h5>
                            <p class="text-muted mb-0">$<?= number_format($product['price']) ?></p>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</section>

<style>
    .product-card:hover .product-action {
        opacity: 1 !important;
    }
    .product-card:hover .product-img-wrapper img {
        transform: scale(1.05);
    }
</style>
