<?php
require_once "dhp.inc.php";

/** @var PDO $pdo */

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['submit_res'])) {

    // ПОЛУЧАЕМ Raw Data
    $name = trim($_POST['name']);
    $email = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL);
    $phone = trim($_POST['phone']);
    $guests = (int)$_POST['guests'];
    $date = $_POST['date'];
    $time = $_POST['time'];
    $notes = trim($_POST['notes']);

    $errors = [];

    // Телефон
    if (!preg_match("/^[+]?[0-9\s]{9,15}$/", $phone)) {
        $errors[] = "invalid_phone";
    }

    // Гости
    if ($guests <= 0 || $guests > 30) {
        $errors[] = "invalid_guests";
    }

    // Время 
    $hour = (int)date("H", strtotime($time));
    if ($hour < 11 || $hour >= 21) {
        $errors[] = "invalid_time";
    }

    // Дата
    try {
        $today = new DateTime('today');
        $resDate = new DateTime($date);
        $maxDate = new DateTime('+1 year');

        if ($resDate < $today) {
            $errors[] = "date_in_past";
        } elseif ($resDate > $maxDate) {
            $errors[] = "date_too_far";
        }
    } catch (Exception $e) {
        $errors[] = "invalid_data";
    }

    if (!empty($errors)) {
        header("Location: ../reservations.php?error=" . $errors[0]);
        exit();
    }

    // ЗАПИСЬ В БАЗУ
    if ($name && $email && $date && $time) {
        try {
            $query = "INSERT INTO reservations (name, email, phone, guests, reservation_date, reservation_time, notes, status) 
                      VALUES (:name, :email, :phone, :guests, :res_date, :res_time, :notes, 'New')";

            $stmt = $pdo->prepare($query);
            $stmt->execute([
                'name' => $name,
                'email' => $email,
                'phone' => $phone,
                'guests' => $guests,
                'res_date' => $date,
                'res_time' => $time,
                'notes' => $notes
            ]);

            header("Location: ../reservations.php?success=1");
            exit();
        } catch (PDOException $e) {
            die("Chyba databáze: " . $e->getMessage());
        }
    } else {
        header("Location: ../reservations.php?error=empty_fields");
        exit();
    }
} else {
    header("Location: ../reservations.php");
    exit();
}
