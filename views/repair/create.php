<div class="container">
    <h1>Добавление ремонта</h1>

    <div class="form-wrap">
        <?php if (!empty($message)): ?>
            <div class="<?= strpos($message, 'успешно') !== false ? 'success-msg' : 'error-msg' ?>">
                <?= htmlspecialchars($message) ?>
            </div>
        <?php endif; ?>

        <form method="post">
            <input name="csrf_token" type="hidden" value="<?= \Tenkco\Auth\Auth::generateCSRF() ?>">

            <div style="display:flex;flex-direction:column;gap:14px;">
                <label>
                    Оборудование
                    <input type="text" value="<?= htmlspecialchars($equipmentName ?? 'Неизвестно') ?>" disabled
                           style="background:white;color: #0D0D0D">
                    <input type="hidden" name="Inventory_number" value="<?= htmlspecialchars($inventory_number) ?>">
                </label>

                <label>
                    Дата поломки
                    <input type="date" name="Date_of_breakdown"
                           value="<?= htmlspecialchars(($request->all()['Date_of_breakdown'] ?? '')) ?>"
                           required>
                </label>

                <label>
                    Дата ремонта
                    <input type="date" name="Repair_date"
                           value="<?= htmlspecialchars(($request->all()['Repair_date'] ?? '')) ?>"
                           required>
                </label>

                <label>
                    Описание работ
                    <textarea name="Description_of_work" rows="4" required
                              placeholder="Что было сделано?" style="color: white"><?= htmlspecialchars(($request->all()['Description_of_work'] ?? '')) ?></textarea>
                </label>

                <label>
                    Стоимость ремонта (₽)
                    <input type="number" name="Price" step="0.01"
                           value="<?= htmlspecialchars(($request->all()['Price'] ?? '0.00')) ?>"
                           placeholder="0.00">
                </label>

                <div class="btn-row">
                    <button type="submit" class="btn btn-primary">Сохранить</button>
                    <a href="<?= app()->route->getUrl('/equipment/show/' . urlencode($inventory_number)) ?>"
                       class="btn btn-secondary">Отмена</a>
                </div>
            </div>
        </form>
    </div>
</div>