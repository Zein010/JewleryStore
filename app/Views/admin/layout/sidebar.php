        <!-- Sidebar -->
        <div class="bg-light border-right" id="sidebar-wrapper">
            <div class="sidebar-heading text-bg-dark">Luxe Admin</div>
            <div class="list-group list-group-flush">
                <a href="<?= base_url('admin/dashboard') ?>" class="list-group-item list-group-item-action list-group-item-light p-3 <?= uri_string() == 'admin/dashboard' ? 'active' : '' ?>">
                    <i class="bi bi-speedometer2 me-2"></i> Dashboard
                </a>
                <a href="<?= base_url('admin/categories') ?>" class="list-group-item list-group-item-action list-group-item-light p-3 <?= strpos(uri_string(), 'admin/categories') !== false ? 'active' : '' ?>">
                    <i class="bi bi-grid me-2"></i> Categories
                </a>
                <a href="<?= base_url('admin/products') ?>" class="list-group-item list-group-item-action list-group-item-light p-3 <?= strpos(uri_string(), 'admin/products') !== false ? 'active' : '' ?>">
                    <i class="bi bi-box-seam me-2"></i> Products
                </a>
                <a href="<?= base_url('admin/settings') ?>" class="list-group-item list-group-item-action list-group-item-light p-3 <?= strpos(uri_string(), 'admin/settings') !== false ? 'active' : '' ?>">
                    <i class="bi bi-gear me-2"></i> Settings
                </a>
                <a href="<?= base_url('admin/logout') ?>" class="list-group-item list-group-item-action list-group-item-light p-3 text-danger">
                    <i class="bi bi-box-arrow-right me-2"></i> Logout
                </a>
            </div>
        </div>
        <!-- /#sidebar-wrapper -->

        <!-- Page Content -->
        <div id="page-content-wrapper">
            <nav class="navbar navbar-expand-lg navbar-light bg-light border-bottom">
                <div class="container-fluid">
                    <button class="btn btn-primary" id="menu-toggle"><i class="bi bi-list"></i></button>
                    
                    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                    </button>

                    <div class="collapse navbar-collapse" id="navbarSupportedContent">
                        <ul class="navbar-nav ms-auto mt-2 mt-lg-0">
                            <li class="nav-item active">
                                <a class="nav-link" href="<?= base_url() ?>" target="_blank">View Site</a>
                            </li>
                            <li class="nav-item">
                                <span class="nav-link disabled"><?= session()->get('name') ?></span>
                            </li>
                        </ul>
                    </div>
                </div>
            </nav>

            <div class="container-fluid p-4">
