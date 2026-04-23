<div class="container">
    <h1>Все оборудование</h1>

    <div class="search-form">
        <form method="GET" action="<?= app()->route->getUrl('/equipment') ?>">
            <input
                    type="text"
                    name="search"
                    value="<?= htmlspecialchars($search ?? '') ?>"
                    placeholder="Поиск"
                    style="width: 100%; padding: 12px; margin-bottom: 10px; border: 1px solid #0259AA; border-radius: 6px; font-size: 14px; background: #0D0D0D; color: white;">

            <button type="submit" class="btn btn-primary" style="width: 100%;">
                Найти
            </button>

            <?php if (!empty($search)): ?>
                <a href="<?= app()->route->getUrl('/equipment') ?>" class="btn btn-secondary" style="width: 100%; margin-top: 10px;">
                    Сбросить
                </a>
            <?php endif; ?>
        </form>
    </div>
    <div class="table-card">
        <table>
            <thead>
            <tr>
                <th>Инв. №</th>
                <th>Наименование</th>
                <th>Кафедра</th>
                <th>Статус</th>
            </tr>
            </thead>
            <tbody>
            <?php foreach ($equipment as $item): ?>
                <tr onclick="location.href='<?= app()->route->getUrl('/equipment/show/' . urlencode($item->Inventory_number)) ?>'">
                    <td><?= htmlspecialchars($item->Inventory_number) ?></td>
                    <td><?= htmlspecialchars($item->Name) ?></td>
                    <td><?= htmlspecialchars($item->department->Department_name ?? '—') ?></td>
                    <td>
                        <?php
                        $badges = [1 => 'badge-ok', 2 => 'badge-repair', 3 => 'badge-off'];
                        $cls = $badges[$item->ID_status_code] ?? 'badge-ok';
                        ?>
                        <span class="badge <?= $cls ?>"><?= htmlspecialchars($item->condition->Condition_name ?? '') ?></span>
                    </td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    <div class="btn-row">
        <?php if (app()->auth->user()->isAdmin()): ?>
            <a href="<?= app()->route->getUrl('/equipment/create') ?>" class="btn btn-primary">Добавить</a>
        <?php endif; ?>
        <a href="<?= app()->route->getUrl('/report') ?>" class="btn btn-secondary">Отчёт</a>
    </div>
</div>