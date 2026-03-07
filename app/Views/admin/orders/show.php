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

<div class="row align-items-start">
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
                <?php if (!empty($order['customer_note'])): ?>
                    <hr>
                    <p><strong>Customer Note:</strong><br>
                        <span class="text-muted fst-italic"><?= nl2br(esc($order['customer_note'])) ?></span>
                    </p>
                <?php endif; ?>
                <hr>
                <hr>
                <form action="<?= base_url('admin/orders/update-status/' . $order['id']) ?>" method="post" class="mt-3">
                    <label class="form-label" style="font-weight: bold;">Update Status:</label>
                    <div class="input-group">
                        <select class="form-select" name="status">
                            <option value="pending" <?= $order['status'] === 'pending' ? 'selected' : '' ?>>Pending</option>
                            <option value="in_progress" <?= $order['status'] === 'in_progress' ? 'selected' : '' ?>>In Progress</option>
                            <option value="completed" <?= $order['status'] === 'completed' ? 'selected' : '' ?>>Completed</option>
                            <option value="cancelled" <?= $order['status'] === 'cancelled' ? 'selected' : '' ?>>Cancelled</option>
                        </select>
                        <button class="btn btn-outline-primary" type="submit">Update</button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Admin Notes -->
        <div class="card shadow mt-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Internal Admin Notes</h6>
            </div>
            <div class="card-body">
                <form action="<?= base_url('admin/orders/update-note/' . $order['id']) ?>" method="post">
                    <div class="mb-3">
                        <textarea class="form-control" name="admin_note" rows="4" placeholder="Add private notes about this order here..."><?= esc($order['admin_note'] ?? '') ?></textarea>
                    </div>
                    <button type="submit" class="btn btn-primary btn-sm"><i class="bi bi-save me-1"></i> Save Note</button>
                </form>
            </div>
        </div>

        <!-- Order Status Timeline -->
        <div class="card shadow mt-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Order Status Timeline</h6>
            </div>
            <div class="card-body">
                <?php if (!empty($logs)): ?>
                    <ul class="list-group list-group-flush" style="font-size: 0.9rem;">
                        <!-- The initial creation implicitly acts as the first entry, but we only list manual logs -->
                        <li class="list-group-item px-0">
                            <div class="d-flex w-100 justify-content-between text-muted mb-1">
                                <small>Order Placed</small>
                                <small><?= date('M d, Y H:i', strtotime($order['created_at'])) ?></small>
                            </div>
                        </li>
                        <?php foreach ($logs as $log): ?>
                            <li class="list-group-item px-0 pb-0">
                                <div class="d-flex w-100 justify-content-between mb-1">
                                    <strong><?= esc($log['admin_name']) ?></strong>
                                    <small class="text-muted"><?= date('M d, Y H:i', strtotime($log['created_at'])) ?></small>
                                </div>
                                <p class="mb-1 text-muted">
                                    Changed status from 
                                    <span class="badge bg-secondary"><?= esc(ucfirst($log['old_status'])) ?></span> 
                                    to 
                                    <span class="badge bg-primary"><?= esc(ucfirst($log['new_status'])) ?></span>
                                </p>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                <?php else: ?>
                    <p class="text-muted small mb-0">No manual status changes have been recorded yet.</p>
                <?php endif; ?>
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
