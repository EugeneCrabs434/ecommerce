<?php
$isEdit = isset($product);
$title = $isEdit ? 'Редактирование товара' : 'Создание товара';
$action = $isEdit ? "/products?action=edit&id={$product['id']}" : "/products?action=create";
?>

<h1><?= $title ?></h1>

<form action="<?= $action ?>" method="POST" class="mt-4">
    <div class="mb-3">
        <label for="name" class="form-label">Название</label>
        <input type="text" class="form-control" id="name" name="name" 
               value="<?= $isEdit ? htmlspecialchars($product['name']) : '' ?>" required>
    </div>
    
    <div class="mb-3">
        <label for="description" class="form-label">Описание</label>
        <textarea class="form-control" id="description" name="description" rows="3"><?= 
            $isEdit ? htmlspecialchars($product['description']) : '' 
        ?></textarea>
    </div>
    
    <div class="mb-3">
        <label for="price" class="form-label">Цена</label>
        <input type="number" step="0.01" class="form-control" id="price" name="price" 
               value="<?= $isEdit ? $product['price'] : '' ?>" required>
    </div>
    
    <div class="mb-3">
        <label for="category" class="form-label">Категория</label>
        <input type="text" class="form-control" id="category" name="category" 
               value="<?= $isEdit ? htmlspecialchars($product['category']) : '' ?>">
    </div>
    
    <button type="submit" class="btn btn-primary"><?= $isEdit ? 'Сохранить' : 'Создать' ?></button>
    <a href="/products" class="btn btn-secondary">Отмена</a>
</form> 