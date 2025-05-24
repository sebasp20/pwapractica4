<?php
session_start();
include('../includes/db.php');
if ($_SESSION['usuario']['rol'] !== 'admin') die("Acceso denegado.");

if (isset($_POST['nueva_tarea'])) {
    $desc = $_POST['descripcion'];
    $uid = $_SESSION['usuario']['id'];
    $conn->query("INSERT INTO tareas (descripcion, usuario_id) VALUES ('$desc', $uid)");
}

if (isset($_GET['borrar'])) {
    $id = $_GET['borrar'];
    $conn->query("DELETE FROM tareas WHERE id = $id");
}

$tareas = $conn->query("SELECT * FROM tareas");
?>

<h2>Administrador - Lista de Tareas</h2>
<form method="POST">
    <input name="descripcion" placeholder="Nueva tarea">
    <button type="submit" name="nueva_tarea">Agregar</button>
</form>

<ul>
<?php while ($tarea = $tareas->fetch_assoc()): ?>
    <li>
        <?= $tarea['descripcion'] ?> - <?= $tarea['completado'] ? '✔' : '❌' ?>
        <a href="?borrar=<?= $tarea['id'] ?>">Eliminar</a>
    </li>
<?php endwhile; ?>
</ul>
