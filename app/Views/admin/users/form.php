<div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="h3 mb-0 text-gray-800"><?= esc($title) ?></h1>
    <a href="<?= base_url('admin/users') ?>" class="btn btn-secondary btn-sm shadow-sm"><i class="bi bi-arrow-left fa-sm text-white-50 me-1"></i> Back to Users</a>
</div>

<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Admin Details</h6>
    </div>
    <div class="card-body">
        <?php if(session()->getFlashdata('errors')): ?>
            <div class="alert alert-danger">
                <ul class="mb-0">
                <?php foreach (session()->getFlashdata('errors') as $error) : ?>
                    <li><?= esc($error) ?></li>
                <?php endforeach ?>
                </ul>
            </div>
        <?php endif ?>

        <form action="<?= $user ? base_url('admin/users/update/' . $user['id']) : base_url('admin/users/store') ?>" method="post">
            
            <div class="mb-3">
                <label for="name" class="form-label">Name <span class="text-danger">*</span></label>
                <input type="text" class="form-control" id="name" name="name" value="<?= old('name', $user['name'] ?? '') ?>" required>
            </div>
            
            <div class="mb-3">
                <label for="email" class="form-label">Email Address <span class="text-danger">*</span></label>
                <input type="email" class="form-control" id="email" name="email" value="<?= old('email', $user['email'] ?? '') ?>" required>
            </div>

            <div class="mb-4">
                <label for="password" class="form-label">Password <?= !$user ? '<span class="text-danger">*</span>' : '' ?></label>
                <input type="password" class="form-control" id="password" name="password" <?= !$user ? 'required' : '' ?>>
                <?php if ($user): ?>
                    <div class="form-text text-muted">Leave password blank if you do not want to change the existing password.</div>
                <?php else: ?>
                    <div class="form-text text-muted">Password must be at least 8 characters.</div>
                <?php endif; ?>
            </div>

            <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                <button type="submit" class="btn btn-primary"><i class="bi bi-save me-1"></i> <?= $user ? 'Update Admin' : 'Create Admin' ?></button>
            </div>
            
        </form>
    </div>
</div>
