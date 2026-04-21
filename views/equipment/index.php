<div class="container">
    <h1>Все оборудование</h1>
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