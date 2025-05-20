<?php
session_start();
require 'config.php';

// Verificar usuario logueado
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

function isAdmin() {
    return $_SESSION['role'] === 'administrador';
}

// Agregar tarea
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_task'])) {
    $desc = trim($_POST['description']);
    if ($desc) {
        $stmt = $pdo->prepare("INSERT INTO tasks (user_id, description) VALUES (?, ?)");
        $stmt->execute([$_SESSION['user_id'], $desc]);
    }
}

// Eliminar tarea (solo admin)
if (isset($_GET['delete_task']) && isAdmin()) {
    $task_id = (int)$_GET['delete_task'];
    $stmt = $pdo->prepare("DELETE FROM tasks WHERE id = ?");
    $stmt->execute([$task_id]);
}

// Marcar tarea completada
if (isset($_GET['complete_task'])) {
    $task_id = (int)$_GET['complete_task'];
    $stmt = $pdo->prepare("UPDATE tasks SET is_completed = 1 WHERE id = ?");
    $stmt->execute([$task_id]);
}

// Obtener tareas
$stmt = $pdo->query("SELECT tasks.*, users.username FROM tasks JOIN users ON tasks.user_id = users.id ORDER BY tasks.created_at DESC");
$tasks = $stmt->fetchAll();
?>

<h2>Lista de Tareas</h2>
<p>Bienvenido, <?php echo htmlspecialchars($_SESSION['username']); ?> (Rol: <?php echo $_SESSION['role']; ?>)</p>
<form method="POST">
    <input type="text" name="description" placeholder="Nueva tarea..." required>
    <button type="submit" name="add_task">Agregar</button>
</form>
<ul>
    <?php foreach ($tasks as $task): ?>
        <li>
            <?php echo htmlspecialchars($task['description']); ?> 
            (por <?php echo htmlspecialchars($task['username']); ?>)
            <?php if (!$task['is_completed']): ?>
                <a href="?complete_task=<?php echo $task['id']; ?>">[Marcar completada]</a>
            <?php else: ?>
                <strong>[Completada]</strong>
            <?php endif; ?>
            <?php if (isAdmin()): ?>
                <a href="?delete_task=<?php echo $task['id']; ?>" onclick="return confirm('¿Eliminar tarea?')">[Eliminar]</a>
            <?php endif; ?>
        </li>
    <?php endforeach; ?>
</ul>
<p><a href="logout.php">Cerrar sesión</a></p>
