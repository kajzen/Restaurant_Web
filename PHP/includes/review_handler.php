<?php
require_once "dhp.inc.php";

/** @var PDO $pdo */

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['action']) && $_POST['action'] === 'update_status') {

    // Получаем ID отзыва и проверяем, что это число
    $review_id = filter_input(INPUT_POST, 'review_id', FILTER_VALIDATE_INT);

    // Получаем статус
    $new_status = $_POST['new_status'] ?? null;

    $allowed_statuses = ['New', 'Approved', 'Rejected'];

    if ($review_id && in_array($new_status, $allowed_statuses)) {
        try {
            $query = "UPDATE reviews SET status = :status WHERE id = :id";
            $stmt = $pdo->prepare($query);
            $stmt->execute([
                'status' => $new_status,
                'id' => $review_id
            ]);

            header("Location: ../admin_dashboard.php?success=review_updated");
            exit();
        } catch (PDOException $e) {
            die("Chyba databáze: " . $e->getMessage());
        }
    } else {
        die("Invalid Input: ID или статус указаны неверно. ID: $review_id, Status: $new_status");
    }
} else {
    header("Location: ../admin.php");
    exit();
}
