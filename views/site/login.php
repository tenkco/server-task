<div class="container">
    <h1>Авторизация</h1>
    <div class="form-wrap">
        <?php if (!empty($message)): ?>
            <div class="error-msg"><?= htmlspecialchars($message) ?></div>
        <?php endif; ?>

        <form method="post">
            <input name="csrf_token" type="hidden" value="<?= \Src\Auth\Auth::generateCSRF() ?>">

            <div style="display:flex;flex-direction:column;gap:14px;">
                <label>
                    Логин
                    <input type="text" name="login" required placeholder="Введите логин">
                </label>
                <label>
                    Пароль
                    <input type="password" name="password" required placeholder="Введите пароль">
                </label>
                <div class="btn-row">
                    <button type="submit" class="btn btn-primary">Войти</button>
                </div>
            </div>
        </form>
    </div>
</div>