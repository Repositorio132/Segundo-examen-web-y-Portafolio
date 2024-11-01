<?php
require "../proyecto/conect.php";
?>


    <div class="login-container">
        <h2>Inicio de Sesión</h2>
        <form action="../proyecto/proyecto.php" method="POST">
            <div class="form-group">
                <label for="username">Usuario:</label>
                <input type="text" id="username" name="username" required>
            </div>
            <div class="form-group">
                <label for="password">Contraseña:</label>
                <input type="password" id="password" name="password" required>
            </div>
            <button type="submit" class="login-btn">Iniciar Sesión</button>
        </form>
        <p>¿No tienes una cuenta? <a href="../proyecto/registro.php" class="toggle-btn">Regístrate aquí</a></p>
    </div>

