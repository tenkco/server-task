<div class="container">
    <h1>Отчёт по кафедре</h1>
    <form method="get" style="max-width:560px;margin:0 auto 30px;">
        <select name="department_id" onchange="this.form.submit()"
                style="width:100%;padding:16px 20px;border-radius:30px;border:none;font-size:14px;background:#fff;color:#111;">
            <option value="">— Все кафедры —</option>
            <?php foreach ($departments as $dept): ?>
                <option value="<?= $dept->id ?>" <?= $deptId == $dept->id ? 'selected' : '' ?>>
                    <?= htmlspecialchars($dept->name) ?>
                </option>
            <?php endforeach; ?>
        </select>
    </form>
    <div class="metrics">
        <div class="metric-card">
            <div class="metric-title">Оборудования</div>
            <div class="metric-value"><?= $total ?> единиц</div>
        </div>
        <div class="metric-card">
            <div class="metric-title">В ремонте</div>
            <div class="metric-value"><?= $inRepair ?> единица</div>
        </div>
        <div class="metric-card">
            <div class="metric-title">Общая стоимость</div>
            <div class="metric-value"><?= number_format($totalCost, 0, '.', ' ') ?> ₽</div>
        </div>
        <div class="metric-card">
            <div class="metric-title">Амортизация</div>
            <div class="metric-value"><?= number_format($depreciation, 0, '.', ' ') ?> ₽</div>
        </div>
    </div>
</div>
