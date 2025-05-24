
<?php
session_start();
if (isset($_SESSION['usuario'])) {
    $rol = $_SESSION['usuario']['rol'];
    header("Location: $rol/dashboard.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Sistema de Tareas</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            padding: 40px;
            background-color: #f0f0f0;
            text-align: center;
        }
        .card {
            background: #fff;
            padding: 30px;
            margin: 0 auto;
            width: 300px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }
        a.button {
            display: inline-block;
            margin-top: 20px;
            padding: 10px 20px;
            background: #0077cc;
            color: white;
            text-decoration: none;
            border-radius: 6px;
        }
    </style>
</head>
<body>
    <div class="card">
        <h2>Bienvenido al Sistema de Tareas</h2>
        <p>Gestione y marque sus tareas según su rol.</p>
        <a class="button" href="auth/login.php">Iniciar sesión</a>
    </div>
</body>
</html>
