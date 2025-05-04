<div class="d-flex justify-content-between align-items-center mb-4">
    <h1>Список товаров</h1>
    <a href="/products?action=create" class="btn btn-primary">Добавить товар</a>
</div>

<?php if (empty($products)): ?>
    <div class="alert alert-info">Товары не найдены</div>
<?php else: ?>
    <div class="table-responsive">
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Название</th>
                    <th>Описание</th>
                    <th>Цена</th>
                    <th>Категория</th>
                    <th>Действия</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($products as $product): ?>
                    <tr>
                        <td><?= htmlspecialchars($product['id']) ?></td>
                        <td><?= htmlspecialchars($product['name']) ?></td>
                        <td><?= htmlspecialchars($product['description']) ?></td>
                        <td><?= number_format($product['price'], 2) ?> ₽</td>
                        <td><?= htmlspecialchars($product['category']) ?></td>
                        <td>
                            <a href="/products?action=edit&id=<?= $product['id'] ?>" class="btn btn-sm btn-warning">Редактировать</a>
                            <a href="/products?action=delete&id=<?= $product['id'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('Вы уверены?')">Удалить</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
<?php endif; ?> 