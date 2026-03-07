<div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="h3 mb-0 text-gray-800">Admin Users</h1>
    <?php if (session()->get('id') == 1): ?>
        <a href="<?= base_url('admin/users/create') ?>" class="btn btn-primary btn-sm shadow-sm"><i class="bi bi-plus-circle fa-sm text-white-50 me-1"></i> Add New Admin</a>
    <?php endif; ?>
</div>

<?php if (session()->getFlashdata('success')): ?>
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <?= session()->getFlashdata('success') ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
<?php endif; ?>

<?php if (session()->getFlashdata('error')): ?>
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <?= session()->getFlashdata('error') ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
<?php endif; ?>

<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Manage Administrators</h6>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Created At</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($users)): ?>
                        <?php foreach($users as $user): ?>
                            <tr>
                                <td><?= esc($user['id']) ?></td>
                                <td><?= esc($user['name']) ?></td>
                                <td><?= esc($user['email']) ?></td>
                                <td><?= date('M d, Y', strtotime($user['created_at'])) ?></td>
                                <td>
                                    <?php if (session()->get('id') == 1 || session()->get('id') == $user['id']): ?>
                                        <a href="<?= base_url('admin/users/edit/' . $user['id']) ?>" class="btn btn-sm btn-info text-white"><i class="bi bi-pencil-square"></i></a>
                                    <?php endif; ?>

                                    <?php if (session()->get('id') == 1): ?>
                                        <?php if ($user['id'] != session()->get('id') && $user['id'] != 1): ?>
                                            <a href="<?= base_url('admin/users/delete/' . $user['id']) ?>" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure you want to delete this admin user? This action cannot be undone.');"><i class="bi bi-trash"></i></a>
                                        <?php else: ?>
                                            <button class="btn btn-sm btn-secondary" title="You cannot delete this account." disabled><i class="bi bi-trash"></i></button>
                                        <?php endif; ?>
                                    <?php endif; ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="5" class="text-center py-4">No admin users found.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
