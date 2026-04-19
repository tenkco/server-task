<div class="container">
    <h1><?= htmlspecialchars($item->name) ?></h1>
    <div class="detail-grid">
        <div class="detail-card">
            <h3>Основные данные</h3>
            <div class="detail-row">
                <div class="detail-label">Инвентарный номер</div>
                <div class="detail-value"><?= htmlspecialchars($item->inventory_number) ?></div>
            </div>
            <div class="detail-row">
                <div class="detail-label">Модель</div>
                <div class="detail-value"><?= htmlspecialchars($item->model) ?></div>
            </div>
            <div class="detail-row">
                <div class="detail-label">Дата ввода в эксплуатацию</div>
                <div class="detail-value"><?= $item->commissioning_date ?></div>
            </div>
            <div class="detail-row">
                <div class="detail-label">Статус</div>
                <div class="detail-value">
                    <?php $badges = [1=>'badge-ok', 2=>'badge-repair', 3=>'badge-off']; ?>
                    <span class="badge <?= $badges[$item->condition_id] ?? '' ?>">
                        <?= htmlspecialchars($item->condition->name ?? '') ?>
                    </span>
                </div>
            </div>
            <div class="detail-row">
                <div class="detail-label">Начальная стоимость</div>
                <div class="detail-value"><?= number_format($item->price, 0, '.', ' ') ?> ₽</div>
            </div>
            <div class="detail-row">
                <div class="detail-label">Амортизация</div>
                <div class="detail-value">−<?= number_format($item->depreciation, 0, '.', ' ') ?> ₽</div>
            </div>
        </div>

        <div style="display:flex;flex-direction:column;gap:16px;">
            <div class="detail-card">
                <h3>Ответственный</h3>
                <div class="detail-value" style="margin-bottom:14px;">
                    <?php if ($item->employeeRole): ?>
                        <?= htmlspecialchars($item->employeeRole->employee->login) ?>
                        <span style="color:#555;font-size:12px;">
                            (<?= htmlspecialchars($item->employeeRole->role->name) ?>)
                        </span>
                    <?php else: ?>
                        Не назначен
                    <?php endif; ?>
                </div>
                <?php if (app()->auth::user()->isAdmin()): ?>
                    <form method="post" action="<?= app()->route->getUrl('/equipment/assign/' . $item->id) ?>">
                        <select name="employee_role_id"
                                style="width:100%;padding:10px;border-radius:8px;margin-bottom:10px;color:#111;">
                            <option value="">— Выбрать —</option>
                            <?php foreach (\Model\EmployeeRole::with(['employee','role'])->where('role_id',2)->get() as $er): ?>
                                <option value="<?= $er->id ?>"
                                        <?= $item->employee_role_id == $er->id ? 'selected' : '' ?>>
                                    <?= htmlspecialchars($er->employee->login) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                        <button class="btn btn-primary" style="width:100%;">Сменить</button>
                    </form>
                <?php endif; ?>
            </div>

            <?php if (app()->auth::user()->isAdmin()): ?>
                <div class="detail-card">
                    <h3>Добавить ремонт</h3>
                    <a href="<?= app()->route->getUrl('/equipment/repair/' . $item->id) ?>"
                       class="btn btn-primary" style="display:block;text-align:center;">Добавить</a>
                </div>
                <form method="post" action="<?= app()->route->getUrl('/equipment/decommission/' . $item->id) ?>">
                    <button class="btn btn-danger" style="width:100%;">Списать</button>
                </form>
            <?php endif; ?>
        </div>
    </div>

    <div class="detail-card" style="margin-top:16px;">
        <h3>История ремонта</h3>
        <table style="width:100%;border-collapse:collapse;">
            <thead><tr>
                <th style="text-align:left;padding:8px;font-size:12px;color:#1a4fd6;text-transform:uppercase;">Дата поломки</th>
                <th style="text-align:left;padding:8px;font-size:12px;color:#1a4fd6;text-transform:uppercase;">Дата ремонта</th>
                <th style="text-align:left;padding:8px;font-size:12px;color:#1a4fd6;text-transform:uppercase;">Описание</th>
                <th style="text-align:left;padding:8px;font-size:12px;color:#1a4fd6;text-transform:uppercase;">Стоимость</th>
            </tr></thead>
            <tbody>
            <?php foreach ($item->repairs as $repair): ?>
                <tr>
                    <td style="padding:8px;font-size:13px;color:#111;"><?= $repair->breakdown_date ?></td>
                    <td style="padding:8px;font-size:13px;color:#111;"><?= $repair->repair_date ?? '—' ?></td>
                    <td style="padding:8px;font-size:13px;color:#111;"><?= htmlspecialchars($repair->description ?? '') ?></td>
                    <td style="padding:8px;font-size:13px;color:#111;"><?= number_format($repair->price, 0, '.', ' ') ?> ₽</td>
                </tr>
            <?php endforeach; ?>
            <?php if ($item->repairs->isEmpty()): ?>
                <tr><td colspan="4" style="padding:12px;color:#555;text-align:center;">Ремонтов не было</td></tr>
            <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>