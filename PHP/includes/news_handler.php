<?php
session_start();
require_once "dhp.inc.php";
/** @var PDO $pdo */

if (!isset($_SESSION['admin_logged_in'])) {
    exit("Access Denied");
}

// ДОБАВЛЕНИЕ
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['action']) && $_POST['action'] === 'add_news') {
    $title = trim($_POST['title']);
    $content = trim($_POST['content']);

    if (!empty($title) && !empty($content)) {
        $stmt = $pdo->prepare("INSERT INTO news (title, content, created_at) VALUES (?, ?, NOW())");
        $stmt->execute([$title, $content]);
        header("Location: ../admin_dashboard.php?success=news_added");
        exit();
    }
}

// УДАЛЕНИЕ
if (isset($_GET['action']) && $_GET['action'] === 'delete' && isset($_GET['id'])) {
    $id = (int)$_GET['id'];
    $stmt = $pdo->prepare("DELETE FROM news WHERE id = ?");
    $stmt->execute([$id]);

    if (isset($_GET['ajax'])) {
        header('Content-Type: application/json');
        echo json_encode(['status' => 'success']);
        exit();
    }
    header("Location: ../admin_dashboard.php?success=news_deleted");
    exit();
}
