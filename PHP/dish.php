<?php
require_once "includes/dhp.inc.php";
/** @var PDO $pdo */

// Проверка ID
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    header("Location: ../HTML/restaurant-LiChun-project.php");
    exit();
}

$id = $_GET['id'];

// Запрос к базе
$query = "SELECT * FROM menu_items WHERE id = :id";
$stmt = $pdo->prepare($query);
$stmt->execute(['id' => $id]);
$dish = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$dish) {
    die("Jídlo nebylo nalezeno.");
}
?>
<!DOCTYPE html>
<html lang="cs">

<head>
    <meta charset="UTF-8">
    <title><?php echo htmlspecialchars($dish['name']); ?> | Li Chun</title>
    <link rel="stylesheet" href="../CSS/dish_page.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
</head>

<body>
    <div class="main-container">
        <nav class="dish-nav">
            <a href="../HTML/restaurant-LiChun-project.php" class="back-link">← Zpět do menu</a>
        </nav>

        <main class="dish-detail">
            <div class="dish-visual">
                <img src="../<?php echo htmlspecialchars($dish['image_path']); ?>" alt="<?php echo htmlspecialchars($dish['name']); ?>">
            </div>

            <div class="dish-content">
                <h1 class="dish-title"><?php echo htmlspecialchars($dish['name']); ?></h1>
                <p class="dish-price-tag"><?php echo htmlspecialchars($dish['price']); ?> CZK</p>

                <div class="dish-text">
                    <h2>Popis</h2>
                    <p><?php echo nl2br(htmlspecialchars($dish['description'])); ?></p>
                </div>

                <div class="dish-meta">
                    <span class="allergen-label">Alergeny:</span>
                    <span class="allergen-list"><?php echo htmlspecialchars($dish['allergens']); ?></span>
                </div>

            </div>
        </main>
    </div>
</body>


</html>