<?php
require "../proyecto/conect.php";

?>

    <div class="register-container">
        <h2>Registro</h2>
        <form action="../proyecto/registro.php" method="POST">
            <div class="form-group">
                <label for="new-username">Usuario:</label>
                <input type="text" id="new-username" name="new-username" required>
            </div>
            <div class="form-group">
                <label for="new-password">Contraseña:</label>
                <input type="password" id="new-password" name="new-password" required>
            </div>
            <div class="form-group">
                <label for="email">Correo Electrónico:</label>
                <input type="email" id="email" name="email" required>
            </div>
            <button type="submit" class="register-btn">Registrarse</button>
        </form>
        <p>¿Ya tienes una cuenta? <a href="../proyecto/proyecto.php" class="toggle-btn">Inicia sesión aquí</a></p>
    </div>

