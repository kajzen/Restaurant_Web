<?php

if (empty($_POST)) {
    echo "ГДЕ ДАННЫЕ, ЛЕБОВСКИ?";
}

require_once "dhp.inc.php";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $author = htmlspecialchars($_POST['author']);
    $rating = filter_input(INPUT_POST, 'rating', FILTER_VALIDATE_INT);
    $comment = htmlspecialchars($_POST['comment']);

    if ($author && $rating && $comment) {
        try {
            // Статус ВСЕГДА 'New' при добавлении гостем
            $query = "INSERT INTO reviews (author_name, rating, comment, status) VALUES (?, ?, ?, 'New')";
            $stmt = $pdo->prepare($query);
            $stmt->execute([$author, $rating, $comment]);

            // Возвращаем гостя на главную или страницу отзывов
            header("Location: ../../HTML/restaurant-LiChun-project.php?review=success");
            exit();
        } catch (PDOException $e) {
            die("Chyba: " . $e->getMessage());
        }
    }
}
