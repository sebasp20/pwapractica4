<?php
session_start();
require 'config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username']);
    $password = $_POST['password'];
    $role = $_POST['role'];  // 'administrador' o 'usuario'

    if ($username && $password && in_array($role, ['administrador', 'usuario'])) {
        $hash = password_hash($password, PASSWORD_DEFAULT);

        $stmt = $pdo->prepare("INSERT INTO users (username, password_hash, role) VALUES (?, ?, ?)");
        try {
            $stmt->execute([$username, $hash, $role]);
            $_SESSION['message'] = "Usuario registrado exitosamente.";
            header('Location: login.php');
            exit;
        } catch (PDOException $e) {
            $error = "El usuario ya existe.";
        }
    } else {
        $error = "Por favor, complete todos los campos correctamente.";
    }
}
?>

<h2>Registrar Usuario</h2>
<?php if (!empty($error)) echo "<p style='color:red;'>$error</p>"; ?>
<form method="POST">
    <label>Usuario: <input type="text" name="username" required></label><br>
    <label>Contraseña: <input type="password" name="password" required></label><br>
    <label>Rol:
        <select name="role">
            <option value="usuario">Usuario</option>
            <option value="administrador">Administrador</option>
        </select>
    </label><br>
    <button type="submit">Registrar</button>
</form>
<p><a href="login.php">Iniciar sesión</a></p>
