<?php
/** @var array $departments Список кафедр */
/** @var array $employees Список сотрудников */
/** @var string|null $message Сообщение об ошибке или успехе */
?>
<div class="container">
    <h1>Добавление оборудования</h1>

    <div class="form-wrap">
        <?php if (!empty($message)): ?>
            <div class="error-msg" style="color: #c62828; padding: 12px; border-radius: 8px; margin-bottom: 16px;">
                <ul style="margin: 0; padding-left: 20px;">
                    <?php
                    $errors = json_decode($message, true);
                    if (is_array($errors)) {
                        foreach ($errors as $fieldErrors) {
                            foreach ($fieldErrors as $err) {
                                echo "<li>" . htmlspecialchars($err) . "</li>";
                            }
                        }
                    } else {
                        echo "<li>" . htmlspecialchars($message) . "</li>";
                    }
                    ?>
                </ul>
            </div>
        <?php endif; ?>

        <form method="post" enctype="multipart/form-data" novalidate>
            <input name="csrf_token" type="hidden" value="<?= \Tenkco\Auth\Auth::generateCSRF() ?>">

            <div style="display:flex;flex-direction:column;gap:14px;">
                <label>
                    Наименование
                    <input type="text" name="Name"
                           value="<?= htmlspecialchars($_POST['Name'] ?? '') ?>"
                           required placeholder="Заумное название">
                </label>

                <label>
                    Модель
                    <input type="text" name="Model"
                           value="<?= htmlspecialchars($_POST['Model'] ?? '') ?>"
                           placeholder="Самая последняя модель">
                </label>

                <label>
                    Стоимость (₽) *
                    <input type="number" name="Price" step="0.01"
                           value="<?= htmlspecialchars($_POST['Price'] ?? '') ?>"
                           required placeholder="Мильон">
                </label>

                <label>
                    Дата ввода в эксплуатацию *
                    <input type="date" name="Commissioning_date"
                           value="<?= htmlspecialchars($_POST['Commissioning_date'] ?? '') ?>"
                           required>
                </label>

                <label>
                    Кафедра
                    <select name="ID_department" required>
                        <option value="">Выберите кафедру</option>
                        <?php if (isset($departments)): foreach ($departments as $dept): ?>
                            <option value="<?= $dept->ID_department ?>"
                                    <?= ($_POST['ID_department'] ?? '') == $dept->ID_department ? 'selected' : '' ?>>
                                <?= htmlspecialchars($dept->Department_name) ?>
                            </option>
                        <?php endforeach; endif; ?>
                    </select>
                </label>

                <label>
                    Статус
                    <select name="ID_status_code">
                        <option value="1" <?= ($_POST['ID_status_code'] ?? 1) == 1 ? 'selected' : '' ?>>Исправен</option>
                        <option value="2" <?= ($_POST['ID_status_code'] ?? 1) == 2 ? 'selected' : '' ?>>В ремонте</option>
                        <option value="3" <?= ($_POST['ID_status_code'] ?? 1) == 3 ? 'selected' : '' ?>>Списан</option>
                    </select>
                </label>

                <label>
                    Ответственный сотрудник
                    <select name="ID_employee_role">
                        <option value="">Не назначен</option>
                        <?php if (isset($employees)): foreach ($employees as $empRole):
                            $emp = $empRole->employee;
                            $role = $empRole->role;
                            ?>
                            <option value="<?= $empRole->ID_employee_role ?>"
                                    <?= ($_POST['ID_employee_role'] ?? '') == $empRole->ID_employee_role ? 'selected' : '' ?>>
                                <?= htmlspecialchars($emp->login) ?> (<?= htmlspecialchars($role->Role_name) ?>)
                            </option>
                        <?php endforeach; endif; ?>
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