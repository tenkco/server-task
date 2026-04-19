<div class="container">
    <h1>Регистрация оборудования</h1>
    <div class="form-wrap">
        <form method="post">
            <div style="display:flex;flex-direction:column;gap:14px;">
                <input type="text"   name="name"               placeholder="Название" required>
                <input type="date"   name="commissioning_date" required>
                <input type="text"   name="model"              placeholder="Модель" required>
                <input type="text"   name="inventory_number"   placeholder="Инвентарный номер" required>
                <select name="employee_role_id">
                    <option value="">— Ответственный —</option>
                    <?php foreach ($employeeRoles as $er): ?>
                        <option value="<?= $er->id ?>">
                            <?= htmlspecialchars($er->employee->login) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
                <select name="department_id" required>
                    <option value="">— Кафедра —</option>
                    <?php foreach ($departments as $dept): ?>
                        <option value="<?= $dept->id ?>"><?= htmlspecialchars($dept->name) ?></option>
                    <?php endforeach; ?>
                </select>
                <input type="number" name="price" placeholder="Стоимость" step="0.01" required>
                <select name="condition_id" required>
                    <?php foreach ($conditions as $cond): ?>
                        <option value="<?= $cond->id ?>"><?= htmlspecialchars($cond->name) ?></option>
                    <?php endforeach; ?>
                </select>
                <div class="btn-row">
                    <button class="btn btn-primary">Сохранить</button>
                    <a href="<?= app()->route->getUrl('/equipment') ?>" class="btn btn-secondary">Отмена</a>
                </div>
            </div>
        </form>
    </div>
</div>