<h1>Создание заказа</h1>

<form action="/orders?action=create" method="POST" class="mt-4">
    <div class="mb-3">
        <label for="user_id" class="form-label">Пользователь</label>
        <select class="form-select" id="user_id" name="user_id" required>
            <option value="">Выберите пользователя</option>
            <?php foreach ($users as $user): ?>
                <option value="<?= $user['id'] ?>">
                    <?= htmlspecialchars($user['name']) ?> (<?= htmlspecialchars($user['email']) ?>)
                </option>
            <?php endforeach; ?>
        </select>
    </div>
    
    <div class="mb-3">
        <label class="form-label">Товары</label>
        <div id="products-container">
            <div class="row mb-2">
                <div class="col-md-6">
                    <select class="form-select product-select" name="products[0][id]" required>
                        <option value="">Выберите товар</option>
                        <?php foreach ($products as $product): ?>
                            <option value="<?= $product['id'] ?>" data-price="<?= $product['price'] ?>">
                                <?= htmlspecialchars($product['name']) ?> (<?= number_format($product['price'], 2) ?> ₽)
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="col-md-4">
                    <input type="number" class="form-control quantity-input" name="products[0][quantity]" 
                           min="1" value="1" required>
                </div>
                <div class="col-md-2">
                    <button type="button" class="btn btn-danger remove-product">Удалить</button>
                </div>
            </div>
        </div>
        <button type="button" class="btn btn-secondary mt-2" id="add-product">Добавить товар</button>
    </div>
    
    <div class="mb-3">
        <label class="form-label">Итого: <span id="total-amount">0.00</span> ₽</label>
    </div>
    
    <button type="submit" class="btn btn-primary">Создать заказ</button>
    <a href="/orders" class="btn btn-secondary">Отмена</a>
</form>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const container = document.getElementById('products-container');
    const addButton = document.getElementById('add-product');
    let productCount = 1;
    
    function updateTotal() {
        let total = 0;
        document.querySelectorAll('.product-select').forEach(select => {
            const price = parseFloat(select.options[select.selectedIndex]?.dataset.price || 0);
            const quantity = parseInt(select.closest('.row').querySelector('.quantity-input').value);
            total += price * quantity;
        });
        document.getElementById('total-amount').textContent = total.toFixed(2);
    }
    
    function addProductRow() {
        const row = document.createElement('div');
        row.className = 'row mb-2';
        row.innerHTML = `
            <div class="col-md-6">
                <select class="form-select product-select" name="products[${productCount}][id]" required>
                    <option value="">Выберите товар</option>
                    ${Array.from(document.querySelectorAll('.product-select option')).map(opt => opt.outerHTML).join('')}
                </select>
            </div>
            <div class="col-md-4">
                <input type="number" class="form-control quantity-input" name="products[${productCount}][quantity]" 
                       min="1" value="1" required>
            </div>
            <div class="col-md-2">
                <button type="button" class="btn btn-danger remove-product">Удалить</button>
            </div>
        `;
        container.appendChild(row);
        productCount++;
        
        row.querySelector('.product-select').addEventListener('change', updateTotal);
        row.querySelector('.quantity-input').addEventListener('change', updateTotal);
        row.querySelector('.remove-product').addEventListener('click', function() {
            row.remove();
            updateTotal();
        });
    }
    
    addButton.addEventListener('click', addProductRow);
    
    document.querySelectorAll('.product-select').forEach(select => {
        select.addEventListener('change', updateTotal);
    });
    
    document.querySelectorAll('.quantity-input').forEach(input => {
        input.addEventListener('change', updateTotal);
    });
    
    document.querySelectorAll('.remove-product').forEach(button => {
        button.addEventListener('click', function() {
            button.closest('.row').remove();
            updateTotal();
        });
    });
    
    updateTotal();
});
</script> 