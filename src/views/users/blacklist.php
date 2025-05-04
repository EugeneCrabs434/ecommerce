<h1>Добавление в черный список</h1>

<div class="alert alert-warning">
    <strong>Внимание!</strong> Пользователь <?= htmlspecialchars($user['name']) ?> (<?= htmlspecialchars($user['email']) ?>) будет добавлен в черный список.
</div>

<form action="/users?action=blacklist" method="POST" class="mt-4">
    <input type="hidden" name="user_id" value="<?= $user['id'] ?>">
    
    <div class="mb-3">
        <label for="reason" class="form-label">Причина добавления в черный список</label>
        <textarea class="form-control" id="reason" name="reason" rows="3" required></textarea>
    </div>
    
    <button type="submit" class="btn btn-danger">Добавить в черный список</button>
    <a href="/users" class="btn btn-secondary">Отмена</a>
</form> 