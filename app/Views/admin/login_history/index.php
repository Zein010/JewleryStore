<div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="h3 mb-0 text-gray-800">Login History</h1>
</div>

<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">
            <?= $isRoot ? 'All Administrators Login Activity' : 'Your Recent Login Activity' ?>
        </h6>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered table-striped" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>Date & Time</th>
                        <?php if ($isRoot): ?>
                            <th>Administrator</th>
                        <?php endif; ?>
                        <th>IP Address</th>
                        <th>Device / Browser (User Agent)</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($logs)): ?>
                        <?php foreach($logs as $log): ?>
                            <tr>
                                <td style="white-space: nowrap;"><?= date('M d, Y - h:i A', strtotime($log['created_at'])) ?></td>
                                <?php if ($isRoot): ?>
                                    <td><?= esc($log['admin_name'] ?? 'Unknown Admin (ID: ' . $log['admin_id'] . ')') ?></td>
                                <?php endif; ?>
                                <td><code><?= esc($log['ip_address']) ?></code></td>
                                <td><small class="text-muted"><?= esc($log['user_agent']) ?></small></td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="<?= $isRoot ? '4' : '3' ?>" class="text-center py-4 text-muted">No login logs found.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
