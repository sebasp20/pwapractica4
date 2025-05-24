<?php
session_start();
include('../includes/db.php');

// Verifica si ya hay sesión
if (isset($_SESSION['usuario'])) {
    $rol = $_SESSION['usuario']['rol'];
    header("Location: ../$rol/dashboard.php");
    exit();
}

// Proceso del formulario
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = trim($_POST['email']);
    $contrasena = trim($_POST['contrasena']);

    if (empty($email) || empty($contrasena)) {
        $error = "Ingrese email y contraseña.";
    } else {
        $stmt = $conn->prepare("SELECT * FROM usuarios WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($usuario = $result->fetch_assoc()) {
            // Validación simple: compara texto plano
            if ($usuario['contrasena'] === $contrasena) {
                $_SESSION['usuario'] = $usuario;
                header("Location: ../{$usuario['rol']}/dashboard.php");
                exit();
            } else {
                $error = "Contraseña incorrecta.";
            }
        } else {
            $error = "Usuario no encontrado.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Login - Tareas</title>
</head>
<body>
    <h2>Iniciar Sesión</h2>
    <?php if (isset($error)): ?>
        <p style="color:red;"><?= $error ?></p>
    <?php endif; ?>
    <form method="POST">
        <label>Email:</label><br>
        <input type="text" name="email"><br><br>
        <label>Contraseña:</label><br>
        <input type="password" name="contrasena"><br><br>
        <button type="submit">Entrar</button>
    </form>
</body>
</html>


