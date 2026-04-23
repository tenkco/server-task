<div class="container">
    <h1>Добавление оборудования</h1>

    <div class="form-wrap">
        <?php if (!empty($message)): ?>
            <div class="<?= strpos($message, 'успешно') !== false ? 'success-msg' : 'error-msg' ?>">
                <?= htmlspecialchars($message) ?>
            </div>
        <?php endif; ?>

        <form method="post" enctype="multipart/form-data">
            <input name="csrf_token" type="hidden" value="<?= \Src\Auth\Auth::generateCSRF() ?>">

            <div style="display:flex;flex-direction:column;gap:14px;">
                <label>
                    Наименование
                    <input type="text" name="Name"
                           value="<?= htmlspecialchars(($request->all()['Name'] ?? '')) ?>"
                           required placeholder="Заумное название">
                </label>

                <label>
                    Модель
                    <input type="text" name="Model"
                           value="<?= htmlspecialchars(($request->all()['Model'] ?? '')) ?>"
                           placeholder="Самая последняя модель">
                </label>

                <label>
                    Стоимость (₽)
                    <input type="number" name="Price" step="0.01"
                           value="<?= htmlspecialchars(($request->all()['Price'] ?? '')) ?>"
                           required placeholder="мильон">
                </label>

                <label>
                    Дата ввода в эксплуатацию
                    <input type="date" name="Commissioning_date"
                           value="<?= htmlspecialchars(($request->all()['Commissioning_date'] ?? '')) ?>"
                           required>
                </label>

                <label>
                    Кафедра
                    <select name="ID_department" required>
                        <option value="">Выберите кафедру</option>
                        <?php foreach ($departments as $dept): ?>
                            <option value="<?= $dept->ID_department ?>"
                                    <?= (($request->all()['ID_department'] ?? '') == $dept->ID_department) ? 'selected' : '' ?>>
                                <?= htmlspecialchars($dept->Department_name) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </label>

                <label>
                    Статус
                    <select name="ID_status_code">
                        <option value="1" <?= (($request->all()['ID_status_code'] ?? 1) == 1) ? 'selected' : '' ?>>Исправен</option>
                        <option value="2" <?= (($request->all()['ID_status_code'] ?? 1) == 2) ? 'selected' : '' ?>>В ремонте</option>
                        <option value="3" <?= (($request->all()['ID_status_code'] ?? 1) == 3) ? 'selected' : '' ?>>Списан</option>
                    </select>
                </label>

                <label>
                    Ответственный сотрудник
                    <select name="ID_employee_role">
                        <option value="">Не назначен</option>
                        <?php foreach ($employees as $empRole):
                            $emp = $empRole->employee;
                            $role = $empRole->role;
                            ?>
                            <option value="<?= $empRole->ID_employee_role ?>"
                                    <?= (($request->all()['ID_employee_role'] ?? '') == $empRole->ID_employee_role) ? 'selected' : '' ?>>
                                <?= htmlspecialchars($emp->login) ?> (<?= htmlspecialchars($role->Role_name) ?>)
                            </option>
                        <?php endforeach; ?>
                    </select>
                </label>

                <label>
                    Изображение
                    <input type="file" name="image" accept="image/*">
                </label>

                <div class="btn-row">
                    <button type="submit" class="btn btn-primary">Сохранить</button>
                    <a href="<?= app()->route->getUrl('/equipment') ?>" class="btn btn-secondary">Отмена</a>
                </div>
            </div>
        </form>
    </div>
</div>