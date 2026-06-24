<?php
require_once "dhp.inc.php";

/** @var PDO $pdo */


if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['action']) && $_POST['action'] === 'update_status') {
    $res_id = filter_input(INPUT_POST, 'res_id', FILTER_VALIDATE_INT);
    $new_status = htmlspecialchars($_POST['new_status']);

    if ($res_id && $new_status) {
        try {
            $query = "UPDATE reservations SET status = :status WHERE id = :id";
            $stmt = $pdo->prepare($query);
            $stmt->execute([
                'status' => $new_status,
                'id' => $res_id
            ]);
            header("Location: ../admin_dashboard.php?success=res_updated");
            exit();
        } catch (PDOException $e) {
            die("Chyba databáze: " . $e->getMessage());
        }
    }
}
