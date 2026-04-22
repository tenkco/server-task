<div class="container">
    <h1><?= htmlspecialchars($equipment->Name) ?></h1>

    <div class="table-card">
        <?php if ($equipment->image): ?>
            <div style="text-align: center; margin-bottom: 20px;">
                <img src="/pop-it-mvc/uploads/equipment/<?= htmlspecialchars($equipment->image) ?>"
                     alt="Фото оборудования"
                     style="width: 200px; height: 200px; object-fit: cover; border-radius: 12px; border: 2px solid #0259AA;">
            </div>
        <?php endif; ?>
        <h3>Основные данные</h3>
        <p><b>Инвентарный номер:</b> <?= htmlspecialchars($equipment->Inventory_number) ?></p>
        <br>
        <p><b>Модель:</b> <?= htmlspecialchars($equipment->Model ?? '—') ?></p>
        <br>
        <p><b>Дата ввода:</b> <?= $equipment->Commissioning_date ? date('d.m.Y', strtotime($equipment->Commissioning_date)) : '—' ?></p>
        <br>
        <p><b>Стоимость:</b> <?= number_format($equipment->Price, 2, '.', ' ') ?> ₽</p>
        <br>
        <p>
            <b>Статус:</b>
            <?php
            $badges = [1 => 'badge-ok', 2 => 'badge-repair', 3 => 'badge-off'];
            $cls = $badges[$equipment->ID_status_code] ?? 'badge-ok';
            ?>
            <span class="badge <?= $cls ?>">
                <?= htmlspecialchars($equipment->condition->Condition_name ?? 'Неизвестно') ?>
            </span>
        </p>

        <?php if (app()->auth->user()->isAdmin()): ?>
            <form method="post" action="<?= app()->route->getUrl('/equipment/set-status/' . urlencode($equipment->Inventory_number)) ?>" style="margin-top: 15px; padding-top: 15px; border-top: 1px solid #999;">
                <input name="csrf_token" type="hidden" value="<?= \Src\Auth\Auth::generateCSRF() ?>">

                <label>
                    Изменить статус:
                    <select name="ID_status_code" required style="width: 100%; padding: 8px; margin-top: 5px;">
                        <option value="1" <?= ($equipment->ID_status_code == 1) ? 'selected' : '' ?>>Исправен</option>
                        <option value="2" <?= ($equipment->ID_status_code == 2) ? 'selected' : '' ?>>В ремонте</option>
                        <option value="3" <?= ($equipment->ID_status_code == 3) ? 'selected' : '' ?>>Списан</option>
                    </select>
                </label>
                <button type="submit" class="btn btn-primary" style="margin-top: 10px;">Сохранить</button>
            </form>
        <?php endif; ?>
    </div>

    <div class="table-card">
        <h3>Ответственный</h3>
        <?php if ($responsible): ?>
            <p><b><?= htmlspecialchars($responsible->employee->login ?? 'Нет логина') ?></b></p>
        <?php else: ?>
            <p>Не назначен</p>
        <?php endif; ?>

        <?php if (app()->auth->user()->isAdmin()): ?>
            <form method="post" action="<?= app()->route->getUrl('/equipment/set-responsible/' . urlencode($equipment->Inventory_number)) ?>" style="margin-top: 15px; padding-top: 15px; border-top: 1px solid #999;">
                <input name="csrf_token" type="hidden" value="<?= \Src\Auth\Auth::generateCSRF() ?>">

                <label>
                    Изменить ответственного:
                    <select name="ID_employee_role" required style="width: 100%; padding: 8px; margin-top: 5px;">
                        <option value="">— Не назначен —</option>
                        <?php foreach ($employees as $empRole):
                            $emp = $empRole->employee;
                            $role = $empRole->role;
                            $selected = ($responsible && $responsible->ID_employee_role == $empRole->ID_employee_role) ? 'selected' : '';
                            ?>
                            <option value="<?= $empRole->ID_employee_role ?>" <?= $selected ?>>
                                <?= htmlspecialchars($emp->login ?? 'Без логина') ?> (<?= htmlspecialchars($role->Role_name) ?>)
                            </option>
                        <?php endforeach; ?>
                    </select>
                </label>
                <button type="submit" class="btn btn-primary" style="margin-top: 10px;">Сохранить</button>
            </form>
        <?php endif; ?>
    </div>

    <div class="table-card">
        <h3>История ремонта</h3>
        <?php if ($equipment->repairs->isEmpty()): ?>
            <p>Ремонтов не зафиксировано</p>
        <?php else: ?>
            <table>
                <thead>
                <tr>
                    <th>Дата поломки</th>
                    <th>Дата ремонта</th>
                    <th>Описание</th>
                    <th>Стоимость</th>
                </tr>
                </thead>
                <tbody>
                <?php foreach ($equipment->repairs as $repair): ?>
                    <tr>
                        <td><?= $repair->Date_of_breakdown ? date('d.m.Y', strtotime($repair->Date_of_breakdown)) : '—' ?></td>
                        <td><?= $repair->Repair_date ? date('d.m.Y', strtotime($repair->Repair_date)) : '—' ?></td>
                        <td><?= htmlspecialchars($repair->Description_of_work) ?></td>
                        <td><?= number_format($repair->Price, 2, '.', ' ') ?> ₽</td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
        <?php endif; ?>

        <?php if (app()->auth->user()->isAdmin()): ?>
            <div style="margin-top: 15px;">
                <a href="<?= app()->route->getUrl('/repair/create/' . urlencode($equipment->Inventory_number)) ?>"
                   class="btn btn-primary">Добавить ремонт</a>
            </div>
        <?php endif; ?>
    </div>

    <div class="btn-row">
        <a href="<?= app()->route->getUrl('/equipment') ?>" class="btn btn-secondary">Назад к списку</a>
    </div>
</div>