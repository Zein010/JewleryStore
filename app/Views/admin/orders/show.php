<div class="row mb-4 align-items-center">
    <div class="col-md-6">
        <h1 class="h3 mb-0 text-gray-800">Order Details #<?= $order['id'] ?></h1>
    </div>
    <div class="col-md-6 text-end">
        <a href="<?= base_url('admin/orders') ?>" class="btn btn-secondary">
            <i class="bi bi-arrow-left"></i> Back to Orders
        </a>
    </div>
</div>

<div class="row">
    <!-- Order Info -->
    <div class="col-lg-4 mb-4">
        <div class="card shadow h-100">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Customer Information</h6>
            </div>
            <div class="card-body">
                <p><strong>Name:</strong> <?= esc($order['customer_name']) ?></p>
                <p><strong>Email:</strong> <?= esc($order['customer_email']) ?></p>
                <p><strong>Phone:</strong> <?= esc($order['phone'] ?? 'N/A') ?></p>
                <p><strong>Country:</strong> <?= esc($order['country'] ?? 'N/A') ?></p>
                <p><strong>Address:</strong><br><?= nl2br(esc($order['shipping_address'])) ?></p>
                <hr>
                <p><strong>Order Date:</strong> <?= date('M d, Y H:i', strtotime($order['created_at'])) ?></p>
                <p><strong>Status:</strong> 
                    <span class="badge bg-<?= $order['status'] === 'completed' ? 'success' : ($order['status'] === 'cancelled' ? 'danger' : 'warning') ?>">
                        <?= ucfirst($order['status']) ?>
                    </span>
                </p>
            </div>
        </div>
    </div>

    <!-- Order Items -->
    <div class="col-lg-8 mb-4">
        <div class="card shadow h-100">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Order Items</h6>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered" width="100%" cellspacing="0">
                        <thead class="table-light">
                            <tr>
                                <th>Product</th>
                                <th>Price</th>
                                <th>Quantity</th>
                                <th>Subtotal</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($items as $item): ?>
                                <tr>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <?php if ($item['product_image']): ?>
                                                <img src="<?= base_url('uploads/products/' . $item['product_image']) ?>" 
                                                     alt="Product" 
                                                     style="width: 50px; height: 50px; object-fit: cover; margin-right: 10px;">
                                            <?php endif; ?>
                                            <div>
                                                <h6 class="mb-0"><?= esc($item['product_name'] ?? 'Unknown Product') ?></h6>
                                                <?php if (!empty($item['customization_text'])): ?>
                                                    <small class="text-dark d-block mt-1">
                                                        <i class="bi bi-pencil-fill me-1"></i> <strong>Customization:</strong> "<?= esc($item['customization_text']) ?>"
                                                    </small>
                                                <?php endif; ?>
                                                <?php if ($item['product_slug']): ?>
                                                    <a href="<?= base_url('product/' . $item['product_slug']) ?>" target="_blank" class="small">View Product</a>
                                                <?php endif; ?>
                                            </div>
                                        </div>
                                    </td>
                                    <td>$<?= number_format($item['price'], 2) ?></td>
                                    <td><?= $item['quantity'] ?></td>
                                    <td>$<?= number_format($item['price'] * $item['quantity'], 2) ?></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                        <tfoot class="table-light">
                            <tr>
                                <th colspan="3" class="text-end">Total Amount:</th>
                                <th class="text-primary h5">$<?= number_format($order['total_amount'], 2) ?></th>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
