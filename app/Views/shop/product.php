    <section class="container my-5 py-5">
        <div class="row align-items-center">
            <div class="col-md-6 mb-4 mb-md-0" data-aos="fade-right">
                <?php if (!empty($images) && count($images) > 0): ?>
                    <div id="productCarousel" class="carousel slide" data-bs-ride="carousel">
                        <div class="carousel-inner">
                            <?php foreach ($images as $index => $img): ?>
                                <div class="carousel-item <?= $index === 0 ? 'active' : '' ?>">
                                    <div class="product-img-wrapper" style="height: 500px; background: #fafafa; display: flex; align-items: center; justify-content: center;">
                                        <img src="<?= base_url('uploads/products/' . $img['image']) ?>" class="d-block w-100" alt="<?= esc($product['name']) ?>" style="max-height: 100%; max-width: 100%; object-fit: contain;">
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                        <?php if (count($images) > 1): ?>
                            <button class="carousel-control-prev" type="button" data-bs-target="#productCarousel" data-bs-slide="prev">
                                <span class="carousel-control-prev-icon" aria-hidden="true" style="background-color: #333; border-radius: 50%;"></span>
                                <span class="visually-hidden">Previous</span>
                            </button>
                            <button class="carousel-control-next" type="button" data-bs-target="#productCarousel" data-bs-slide="next">
                                <span class="carousel-control-next-icon" aria-hidden="true" style="background-color: #333; border-radius: 50%;"></span>
                                <span class="visually-hidden">Next</span>
                            </button>
                        <?php endif; ?>
                    </div>
                    <!-- Thumbnails -->
                    <?php if (count($images) > 1): ?>
                        <div class="row mt-2 g-2">
                            <?php foreach ($images as $index => $img): ?>
                                <div class="col-2">
                                    <img src="<?= base_url('uploads/products/' . $img['image']) ?>" 
                                         class="img-thumbnail" 
                                         style="cursor: pointer; opacity: 0.6; height: 60px; width: 100%; object-fit: cover;"
                                         onclick="document.querySelector('#productCarousel').querySelector('.carousel-item.active').classList.remove('active'); document.querySelectorAll('#productCarousel .carousel-item')[<?= $index ?>].classList.add('active');"
                                         onmouseover="this.style.opacity=1" 
                                         onmouseout="this.style.opacity=0.6">
                                </div>
                            <?php endforeach; ?>
                        </div>
                    <?php endif; ?>
                <?php else: ?>
                    <div class="product-img-wrapper" style="height: 500px; background: #fafafa; display: flex; align-items: center; justify-content: center;">
                        <img src="<?= base_url('uploads/products/' . $product['image']) ?>" alt="<?= esc($product['name']) ?>" style="max-height: 80%; max-width: 100%;">
                    </div>
                <?php endif; ?>
            </div>
            
            <div class="col-md-1"></div>

            <div class="col-md-5" data-aos="fade-left">
                <p class="text-uppercase text-muted small mb-2" style="letter-spacing: 2px;">Fine Jewelry</p>
                <h1 class="display-5 brand-font mb-3"><?= esc($product['name']) ?></h1>
                <p class="display-6 text-warning mb-4" style="color: var(--gold) !important;">$<?= number_format($product['price']) ?></p>
                
                <div class="text-muted mb-4" style="line-height: 1.8;">
                    <?= $product['description'] ?? 'Indulge in the brilliance of hand-selected diamonds and 18K gold. This specific piece embodies the heritage of Luxe & Co, designed to be worn and cherished for generations.' ?>
                </div>

                <div class="mb-4">
                    <button class="btn btn-dark rounded-0 px-5 py-3 text-uppercase" style="letter-spacing: 1px;">Add to Cart</button>
                    <button class="btn btn-outline-dark rounded-0 px-3 py-3 ms-2"><i class="far fa-heart"></i></button>
                </div>

                <div class="accordion accordion-flush mt-5" id="productDetails">
                    <div class="accordion-item">
                        <h2 class="accordion-header">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#details">
                                Product Details
                            </button>
                        </h2>
                        <div id="details" class="accordion-collapse collapse" data-bs-parent="#productDetails">
                            <div class="accordion-body small text-muted">
                                <?php 
                                $details = json_decode($product['details'] ?? '[]', true);
                                if (!empty($details)): 
                                    foreach ($details as $key => $value):
                                ?>
                                    <strong><?= esc($key) ?>:</strong> <?= esc($value) ?><br>
                                <?php 
                                    endforeach; 
                                else:
                                ?>
                                    No additional details available.
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </section>

    <!-- Related Products could go here -->
