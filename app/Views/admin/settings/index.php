<div class="container-fluid px-4">
    <h1 class="mt-4"><?= $title ?></h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item"><a href="<?= base_url('admin/dashboard') ?>">Dashboard</a></li>
        <li class="breadcrumb-item active">Settings</li>
    </ol>

    <?php if (session()->getFlashdata('success')): ?>
        <div class="alert alert-success">
            <?= session()->getFlashdata('success') ?>
        </div>
    <?php endif; ?>

    <div class="card mb-4">
        <div class="card-header">
            <i class="fas fa-cogs me-1"></i>
            Website Configuration
        </div>
        <div class="card-body">
            <form action="<?= base_url('admin/settings/update') ?>" method="post" enctype="multipart/form-data">
                
                <h5 class="mb-3 border-bottom pb-2">General Info</h5>
                <div class="mb-3">
                    <label for="company_name" class="form-label">Company Name</label>
                    <input type="text" class="form-control" id="company_name" name="company_name" value="<?= esc($settings['company_name'] ?? '') ?>" required>
                </div>

                <div class="mb-3">
                    <label for="company_logo" class="form-label">Company Logo</label>
                    <?php if (!empty($settings['company_logo'])): ?>
                        <div class="mb-2">
                            <img src="<?= base_url('uploads/settings/' . $settings['company_logo']) ?>" alt="Logo" style="height: 60px;">
                        </div>
                    <?php endif; ?>
                    <input type="file" class="form-control" id="company_logo" name="company_logo" accept="image/*">
                    <div class="form-text">Upload a new logo to replace the current one.</div>
                </div>

                <h5 class="mb-3 mt-4 border-bottom pb-2">Contact Details</h5>
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="contact_email" class="form-label">Email Address</label>
                        <input type="email" class="form-control" id="contact_email" name="contact_email" value="<?= esc($settings['contact_email'] ?? '') ?>">
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="contact_phone" class="form-label">Phone Number</label>
                        <input type="text" class="form-control" id="contact_phone" name="contact_phone" value="<?= esc($settings['contact_phone'] ?? '') ?>">
                    </div>
                    <div class="col-12 mb-3">
                        <label for="contact_address" class="form-label">Address</label>
                        <textarea class="form-control" id="contact_address" name="contact_address" rows="2"><?= esc($settings['contact_address'] ?? '') ?></textarea>
                    </div>
                </div>

                <h5 class="mb-3 mt-4 border-bottom pb-2">Social Media</h5>
                <div class="row">
                    <div class="col-md-4 mb-3">
                        <label for="facebook_link" class="form-label">Facebook URL</label>
                        <input type="text" class="form-control" id="facebook_link" name="facebook_link" value="<?= esc($settings['facebook_link'] ?? '') ?>">
                    </div>
                    <div class="col-md-4 mb-3">
                        <label for="instagram_link" class="form-label">Instagram URL</label>
                        <input type="text" class="form-control" id="instagram_link" name="instagram_link" value="<?= esc($settings['instagram_link'] ?? '') ?>">
                    </div>
                    <div class="col-md-4 mb-3">
                        <label for="pinterest_link" class="form-label">Pinterest URL</label>
                        <input type="text" class="form-control" id="pinterest_link" name="pinterest_link" value="<?= esc($settings['pinterest_link'] ?? '') ?>">
                    </div>
                </div>

                <div class="mt-4 mb-3">
                    <button type="submit" class="btn btn-primary px-5">Save Settings</button>
                </div>
            </form>
        </div>
    </div>
</div>
