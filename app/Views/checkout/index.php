<section class="container my-5 py-5">
    <div class="row">
        <div class="col-12 text-center mb-5">
            <h1 class="display-5 brand-font">Checkout</h1>
        </div>
    </div>

    <?php if (session()->getFlashdata('errors')): ?>
        <div class="alert alert-danger rounded-0">
            <ul>
                <?php foreach (session()->getFlashdata('errors') as $error): ?>
                    <li><?= esc($error) ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
    <?php endif; ?>

    <form action="<?= base_url('checkout/process') ?>" method="post">
        <div class="row">
            <div class="col-md-7">
                <div class="bg-light p-4 mb-4">
                    <h4 class="brand-font mb-4">Billing & Shipping Details</h4>
                    <div class="row g-3">
                        <div class="col-sm-6">
                            <label for="firstName" class="form-label">First name <span class="text-danger">*</span></label>
                            <input type="text" class="form-control rounded-0" id="firstName" name="firstName" value="<?= old('firstName') ?>" required>
                        </div>
                        <div class="col-sm-6">
                            <label for="lastName" class="form-label">Last name <span class="text-danger">*</span></label>
                            <input type="text" class="form-control rounded-0" id="lastName" name="lastName" value="<?= old('lastName') ?>" required>
                        </div>
                        <div class="col-12">
                            <label for="email" class="form-label">Email <span class="text-danger">*</span></label>
                            <input type="email" class="form-control rounded-0" id="email" name="email" value="<?= old('email') ?>" required>
                        </div>
                        <div class="col-12">
                            <label for="phone" class="form-label">Phone Number <span class="text-danger">*</span></label>
                            <input type="tel" class="form-control rounded-0" id="phone" name="phone" value="<?= old('phone') ?>" required>
                        </div>
                        <div class="col-12">
                            <label for="country" class="form-label">Country <span class="text-danger">*</span></label>
                            <select class="form-select rounded-0" id="country" name="country" required>
                                <option value="">Choose...</option>
                                <option value="Lebanon" <?= old('country') == 'Lebanon' ? 'selected' : '' ?>>Lebanon</option>
                                <option value="USA" <?= old('country') == 'USA' ? 'selected' : '' ?>>United States</option>
                                <option value="UAE" <?= old('country') == 'UAE' ? 'selected' : '' ?>>United Arab Emirates</option>
                                <option value="KSA" <?= old('country') == 'KSA' ? 'selected' : '' ?>>Saudi Arabia</option>
                                <!-- Add more as needed -->
                            </select>
                        </div>
                        <div class="col-12">
                            <label for="address" class="form-label">Address <span class="text-danger">*</span></label>
                            <input type="text" class="form-control rounded-0" id="address" name="address" value="<?= old('address') ?>" required>
                        </div>
                        <div class="col-md-6">
                            <label for="city" class="form-label">City <span class="text-danger">*</span></label>
                            <input type="text" class="form-control rounded-0" id="city" name="city" value="<?= old('city') ?>" required>
                        </div>
                        <div class="col-md-6">
                            <label for="zip" class="form-label">Zip <span class="text-danger">*</span></label>
                            <input type="text" class="form-control rounded-0" id="zip" name="zip" value="<?= old('zip') ?>" required>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="col-md-5">
                <div class="bg-light p-4">
                    <h4 class="brand-font mb-4">Your Order</h4>
                    <ul class="list-group list-group-flush mb-3">
                        <?php foreach ($cart as $item): ?>
                            <li class="list-group-item d-flex justify-content-between lh-sm bg-transparent px-0">
                                <div>
                                    <h6 class="my-0"><?= esc($item['name']) ?></h6>
                                    <small class="text-muted">Qty: <?= $item['quantity'] ?></small>
                                </div>
                                <span class="text-muted">$<?= number_format($item['price'] * $item['quantity'], 2) ?></span>
                            </li>
                        <?php endforeach; ?>
                        <li class="list-group-item d-flex justify-content-between bg-transparent px-0 fw-bold border-top border-dark mt-3 pt-3">
                            <span>Total (USD)</span>
                            <span>$<?= number_format($total, 2) ?></span>
                        </li>
                    </ul>

                    <div class="d-grid gap-2">
                         <button type="submit" class="btn btn-dark btn-lg rounded-0 text-uppercase" style="letter-spacing: 1px;">Place Order</button>
                    </div>
                    <small class="text-muted mt-3 d-block text-center"><i class="fas fa-lock me-1"></i> Secure Checkout (Simulated)</small>
                </div>
            </div>
        </div>
    </form>
</section>
