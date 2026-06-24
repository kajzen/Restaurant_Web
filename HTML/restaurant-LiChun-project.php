<?php
// ПОДКЛЮЧЕНИЕ К БАЗЕ ДАННЫХ
require_once "../PHP/includes/dhp.inc.php";
/** @var PDO $pdo */ // 
try {
  // Получаем все блюда
  $query = "SELECT * FROM menu_items ORDER BY category, name ASC;";
  $stmt = $pdo->query($query);
  $menu_items = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
  die("Chyba při načítání menu: " . $e->getMessage());
}


try {
  // Получаем одобренные отзывы для слайдера
  $query_rev = "SELECT author_name, comment, rating FROM reviews WHERE status = 'Approved' ORDER BY created_at DESC LIMIT 10;";
  $stmt_rev = $pdo->query($query_rev);
  $approved_reviews = $stmt_rev->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
  $approved_reviews = []; // Если ошибка, просто пустой массив
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
  <link rel="preconnect" href="https://fonts.googleapis.com" />
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
  <link
    href="https://fonts.googleapis.com/css2?family=BBH+Sans+Bogle&family=Caprasimo&display=swap"
    rel="stylesheet" />
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Restaurant</title>
  <link rel="stylesheet" href="../CSS/style.css" />
</head>

<body>
  <div class="header-container">
    <nav class="main-menu">
      <a class="top-links" href="../PHP/about.php">About Us

      </a>
      <a class="top-links" href="../PHP/news.php">News
      </a>
      <a
        class="top-links"
        href="../PHP/reservations.php">Udelat reservaci
      </a>
      <a
        class="top-links"
        href="../PHP/reviews.php">Zanechat recenzi
      </a>
      <a
        class="top-links"
        href="../PHP/documentation.php">Documentace
      </a>
    </nav>

    <a href="../PHP/admin.php" class="admin-secret-link">
      <img
        class="Logo-LiChun"
        src="../images/logo.png"
        alt="Logo-LiChun"
        width="200"
        height="200" />
    </a>
  </div>

  <h1 class="just-main-text">
    The most authentic<br />
    chinesee noodles in Prague
  </h1>


  <div class="reviews-slider">
    <div class="reviews-track">
      <?php if (!empty($approved_reviews)): ?>
        <?php
        // Повторяем дважды для бесконечного эффекта
        for ($i = 0; $i < 2; $i++):
          foreach ($approved_reviews as $rev): ?>
            <div class="review-slide">
              <p class="rev-rating"><?php echo str_repeat('⭐', $rev['rating']); ?></p>
              <p class="rev-text">"<?php echo htmlspecialchars($rev['comment']); ?>"</p>
              <p class="rev-author">- <?php echo htmlspecialchars($rev['author_name']); ?></p>
            </div>
        <?php endforeach;
        endfor; ?>
      <?php else: ?>
        <div class="review-slide">
          <p>Zatím žádné recenze.</p>
        </div>
      <?php endif; ?>
    </div>
  </div>

  <div class="dishes">
    <?php
    $current_category = '';

    // ЦИКЛ ВЫВОДА БЛЮД
    foreach ($menu_items as $dish) {
    ?>
      <div class="dish-card">
        <a href="../PHP/dish.php?id=<?php echo $dish['id']; ?>" class="dish-link">
          <img class="dish_image" src="../<?php echo htmlspecialchars($dish['image_path']); ?>" alt="<?php echo htmlspecialchars($dish['name']); ?>">
          <p class="food-name"><?php echo htmlspecialchars($dish['name']); ?></p>
        </a>
        <p class="food-description"><?php echo htmlspecialchars($dish['description']); ?></p>
        <p class="food-description">Alergeny: <?php echo htmlspecialchars($dish['allergens']); ?></p>
        <p class="food-price"><?php echo htmlspecialchars($dish['price']); ?> CZK</p>

      </div>

    <?php
    } // Конец цикла foreach

    if (empty($menu_items)) {
      echo "<p>Menu se v tuto chvíli připravuje.</p>";
    }
    ?>
  </div>
</body>

</html>