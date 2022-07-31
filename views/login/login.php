<div class="body-login">
    <div class="login">
        <div class="login-title">Bienvenido</div>
        <form action="<?=URL_BASE?>login/autenticar" method="POST">
            <div class="form-field-ow">
                <label class="weigth-500-ow" for="username">Usuario</label>
                <input class="input-ow input-height-ow" type="text" name="username" required>
            </div>
            <div class="form-field-ow">
                <label class="weigth-500-ow" for="password">Contraseña</label>
                <input class="input-ow input-height-ow" type="password" name="password" required>
            </div>
            <button type="submit" class="btn-ow btn-ow-blue">Iniciar sesión</button>
        </form>
    </div>
</div>
</body>
</html>
