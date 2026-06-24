<?php
session_start();
require_once "dhp.inc.php";
/** @var PDO $pdo */

// Проверяем, что админ залогинен
if (!isset($_SESSION['admin_logged_in'])) {
    header("Location: ../admin.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['submit_change'])) {

    $new_email = filter_input(INPUT_POST, 'new_email', FILTER_VALIDATE_EMAIL);
    $pass = $_POST['new_password'];
    $confirm = $_POST['confirm_password'];

    // Проверка на пустоту и совпадение паролей
    if (!$new_email || empty($pass) || empty($confirm)) {
        header("Location: ../change_password.php?error=empty");
        exit();
    }

    if ($pass !== $confirm) {
        header("Location: ../change_password.php?error=mismatch");
        exit();
    }

    // 3. Хешируем пароль 
    $hashed_password = password_hash($pass, PASSWORD_DEFAULT);

    try {
        // Обновляем данные в таблице админов
        $query = "UPDATE admin SET email = :email, pwd = :pwd LIMIT 1";
        $stmt = $pdo->prepare($query);

        $stmt->execute([
            'email' => $new_email,
            'pwd' => $hashed_password
        ]);

        header("Location: ../change_password.php?success=1");
        exit();
    } catch (PDOException $e) {
        header("Location: ../change_password.php?error=db_error");
        exit();
    }
} else {
    header("Location: ../admin_dashboard.php");
    exit();
}
