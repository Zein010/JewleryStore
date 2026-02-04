<?= view('admin/layout/header') ?>
<?= view('admin/layout/sidebar') ?>

<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Categories</h1>
    <div class="btn-toolbar mb-2 mb-md-0">
        <a href="<?= base_url('admin/categories/create') ?>" class="btn btn-sm btn-outline-primary">
            <i class="bi bi-plus-lg"></i> Add New Category
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
                <th scope="col">Slug</th>
                <th scope="col">Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($categories as $category): ?>
            <tr>
                <td><?= $category['id'] ?></td>
                <td>
                    <?php if ($category['image']): ?>
                        <img src="<?= base_url('uploads/categories/' . $category['image']) ?>" alt="<?= $category['name'] ?>" width="50">
                    <?php else: ?>
                        <span class="text-muted">No Image</span>
                    <?php endif; ?>
                </td>
                <td>
                    <?= $category['name'] ?>
                    <?php if ($category['is_featured']): ?>
                        <span class="badge bg-warning text-dark"><i class="bi bi-star-fill"></i> Featured</span>
                    <?php endif; ?>
                </td>
                <td><?= $category['slug'] ?></td>
                <td>
                    <a href="<?= base_url('admin/categories/edit/' . $category['id']) ?>" class="btn btn-sm btn-outline-secondary">Edit</a>
                    <a href="<?= base_url('admin/categories/delete/' . $category['id']) ?>" class="btn btn-sm btn-outline-danger" onclick="return confirm('Are you sure?')">Delete</a>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<?= view('admin/layout/footer') ?>
