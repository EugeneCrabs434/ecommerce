<h1>Заказ #<?= $order['id'] ?></h1>

<div class="row mt-4">
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">Информация о заказе</h5>
            </div>
            <div class="card-body">
                <p><strong>Пользователь:</strong> <?= htmlspecialchars($order['user_name']) ?></p>
                <p><strong>Email:</strong> <?= htmlspecialchars($order['user_email']) ?></p>
                <p><strong>Статус:</strong> 
                    <span class="badge bg-<?= $this->getStatusBadgeClass($order['status']) ?>">
                        <?= $this->getStatusText($order['status']) ?>
                    </span>
                </p>
                <p><strong>Дата создания:</strong> <?= date('d.m.Y H:i', strtotime($order['created_at'])) ?></p>
            </div>
        </div>
    </div>
    
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">Товары в заказе</h5>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Товар</th>
                                <th>Количество</th>
                                <th>Цена</th>
                                <th>Сумма</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($order['items'] as $item): ?>
                                <tr>
                                    <td><?= htmlspecialchars($item['product_name']) ?></td>
                                    <td><?= $item['quantity'] ?></td>
                                    <td><?= number_format($item['price'], 2) ?> ₽</td>
                                    <td><?= number_format($item['price'] * $item['quantity'], 2) ?> ₽</td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                        <tfoot>
                            <tr>
                                <th colspan="3">Итого:</th>
                                <th><?= number_format($order['total_amount'], 2) ?> ₽</th>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="mt-4">
    <?php if ($order['status'] === 'new'): ?>
        <a href="/orders?action=pay&id=<?= $order['id'] ?>" class="btn btn-success">Оплатить заказ</a>
        <a href="/orders?action=cancel&id=<?= $order['id'] ?>" class="btn btn-danger">Отменить заказ</a>
    <?php endif; ?>
    <a href="/orders" class="btn btn-secondary">Назад к списку</a>
</div> 