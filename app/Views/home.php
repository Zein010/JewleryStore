    <header class="hero-section">
        <div class="hero-content" data-aos="fade-up" data-aos-duration="1200">
            <p class="text-uppercase small mb-3" style="letter-spacing: 4px;">Craftsmanship & Heritage</p>
            <h1>Artistry in Every Curve</h1>
            <a href="<?= base_url('shop') ?>" class="btn-luxury">Discover Now</a>
        </div>
    </header>

    <section class="container my-5 py-5">
        <div class="text-center mb-5" data-aos="fade-up">
            <h2 class="display-6">Shop by Category</h2>
            <div style="width: 40px; height: 2px; background: var(--gold); margin: 15px auto;"></div>
        </div>
        <div class="row g-4">
            <div class="col-md-6" data-aos="zoom-in-right">
                <div class="category-card" onclick="location.href='<?= base_url('shop/category/rings') ?>'">
                    <img src="<?= base_url('assets/images/1.png') ?>" alt="Rings">
                    <div class="category-overlay">
                        <h3>Rings</h3>
                        <a href="<?= base_url('shop/category/rings') ?>" class="category-link">View Collection</a>
                    </div>
                </div>
            </div>
            <div class="col-md-6" data-aos="zoom-in-left">
                <div class="category-card" onclick="location.href='<?= base_url('shop/category/necklaces') ?>'">
                    <img src="<?= base_url('assets/images/2.png') ?>" alt="Necklaces">
                    <div class="category-overlay">
                        <h3>Necklaces</h3>
                        <a href="<?= base_url('shop/category/necklaces') ?>" class="category-link">View Collection</a>
                    </div>
                </div>
            </div>
            <div class="col-md-4" data-aos="fade-up" data-aos-delay="100">
                <div class="category-card" style="height: 300px;" onclick="location.href='<?= base_url('shop/category/bracelets') ?>'">
                    <img src="<?= base_url('assets/images/3.png') ?>" alt="Bracelets" style="width: 60%;">
                    <div class="category-overlay">
                        <h4>Bracelets</h4>
                        <a href="<?= base_url('shop/category/bracelets') ?>" class="category-link">Shop</a>
                    </div>
                </div>
            </div>
            <div class="col-md-4" data-aos="fade-up" data-aos-delay="200">
                <div class="category-card" style="height: 300px;" onclick="location.href='<?= base_url('shop/category/earrings') ?>'">
                    <img src="<?= base_url('assets/images/4.png') ?>" alt="Earrings" style="width: 60%;">
                    <div class="category-overlay">
                        <h4>Earrings</h4>
                        <a href="<?= base_url('shop/category/earrings') ?>" class="category-link">Shop</a>
                    </div>
                </div>
            </div>
            <div class="col-md-4" data-aos="fade-up" data-aos-delay="300">
                <div class="category-card" style="height: 300px;" onclick="location.href='<?= base_url('shop/category/new-in') ?>'">
                    <img src="<?= base_url('assets/images/5.png') ?>" alt="New" style="width: 60%;">
                    <div class="category-overlay">
                        <h4>New In</h4>
                        <a href="<?= base_url('shop/category/new-in') ?>" class="category-link">Explore</a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section id="shop" class="container my-5 py-5">
        <div class="text-center mb-5" data-aos="fade-up">
            <h2 class="display-6">Featured Creations</h2>
        </div>
        <div class="row">
            <?php if (!empty($featured_products)): ?>
                <?php foreach ($featured_products as $product): ?>
                    <div class="col-md-4 product-card" data-aos="fade-up" data-aos-delay="100">
                        <div class="product-img-wrapper">
                            <img src="<?= base_url('uploads/products/' . $product['image']) ?>" alt="<?= esc($product['name']) ?>">
                        </div>
                        <h6 class="brand-font"><?= esc($product['name']) ?></h6>
                        <p class="product-price">$<?= number_format($product['price']) ?></p>
                        <a href="<?= base_url('product/' . $product['slug']) ?>" class="btn btn-sm btn-outline-dark rounded-0 mt-2">View</a>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <!-- Static Fallback if no DB data yet -->
                <div class="col-md-4 product-card" data-aos="fade-up" data-aos-delay="100">
                    <div class="product-img-wrapper">
                        <img src="<?= base_url('assets/images/1.png') ?>" alt="Product 1">
                    </div>
                    <h6 class="brand-font">Ribbon Gold Ring</h6>
                    <p class="product-price">$1,850</p>
                </div>
                <div class="col-md-4 product-card" data-aos="fade-up" data-aos-delay="200">
                    <div class="product-img-wrapper">
                        <img src="<?= base_url('assets/images/2.png') ?>" alt="Product 2">
                    </div>
                    <h6 class="brand-font">Diamond Aura Necklace</h6>
                    <p class="product-price">$3,200</p>
                </div>
                <div class="col-md-4 product-card" data-aos="fade-up" data-aos-delay="300">
                    <div class="product-img-wrapper">
                        <img src="<?= base_url('assets/images/3.png') ?>" alt="Product 3">
                    </div>
                    <h6 class="brand-font">Signature Chain Bangle</h6>
                    <p class="product-price">$2,100</p>
                </div>
            <?php endif; ?>
        </div>
    </section>

    <style>
        /* CSS from index.html moved here that is specific to home */
        .hero-section {
            height: 85vh;
            background-color: #fdfcfb;
            display: flex;
            align-items: center;
            justify-content: center;
            text-align: center;
            position: relative;
        }
        .hero-content h1 {
            font-size: 4rem;
            margin-bottom: 20px;
        }
        .btn-luxury {
            background: var(--gold);
            color: white;
            padding: 14px 40px;
            border-radius: 0;
            text-transform: uppercase;
            font-size: 0.8rem;
            letter-spacing: 2px;
            border: none;
            transition: 0.4s;
            text-decoration: none;
            display: inline-block;
        }
        .btn-luxury:hover {
            background: #a38b5d;
            color: white;
            transform: translateY(-3px);
        }

        /* --- Categories Section --- */
        .category-card {
            position: relative;
            height: 400px;
            overflow: hidden;
            background: var(--light-gray);
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
        }
        .category-card img {
            width: 70%;
            transition: transform 1.2s cubic-bezier(0.15, 0, 0.15, 1);
        }
        .category-overlay {
            position: absolute;
            width: 100%;
            height: 100%;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            background: rgba(255, 255, 255, 0);
            transition: 0.5s;
        }
        .category-card:hover img { transform: scale(1.1); }
        .category-card:hover .category-overlay { background: rgba(255, 255, 255, 0.1); }
        
        .category-link {
            color: var(--dark);
            text-decoration: none;
            text-transform: uppercase;
            font-size: 0.7rem;
            font-weight: 600;
            border-bottom: 1px solid var(--gold);
            opacity: 0;
            transform: translateY(10px);
            transition: 0.4s;
        }
        .category-card:hover .category-link { opacity: 1; transform: translateY(0); }

        /* --- Product Grid --- */
        .product-card { border: none; text-align: center; margin-bottom: 40px; }
        .product-img-wrapper {
            background: var(--light-gray);
            padding: 40px;
            margin-bottom: 15px;
            height: 320px;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .product-img-wrapper img { width: 100%; object-fit: contain; max-height: 100%; }
        .product-price { color: var(--gold); font-weight: 500; }
    </style>
