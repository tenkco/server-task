<div class="container">
    <h1>Добавление лаборанта/инженера</h1>
    <div class="form-wrap">
        <?php if (!empty($error)): ?>
            <div class="error-msg"><?= htmlspecialchars($error) ?></div>
        <?php endif; ?>
        <form method="post" action="<?= app()->route->getUrl('/admin/users') ?>">
            <div style="display:flex;flex-direction:column;gap:14px;">
                <input type="text"     name="login"    placeholder="Логин" required>
                <input type="password" name="password" placeholder="Пароль" required>
                <div class="btn-row">
                    <button class="btn btn-primary">Сохранить</button>
                    <a href="<?= app()->route->getUrl('/equipment') ?>" class="btn btn-secondary">Отмена</a>
                </div>
            </div>
        </form>
    </div>
</div>