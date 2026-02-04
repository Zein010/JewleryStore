    <div class="category-banner" data-aos="fade-in">
        <div class="container">
            <h1 class="display-4"><?= esc($category_name ?? 'Collections') ?></h1>
            <p class="text-muted col-lg-6 mx-auto">Discover a curation of handcrafted jewelry, from eternal diamond bands to signature gold designs.</p>
        </div>
    </div>

    <div class="container mb-5">
        <div class="row">
            
            <aside class="col-lg-3 d-none d-lg-block" data-aos="fade-right">
                <?php
                // Helper to generate filter URLs
                $buildFilterUrl = function($newParams) use ($current_slug) {
                    $params = $_GET;
                    foreach ($newParams as $key => $value) {
                        if ($value === null) {
                            unset($params[$key]);
                        } else {
                            $params[$key] = $value;
                        }
                    }
                    
                    $baseUrl = $current_slug ? base_url('shop/category/' . $current_slug) : base_url('shop');
                    return $baseUrl . '?' . http_build_query($params);
                };
                ?>
                <?php if (!empty($dynamic_filters)): ?>
                    <?php foreach ($dynamic_filters as $key => $values): ?>
                        <span class="filter-title"><?= esc($key) ?></span>
                        <ul class="filter-list">
                            <?php foreach ($values as $value): ?>
                                <?php 
                                    $facetFilter = [$key => $value];
                                    // preserve other filters
                                ?>
                                <li>
                                    <a href="<?= $buildFilterUrl($facetFilter) ?>" 
                                       class="<?= ($current_filters[$key] ?? '') == $value ? 'text-warning' : '' ?>">
                                       <?= esc($value) ?>
                                    </a>
                                </li>
                            <?php endforeach; ?>
                        </ul>
                    <?php endforeach; ?>
                <?php endif; ?>

                <span class="filter-title">Price Range</span>
                <ul class="filter-list">
                    <?php if (!empty($price_ranges)): ?>
                        <?php foreach ($price_ranges as $range): ?>
                            <li>
                                <a href="<?= $buildFilterUrl(['min_price' => $range['min'], 'max_price' => $range['max']]) ?>" 
                                   class="<?= ($current_filters['min_price'] ?? '') == $range['min'] && ($current_filters['max_price'] ?? '') == $range['max'] ? 'text-warning' : '' ?>">
                                   <?= $range['label'] ?>
                                </a>
                            </li>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <li><span class="text-muted small">No prices available</span></li>
                    <?php endif; ?>
                    <li><a href="<?= $current_slug ? base_url('shop/category/' . $current_slug) : base_url('shop') ?>" class="text-muted">Clear Filters</a></li>
                </ul>
            </aside>

            <div class="col-lg-9">
                <div class="d-flex justify-content-between align-items-center mb-4 pb-3 border-bottom">
                    <span class="small text-muted">Showing <?= count($products) ?> Exquisite Pieces</span>
                    <form id="sortForm" method="get">
                        <?php foreach($current_filters as $key => $val): ?>
                            <?php if($key != 'sort' && $val): ?>
                                <input type="hidden" name="<?= $key ?>" value="<?= $val ?>">
                            <?php endif; ?>
                        <?php endforeach; ?>
                        <select class="form-select w-auto border-0 bg-transparent small fw-bold" name="sort" onchange="document.getElementById('sortForm').submit()" style="cursor:pointer;">
                            <option value="newest" <?= ($current_filters['sort'] ?? '') == 'newest' ? 'selected' : '' ?>>Sort By: Newest Arrivals</option>
                            <option value="price_low" <?= ($current_filters['sort'] ?? '') == 'price_low' ? 'selected' : '' ?>>Price: Low to High</option>
                            <option value="price_high" <?= ($current_filters['sort'] ?? '') == 'price_high' ? 'selected' : '' ?>>Price: High to Low</option>
                        </select>
                    </form>
                </div>

                <div class="row">
                    <?php if (!empty($products)): ?>
                        <?php foreach ($products as $product): ?>
                            <div class="col-md-6 col-xl-4 product-item" data-aos="fade-up" data-aos-delay="100">
                                <div class="product-img-box">
                                    <img src="<?= base_url('uploads/products/' . $product['image']) ?>" alt="<?= esc($product['name']) ?>">
                                    <a href="<?= base_url('product/' . $product['slug']) ?>" class="quick-add">Quick View</a>
                                </div>
                                <h6 class="mt-3 brand-font mb-1"><?= esc($product['name']) ?></h6>
                                <p class="price">$<?= number_format($product['price']) ?></p>
                            </div>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <div class="col-12 text-center py-5">
                            <h4 class="text-muted fw-light">No products found.</h4>
                            <p class="text-muted small">Try adjusting your filters or check back later.</p>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>

    <style>
         /* Category Header */
         .category-banner {
            padding: 80px 0 40px 0;
            background-color: #fdfcfb;
            text-align: center;
            border-bottom: 1px solid #f0f0f0;
            margin-bottom: 50px;
        }

        /* Filter Sidebar Styling */
        .filter-section { border-right: 1px solid #eee; padding-right: 30px; }
        .filter-title { font-size: 0.8rem; font-weight: 600; text-transform: uppercase; letter-spacing: 1px; margin-bottom: 20px; display: block; }
        .filter-list { list-style: none; padding: 0; margin-bottom: 30px; }
        .filter-list li { margin-bottom: 10px; font-size: 0.9rem; color: #666; cursor: pointer; transition: 0.3s; }
        .filter-list li:hover { color: #bca374; padding-left: 5px; }

        /* Product Card Updates */
        .product-item { margin-bottom: 40px; transition: 0.4s; }
        .product-img-box {
            background-color: #f9f9f9;
            padding: 40px;
            position: relative;
            overflow: hidden;
            display: flex;
            align-items: center;
            justify-content: center;
            height: 350px;
        }
        .product-img-box img { width: 100%; object-fit: contain; transition: 0.6s ease; }
        .product-item:hover img { transform: scale(1.1); }
        
        .quick-add {
            position: absolute;
            bottom: -50px;
            left: 0;
            width: 100%;
            background: rgba(188, 163, 116, 0.9);
            color: white;
            text-align: center;
            padding: 12px;
            text-transform: uppercase;
            font-size: 0.7rem;
            letter-spacing: 1px;
            transition: 0.4s;
            text-decoration: none;
        }
        .product-item:hover .quick-add { bottom: 0; }

        .price { color: #bca374; font-weight: 500; font-size: 1rem; }
    </style>
