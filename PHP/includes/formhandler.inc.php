<?php
session_start();
require_once "dhp.inc.php";
/** @var PDO $pdo */

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $email = trim($_POST["email"]);
    $pwd_input = $_POST["pwd"];

    if (empty($email) || empty($pwd_input)) {
        header("Location: ../admin.php?error=empty");
        exit();
    }

    try {
        // Ищем админа по email
        $query = "SELECT * FROM admin WHERE email = ?;";
        $stmt = $pdo->prepare($query);
        $stmt->execute([$email]);
        $admin = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($admin && password_verify($pwd_input, $admin['pwd'])) {
            session_regenerate_id(true);

            $_SESSION['admin_logged_in'] = true;
            $_SESSION['admin_id'] = $admin['id'];
            $_SESSION['admin_email'] = $admin['email'];

            header("Location: ../admin_dashboard.php");
            exit();
        } else {
            // Ошибка
            header("Location: ../admin.php?error=wronglogin");
            exit();
        }
    } catch (PDOException $e) {
        die("Chyba databáze: " . $e->getMessage());
    }
} else {
    header("Location: ../admin.php");
    exit();
}
