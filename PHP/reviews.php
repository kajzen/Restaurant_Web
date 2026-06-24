<?php
require_once "includes/dhp.inc.php";
/** @var PDO $pdo */

// --- ЛОГИКА ФИЛЬТРАЦИИ И ПАГИНАЦИИ ---

// 1. Получаем текущую страницу и выбранный рейтинг
$page = filter_input(INPUT_GET, 'page', FILTER_VALIDATE_INT) ?: 1;
$filter_rating = filter_input(INPUT_GET, 'rating', FILTER_VALIDATE_INT) ?: 0;
$limit = 5; // Количество отзывов на одной странице
$offset = ($page - 1) * $limit;

// 2. Строим базовый SQL запрос
$sql_count = "SELECT COUNT(*) FROM reviews WHERE status = 'Approved'";
$sql_data = "SELECT * FROM reviews WHERE status = 'Approved'";
$params = [];

// Если выбран фильтр по оценке
if ($filter_rating >= 1 && $filter_rating <= 5) {
    $sql_count .= " AND rating = :rating";
    $sql_data .= " AND rating = :rating";
    $params['rating'] = $filter_rating;
}

$sql_data .= " ORDER BY created_at DESC LIMIT $limit OFFSET $offset";

// 3. Считаем общее количество страниц
$stmt_total = $pdo->prepare($sql_count);
$stmt_total->execute($params);
$total_reviews = $stmt_total->fetchColumn();
$total_pages = ceil($total_reviews / $limit);

// 4. Получаем данные для текущей страницы
$stmt = $pdo->prepare($sql_data);
$stmt->execute($params);
$reviews = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="cs">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Recenze | Restaurace Li Chun</title>
    <link rel="stylesheet" href="../CSS/reviews.css">
    <link href="https://fonts.googleapis.com/css2?family=Lilita+One&family=Montserrat:wght@400;700&display=swap" rel="stylesheet">
</head>

<body>
    <div class="reviews-container">
        <section class="review-form-section">
            <h1 class="title">Vaše zpětná vazba</h1>
            <form action="includes/add_review_handler.php" method="POST" class="main-form">
                <div class="input-group">
                    <label for="author_name">Vaše jméno:</label>
                    <input type="text" id="author_name" name="author_name" placeholder="Např. Petr Svoboda" required>
                </div>
                <div class="input-group">
                    <label for="rating">Hodnocení:</label>
                    <div class="select-wrapper">
                        <select id="rating" name="rating">
                            <option value="5">⭐⭐⭐⭐⭐ (5/5)</option>
                            <option value="4">⭐⭐⭐⭐ (4/5)</option>
                            <option value="3">⭐⭐⭐ (3/5)</option>
                            <option value="2">⭐⭐ (2/5)</option>
                            <option value="1">⭐ (1/5)</option>
                        </select>
                    </div>
                </div>
                <div class="input-group">
                    <label for="comment">Váš komentář:</label>
                    <textarea id="comment" name="comment" rows="4" placeholder="Jak vám chutnalo?" required></textarea>
                </div>
                <button type="submit" class="submit-btn">Odeslat recenzi</button>
            </form>
        </section>

        <hr class="separator">

        <section class="reviews-list">
            <h2 class="section-title">Co o nás říkají hosté</h2>

            <form method="GET" style="margin-bottom: 20px; text-align: center;">
                <label for="filter_rating">Filtrovat podle hvězdiček: </label>
                <select name="rating" id="filter_rating" onchange="this.form.submit()">
                    <option value="0">Všechny recenze</option>
                    <?php for ($i = 5; $i >= 1; $i--): ?>
                        <option value="<?php echo $i; ?>" <?php echo $filter_rating == $i ? 'selected' : ''; ?>>
                            <?php echo $i; ?> ⭐
                        </option>
                    <?php endfor; ?>
                </select>
            </form>

            <?php if (empty($reviews)): ?>
                <p style="text-align: center;">V této kategorii zatím nejsou žádné recenze.</p>
            <?php else: ?>
                <?php foreach ($reviews as $rev): ?>
                    <div class="review-card">
                        <div class="review-header">
                            <span class="review-author"><?php echo htmlspecialchars($rev['author_name']); ?></span>
                            <span class="review-rating"><?php echo str_repeat('⭐', $rev['rating']); ?></span>
                        </div>
                        <p class="review-text"><?php echo nl2br(htmlspecialchars($rev['comment'])); ?></p>
                        <small class="review-date"><?php echo date("d.m.Y", strtotime($rev['created_at'])); ?></small>
                    </div>
                <?php endforeach; ?>

                <div class="pagination" style="text-align: center; margin-top: 30px;">
                    <?php for ($i = 1; $i <= $total_pages; $i++): ?>
                        <a href="?page=<?php echo $i; ?>&rating=<?php echo $filter_rating; ?>"
                            style="margin: 0 5px; padding: 8px 12px; background: <?php echo $i == $page ? '#ff4d4d' : '#eee'; ?>; color: <?php echo $i == $page ? '#fff' : '#333'; ?>; text-decoration: none; border-radius: 4px;">
                            <?php echo $i; ?>
                        </a>
                    <?php endfor; ?>
                </div>
            <?php endif; ?>
        </section>

        <div style="text-align: center; margin-top: 20px;">
            <a href="../HTML/restaurant-LiChun-project.php" class="back-link">← Zpět na hlavní stránku</a>
        </div>
    </div>
</body>

</html>