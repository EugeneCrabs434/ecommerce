<div class="d-flex justify-content-between align-items-center mb-4">
    <h1>Пользователи</h1>
    <a href="/users?action=create" class="btn btn-primary">Добавить пользователя</a>
</div>

<h2 class="mb-3">Черный список</h2>
<?php if (empty($blacklistedUsers)): ?>
    <div class="alert alert-info">Черный список пуст</div>
<?php else: ?>
    <div class="table-responsive mb-4">
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Имя</th>
                    <th>Email</th>
                    <th>Причина</th>
                    <th>Действия</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($blacklistedUsers as $user): ?>
                    <tr>
                        <td><?= htmlspecialchars($user['id']) ?></td>
                        <td><?= htmlspecialchars($user['name']) ?></td>
                        <td><?= htmlspecialchars($user['email']) ?></td>
                        <td><?= htmlspecialchars($user['reason']) ?></td>
                        <td>
                            <a href="/users?action=removeFromBlacklist&id=<?= $user['id'] ?>" 
                               class="btn btn-sm btn-success" 
                               onclick="return confirm('Удалить из черного списка?')">
                                Удалить из черного списка
                            </a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
<?php endif; ?>

<h2 class="mb-3">Все пользователи</h2>
<?php if (empty($users)): ?>
    <div class="alert alert-info">Пользователи не найдены</div>
<?php else: ?>
    <div class="table-responsive">
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Имя</th>
                    <th>Email</th>
                    <th>Действия</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($users as $user): ?>
                    <tr>
                        <td><?= htmlspecialchars($user['id']) ?></td>
                        <td><?= htmlspecialchars($user['name']) ?></td>
                        <td><?= htmlspecialchars($user['email']) ?></td>
                        <td>
                            <a href="/users?action=edit&id=<?= $user['id'] ?>" class="btn btn-sm btn-warning">Редактировать</a>
                            <a href="/users?action=blacklist&id=<?= $user['id'] ?>" class="btn btn-sm btn-danger">В черный список</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
<?php endif; ?> 