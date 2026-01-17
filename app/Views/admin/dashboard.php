<?= view('admin/layout/header') ?>
<?= view('admin/layout/sidebar') ?>

<h1 class="mt-4">Dashboard</h1>
<p>Welcome to the Luxe Cloud Co Admin Panel.</p>

<div class="row mt-4">
    <div class="col-md-4">
        <div class="card bg-primary text-white mb-4">
            <div class="card-body">Categories</div>
            <div class="card-footer d-flex align-items-center justify-content-between">
                <a class="small text-white stretched-link" href="<?= base_url('admin/categories') ?>">View Details</a>
                <div class="small text-white"><i class="bi bi-angle-right"></i></div>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card bg-success text-white mb-4">
            <div class="card-body">Products</div>
            <div class="card-footer d-flex align-items-center justify-content-between">
                <a class="small text-white stretched-link" href="<?= base_url('admin/products') ?>">View Details</a>
                <div class="small text-white"><i class="bi bi-angle-right"></i></div>
            </div>
        </div>
    </div>
</div>

<?= view('admin/layout/footer') ?>
