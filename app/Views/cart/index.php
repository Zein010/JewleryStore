<section class="container my-5 py-5">
    <div class="row" data-aos="fade-up">
        <div class="col-12">
            <h1 class="display-5 brand-font mb-5 text-center">Your Shopping Cart</h1>
        </div>
    </div>

    <?php if (session()->getFlashdata('success')): ?>
        <div class="alert alert-success rounded-0">
            <?= session()->getFlashdata('success') ?>
        </div>
    <?php endif; ?>

    <?php if (empty($cart)): ?>
        <div class="text-center py-5">
            <h3 class="fw-light mb-4">Your cart is empty</h3>
            <a href="<?= base_url('/shop') ?>" class="btn btn-dark rounded-0 px-4 py-3 text-uppercase">Continue Shopping</a>
        </div>
    <?php else: ?>
        <div class="row">
            <div class="col-lg-8">
                <div class="table-responsive">
                    <table class="table align-middle">
                        <thead class="bg-light">
                            <tr>
                                <th scope="col" class="py-3 ps-3">Product</th>
                                <th scope="col" class="py-3">Price</th>
                                <th scope="col" class="py-3">Quantity</th>
                                <th scope="col" class="py-3">Total</th>
                                <th scope="col" class="py-3 text-end pe-3">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($cart as $id => $item): ?>
                                <tr>
                                    <td class="ps-3">
                                        <div class="d-flex align-items-center">
                                            <img src="<?= base_url('uploads/products/' . ($item['image'] ?? '1.png')) ?>" 
                                                 alt="<?= esc($item['name']) ?>" 
                                                 style="width: 80px; height: 80px; object-fit: contain; background: #f8f9fa;">
                                            <div class="ms-3">
                                                <h6 class="mb-0 brand-font"><a href="<?= base_url('product/' . $item['slug']) ?>" class="text-decoration-none text-dark"><?= esc($item['name']) ?></a></h6>
                                                <?php if (!empty($item['customization_text'])): ?>
                                                    <small class="text-muted d-block mt-1">
                                                        <i class="bi bi-pencil-fill me-1"></i> "<?= esc($item['customization_text']) ?>"
                                                    </small>
                                                <?php endif; ?>
                                            </div>
                                        </div>
                                    </td>
                                    <td>$<?= number_format($item['price'], 2) ?></td>
                                    <td>
                                        <form action="<?= base_url('cart/update') ?>" method="post" class="d-flex align-items-center">
                                            <input type="hidden" name="product_id" value="<?= $id ?>">
                                            <input type="number" name="quantity" value="<?= $item['quantity'] ?>" min="1" class="form-control rounded-0 text-center" style="width: 70px;">
                                            <button type="submit" class="btn btn-sm btn-link text-dark"><i class="fas fa-sync-alt"></i></button>
                                        </form>
                                    </td>
                                    <td>$<?= number_format($item['price'] * $item['quantity'], 2) ?></td>
                                    <td class="text-end pe-3">
                                        <a href="<?= base_url('cart/remove/' . $id) ?>" class="text-danger" onclick="return confirm('Are you sure?')"><i class="fas fa-trash-alt"></i></a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
            
            <div class="col-lg-4">
                <div class="bg-light p-4">
                    <h4 class="brand-font mb-4">Order Summary</h4>
                    <div class="d-flex justify-content-between mb-3">
                        <span>Subtotal</span>
                        <span class="fw-bold">$<?= number_format($total, 2) ?></span>
                    </div>
                    <hr>
                    <div class="d-flex justify-content-between mb-4">
                        <span class="fs-5">Total</span>
                        <span class="fs-5 fw-bold">$<?= number_format($total, 2) ?></span>
                    </div>
                    
                    <a href="<?= base_url('checkout') ?>" class="btn btn-dark w-100 rounded-0 py-3 text-uppercase mb-3" style="letter-spacing: 1px;">
                        Proceed to Checkout
                    </a>
                    
                    <a href="<?= base_url('cart/clear') ?>" class="btn btn-outline-danger w-100 rounded-0 py-2 text-uppercase" onclick="return confirm('Clear entire cart?')">
                        Clear Cart
                    </a>
                </div>
            </div>
        </div>
    <?php endif; ?>
</section>
