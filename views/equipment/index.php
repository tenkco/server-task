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
                <tr onclick="location.href='<?= app()->route->getUrl('/equipment/show/' . $item->id) ?>'">
                    <td><?= htmlspecialchars($item->inventory_number) ?></td>
                    <td><?= htmlspecialchars($item->name) ?></td>
                    <td><?= htmlspecialchars($item->department->name ?? '—') ?></td>
                    <td>
                        <?php
                        $badges = [1 => 'badge-ok', 2 => 'badge-repair', 3 => 'badge-off'];
                        $cls = $badges[$item->condition_id] ?? 'badge-ok';
                        ?>
                        <span class="badge <?= $cls ?>"><?= htmlspecialchars($item->condition->name ?? '') ?></span>
                    </td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    <div class="btn-row" style="max-width:560px;margin:0 auto;">
        <?php if (app()->auth::user()->isAdmin()): ?>
            <a href="<?= app()->route->getUrl('/equipment/create') ?>" class="btn btn-primary">Добавить</a>
        <?php endif; ?>
        <a href="<?= app()->route->getUrl('/report') ?>" class="btn btn-secondary">Отчёт</a>
    </div>
</div>