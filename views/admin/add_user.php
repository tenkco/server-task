<div class="container">
    <h1>Добавление лаборанта/инженера</h1>
    <div class="form-wrap">
        <?php if (!empty($message)): ?>
            <div class="<?= strpos($message, 'успешно') !== false ? 'success-msg' : 'error-msg' ?>">
                <?= htmlspecialchars($message) ?>
            </div>
        <?php endif; ?>

        <form method="post" action="<?= app()->route->getUrl('/admin/users') ?>">
            <input name="csrf_token" type="hidden" value="<?= \Tenkco\Auth\Auth::generateCSRF() ?>">

            <div style="display:flex;flex-direction:column;gap:14px;">
                <label>
                    Логин:
                    <input type="text" name="login" placeholder="Введите логин" required style="color: white"
                           value="<?= htmlspecialchars(($request->all()['login'] ?? '')) ?>">
                </label>

                <label>
                    Пароль:
                    <input type="password" name="password" placeholder="Введите пароль" required style="color: white">
                </label>

                <label>
                    Роль:
                    <select name="ID_role_name" required style="width: 100%; padding: 8px; margin-top: 5px;">
                        <option value="">Выберите роль</option>
                        <?php foreach ($roles as $role): ?>
                            <option value="<?= $role->ID_role_name ?>"
                                    <?= (($request->all()['ID_role_name'] ?? '') == $role->ID_role_name) ? 'selected' : '' ?>>
                                <?= htmlspecialchars($role->Role_name) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </label>

                <div class="btn-row">
                    <button class="btn btn-primary">Сохранить</button>
                    <a href="<?= app()->route->getUrl('/equipment') ?>" class="btn btn-secondary">Отмена</a>
                </div>
            </div>
        </form>
    </div>
</div>