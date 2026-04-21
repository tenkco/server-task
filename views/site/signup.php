<div class="container">
    <h1>Добавление лаборанта/инженера</h1>
    <div class="form-wrap">
        <?php if (!empty($message)): ?>
            <div class="error-msg"><?= htmlspecialchars($message) ?></div>
        <?php endif; ?>
        <form method="post">
            <div style="display:flex;flex-direction:column;gap:14px;">
                <label>
                    Логин *
                    <input type="text" name="Login" required placeholder="Придумайте логин">
                </label>
                <label>
                    Пароль *
                    <input type="password" name="password" required placeholder="Придумайте пароль">
                </label>
                <div class="btn-row">
                    <button type="submit" class="btn btn-primary">Сохранить</button>
                    <a href="<?= app()->route->getUrl('/equipment') ?>" class="btn btn-secondary">Отмена</a>
                </div>
            </div>
        </form>
    </div>
</div>