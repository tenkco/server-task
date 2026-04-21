<div class="container">
    <h1>Отчёт по стоимости оборудования</h1>

    <form method="get" style="margin-bottom: 20px;">
        <label>
            Кафедра:
            <select name="department_id" onchange="this.form.submit()">
                <option value="">Все кафедры</option>
                <?php foreach ($departments as $dept): ?>
                    <option value="<?= $dept->ID_department ?>"
                            <?= $selectedDepartment == $dept->ID_department ? 'selected' : '' ?>>
                        <?= htmlspecialchars($dept->Department_name) ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </label>
    </form>

    <div class="table-card text-center">
        <h2 style="text-align: left">Общая стоимость:</h2>
        <p style="font-size: 2em; font-weight: 700; color: var(--btn-primary);">
            <?= number_format($total, 2, '.', ' ') ?> ₽
        </p>
    </div>

    <div class="btn-row">
        <a href="<?= app()->route->getUrl('/equipment') ?>" class="btn btn-secondary">Назад</a>
    </div>
</div>