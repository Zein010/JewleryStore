<div class="container-fluid px-4">
    <h1 class="mt-4">View Message</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item"><a href="<?= base_url('admin/dashboard') ?>">Dashboard</a></li>
        <li class="breadcrumb-item"><a href="<?= base_url('admin/messages') ?>">Messages</a></li>
        <li class="breadcrumb-item active">View #<?= $message['id'] ?></li>
    </ol>

    <div class="card mb-4">
        <div class="card-header d-flex justify-content-between align-items-center">
            <div>
                <i class="fas fa-envelope-open me-1"></i> Message Details
            </div>
            <a href="<?= base_url('admin/messages') ?>" class="btn btn-secondary btn-sm">Back to List</a>
        </div>
        <div class="card-body">
            <div class="row mb-3">
                <div class="col-md-6">
                    <strong>From:</strong> <?= esc($message['name']) ?> &lt;<a href="mailto:<?= esc($message['email']) ?>"><?= esc($message['email']) ?></a>&gt;
                </div>
                <div class="col-md-6 text-md-end text-muted">
                    <?= date('F j, Y, h:i A', strtotime($message['created_at'])) ?>
                </div>
            </div>
            
            <div class="mb-4">
                <strong>Subject:</strong>
                <h4 class="mt-1"><?= esc($message['subject']) ?></h4>
            </div>

            <hr>

            <div class="message-body p-3 bg-light rounded mt-3">
                <?= nl2br(esc($message['message'])) ?>
            </div>
            
            <div class="mt-4">
                <a href="mailto:<?= esc($message['email']) ?>?subject=Re: <?= urlencode($message['subject']) ?>" class="btn btn-primary"><i class="fas fa-reply"></i> Reply via Email</a>
                <a href="<?= base_url('admin/messages/delete/' . $message['id']) ?>" class="btn btn-danger float-end" onclick="return confirm('Are you sure you want to delete this message?')"><i class="fas fa-trash"></i> Delete</a>
            </div>
        </div>
    </div>
</div>
