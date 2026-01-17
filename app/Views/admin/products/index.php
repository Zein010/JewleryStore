<?= view('admin/layout/header') ?>
<?= view('admin/layout/sidebar') ?>

<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Products</h1>
    <div class="btn-toolbar mb-2 mb-md-0">
        <a href="<?= base_url('admin/products/create') ?>" class="btn btn-sm btn-outline-primary">
            <i class="bi bi-plus-lg"></i> Add New Product
        </a>
    </div>
</div>

<?php if (session()->getFlashdata('success')): ?>
    <div class="alert alert-success"><?= session()->getFlashdata('success') ?></div>
<?php endif; ?>
<?php if (session()->getFlashdata('error')): ?>
    <div class="alert alert-danger"><?= session()->getFlashdata('error') ?></div>
<?php endif; ?>

<div class="table-responsive">
    <table class="table table-striped table-sm">
        <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">Image</th>
                <th scope="col">Name</th>
                <th scope="col">Category</th>
                <th scope="col">Price</th>
                <th scope="col">Featured</th>
                <th scope="col">Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($products as $product): ?>
            <tr>
                <td><?= $product['id'] ?></td>
                <td>
                    <?php if ($product['image']): ?>
                        <img src="<?= base_url('uploads/products/' . $product['image']) ?>" alt="<?= $product['name'] ?>" width="50">
                    <?php else: ?>
                        <span class="text-muted">No Image</span>
                    <?php endif; ?>
                </td>
                <td><?= $product['name'] ?></td>
                <td><?= $product['category_name'] ?></td>
                <td>$<?= number_format($product['price'], 2) ?></td>
                <td><?= $product['featured'] ? '<span class="badge bg-success">Yes</span>' : '<span class="badge bg-secondary">No</span>' ?></td>
                <td>
                    <a href="<?= base_url('product/' . $product['slug']) ?>" target="_blank" class="btn btn-sm btn-info text-white" title="View on Website"><i class="bi bi-eye"></i></a>
                    <a href="<?= base_url('admin/products/edit/' . $product['id']) ?>" class="btn btn-sm btn-outline-secondary">Edit</a>
                    <a href="<?= base_url('admin/products/delete/' . $product['id']) ?>" class="btn btn-sm btn-outline-danger" onclick="return confirm('Are you sure?')">Delete</a>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<?= view('admin/layout/footer') ?>
