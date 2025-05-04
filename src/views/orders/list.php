<div class="d-flex justify-content-between align-items-center mb-4">
    <h1>Заказы</h1>
    <a href="/orders?action=create" class="btn btn-primary">Создать заказ</a>
</div>

<?php if (empty($orders)): ?>
    <div class="alert alert-info">Заказы не найдены</div>
<?php else: ?>
    <div class="table-responsive">
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Пользователь</th>
                    <th>Статус</th>
                    <th>Сумма</th>
                    <th>Дата создания</th>
                    <th>Действия</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($orders as $order): ?>
                    <tr>
                        <td><?= htmlspecialchars($order['id']) ?></td>
                        <td><?= htmlspecialchars($order['user_name']) ?></td>
                        <td>
                            <span class="badge bg-<?= $this->getStatusBadgeClass($order['status']) ?>">
                                <?= $this->getStatusText($order['status']) ?>
                            </span>
                        </td>
                        <td><?= number_format($order['total_amount'], 2) ?> ₽</td>
                        <td><?= date('d.m.Y H:i', strtotime($order['created_at'])) ?></td>
                        <td>
                            <a href="/orders?action=view&id=<?= $order['id'] ?>" class="btn btn-sm btn-info">Просмотр</a>
                            <?php if ($order['status'] === 'new'): ?>
                                <a href="/orders?action=pay&id=<?= $order['id'] ?>" class="btn btn-sm btn-success">Оплатить</a>
                                <a href="/orders?action=cancel&id=<?= $order['id'] ?>" class="btn btn-sm btn-danger">Отменить</a>
                            <?php endif; ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
<?php endif; ?> 