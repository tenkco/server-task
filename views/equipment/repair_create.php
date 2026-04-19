<div class="container">
    <h1>Регистрация ремонта</h1>
    <p style="text-align:center;color:#aaa;margin-top:-20px;margin-bottom:30px;"><?= htmlspecialchars($item->name) ?> · <?= htmlspecialchars($item->inventory_number) ?></p>
    <div class="form-wrap">
        <form method="post">
            <div style="display:flex;flex-direction:column;gap:14px;">
                <input type="date" name="breakdown_date" placeholder="Дата поломки" required>
                <input type="date" name="repair_date"    placeholder="Дата ремонта (если завершён)">
                <textarea name="description" placeholder="Описание работ"></textarea>
                <input type="number" name="price" placeholder="Стоимость" step="0.01">
                <div class="btn-row">
                    <button class="btn btn-primary">Сохранить</button>
                    <a href="<?= app()->route->getUrl('/equipment/show/' . $item->id) ?>" class="btn btn-secondary">Отмена</a>
                </div>
            </div>
        </form>
    </div>
</div>
